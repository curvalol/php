<?php
require_once __DIR__.'/../config.php';

/**
 * Класс выполняющий парсинг электронных писем из Zoho Mail API, сохраняя полученные письма в таблицу email_received,
 * а письма при отправке которых была получена ошибка в таблицу email_bounces.
 */

$zoho_account = '123456789098765432';
$zoho_token = 'qwertyuiopasdfghjklzxcvbnm123456';
$zoho_message_folders = [
    'Spam' => '987654321123456789',
    'Inbox' => '265553000000002013',
    'Inbox' => '123456789009876543',
    'ZMNotification' => '265553000000002031',
    'ZMNotification' => '543211234567890123',
];


class ZohoMailAPI
{
    protected
        $account,
        $token,
        $folders,
        $currentFolder,
        $currentFolderName,
        $currentMessage,
        $currentMailData,
        $baseUrl = 'http://mail.zoho.eu/api/accounts/',
        $headers = array(),
        $parse_mail_counter = [
        'received' => 0,
        'bounced'  => 0
    ];

    const
        DESCRIBED_REQUEST = ['mail_list', 'mail_content'],
        REQUEST_URL = [
        'mail_list' => '/messages/view',
        'mail_content' => '/folders/[[__FOLDER__]]/messages/[[__MESSAGE__]]/content',
    ],
        SEARCH_MARKERS = ['[[__FOLDER__]]', '[[__MESSAGE__]]'],
        REG_EXP = [
        'to' => '/To:\s\<a\shref\=\"mailto\:.+?\"\starget\=\"\_blank\"\>(.+?\@.+?)\<\/a/i',
        'subject' => '/Subject:\s(.+?)\<br/i',
    ];

    public function __construct($account, $token, $folders)
    {
        $this->account = $account;
        $this->token = $token;
        $this->baseUrl .= $account;
        $this->headers[] = 'Authorization:Zoho-authtoken '.$token.'';
        $this->folders = $folders;
    }

    /**
     * writes new mails in Zoho API tu DB
     * @param integer $_start number of first mail in folder that used as begin of parse
     * @param integer $_perPage, number of mails received as a list by single request
     * @return nothing
     */
    public function parseMails($_start = 1, $_perPage = 50)
    {
        $this->printLog('Start parsing mails from ZOHO API');
        $_offset = $_start;

        foreach ($this->folders as $folder_name => $folder_id) {
            $this->currentFolder = $folder_id;
            $this->currentFolderName = $folder_name;
            $last_message_id = max(EmailBouncesTable::getMaxZohoMessageId($folder_id), EmailReceivedTable::getMaxZohoMessageId($folder_id));

            do {
                $reqArgs = [
                    'folderId' => $this->currentFolder,
                    'fields' => 'messageId,subject,receivedTime,fromAddress',
                    'sortorder' => 'false',
                    'sortBy' => 'messageid',
                    'limit' => $_perPage,
                    'start' => $_offset
                ];

                $response = $this->requestGet($this->getRequestUrl('mail_list', $reqArgs));
                $responseNotEmpty = $response !== null && isset($response[0]) && count($response[0]) !== 0;

                if ($responseNotEmpty) {
                    foreach ($response as $mail_data) {
                        if(count($mail_data) == 0){
                            continue;
                        }

                        if($mail_data['messageId'] <= $last_message_id) {
                            break 2;
                        }

                        $this->currentMessage = $mail_data['messageId'];
                        $this->getCurrentMailData();


                        if ($this->checkIfMailNotBounced($mail_data)) {
                            $received_mail = new EmailReceived;
                            $received_mail->setEmail($mail_data['fromAddress']);
                            $received_mail->setToEmail('no-replay@agnostic.com');
                            $received_mail->setSubject($mail_data['subject']);
                            $received_mail->setBody($this->currentMailData['content']);
                            $received_mail->setReceivedTime(date("Y-m-d H:i:s", $mail_data['receivedTime'] / 1000));
                            $received_mail->setMessageId($this->currentMessage);
                            $received_mail->setFolderName($this->currentFolderName);
                            $received_mail->setFolderId($this->currentFolder);
                            $received_mail->save();

                            $this->parse_mail_counter['received'] += 1;
                        }
                    }

                    $_offset += $_perPage;
                }
            } while ($responseNotEmpty);
        }
        $this->printLog(sprintf('New received emails: %d', $this->parse_mail_counter['received']));
        $this->printLog(sprintf('New bounced emails: %d', $this->parse_mail_counter['bounced']));
    }

    /**
     * check if current mail is bounced and writes its data to DB if it does
     * @param array $mail_data, data received with list of mails from API
     * @return boolean, true if mail is not bounced, false if it does
     */
    protected function checkIfMailNotBounced($mail_data)
    {
        if ($mail_data['subject'] == 'Delivery Status Notification (Failure)') {

            if(!preg_match(self::REG_EXP['to'], $this->currentMailData['content'], $match)) {
                return false;
            }
            $to = $match[1];

            if(!preg_match(self::REG_EXP['subject'], $this->currentMailData['content'], $match)) {
                return false;
            }
            $subject = $match[1];

            if (!empty($to) && !empty($subject)) {
                $email_bounce = new EmailBounces();
                $email_bounce->setEmail($to);
                $email_bounce->setSubject($subject);
                $email_bounce->setBounceTime(date("Y-m-d H:i:s", $mail_data['receivedTime'] / 1000));
                $email_bounce->setMessageId($this->currentMessage);
                $email_bounce->setFolderName($this->currentFolderName);
                $email_bounce->setFolderId($this->currentFolder);
                $email_bounce->save();
                $this->parse_mail_counter['bounced'] += 1;
            }
            return false;
        } else {
            return true;
        }
    }

    /**
     * build API request url
     * @param string $reqType, described type of request
     * @param array $args, GET arguments that must be added to returned url
     * @return string, built url
     */
    protected function getRequestUrl($reqType, $args = [])
    {
        if (in_array($reqType, self::DESCRIBED_REQUEST)) {
            $url = $this->baseUrl;

            switch ($reqType) {
                case 'mail_list':
                    $url .= self::REQUEST_URL[$reqType];
                    break;
                case 'mail_content':
                    if ($this->checkCurrentPosition()) {
                        $url .= str_replace(self::SEARCH_MARKERS, $this->getCurrentPosition(), self::REQUEST_URL[$reqType]);
                    } else {
                        self::printError('Can\'t create URL to mail content');
                    }
                    break;
                default:
                    break;
            }

            if (is_array($args) && count($args) > 0) {
                $url .= '?';
                foreach ($args as $argument => $value) {
                    $url .= $argument.'='.$value.'&';
                }
                $url = substr($url, 0, -1);
            }

            return $url;
        }
    }

    /**
     * send GET request to Zoho API, and return received data
     * @param string $url, url that used in request
     * @return array, data received by requesting of API, or NULL if request fails
     */
    protected function requestGet($url)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $this->headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $response = json_decode(curl_exec($ch), True);
        curl_close($ch);
        if ($response['status']['code'] == 200) {
            return $response['data'];
        } else {
            var_dump($response);
            return null;
        }
    }

    protected function getCurrentMailData() {
        $this->currentMailData = $this->requestGet($this->getRequestUrl('mail_content'));
    }

    /**
     * check if seted current FolderID and MessageID
     * @return boolean, true if both seted FolderID and MessageID
     */
    protected function checkCurrentPosition()
    {
        if (!empty($this->currentFolder)) {
            if (!empty($this->currentMessage)) {
                return true;
            } else {
                self::printError('Current message is not defined');
                return false;
            }
        } else {
            self::printError('Current folder is not defined');
            return false;
        }
    }

    /**
     * returns current MessageID and FolderID, used by method parseMails()
     * @return array [<folderId>, <messageId>]
     */
    protected function getCurrentPosition()
    {
        if ($this->checkCurrentPosition()) {
            return [$this->currentFolder, $this->currentMessage];
        } else {
            self::printError('Can\'t get current position');
        }
    }

    /**
     * print log to document
     * @param string $log that must be printed
     * @return nothing
     */
    public function printLog($log)
    {
        echo self::log($log).PHP_EOL;
    }

    /**
     * prints an error to page. Method used to print errors of the class work
     * @param string $error that must be printed
     * @return nothing
     */
    protected static function printError($error)
    {
        echo 'ERROR:'.self::log($error).PHP_EOL;
    }

    /**
     * return formated log string and current date. Common method used in class
     * @param string $message that must be logged
     * @return string value of formated message and current date
     */
    protected static function log($message)
    {
        return sprintf('[%s] %s', date('d.m.Y H:i:s'), $message);
    }
}

$api = new ZohoMailAPI($zoho_account, $zoho_token, $zoho_message_folders);
$api->parseMails();
