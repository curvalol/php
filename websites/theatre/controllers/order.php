<?php
/**
* 
*/
class OrderController extends Controller {
  public function returnBack() {
    header('Location: /index.php?route=home');
    exit;    
  }

  public function index() {
    if (is_array($_POST['orderedSeats'])) {
      $ordered = $_POST['orderedSeats'];
    } elseif (is_string($_POST['orderedSeats'])) {
      $ordered = explode(',', $_POST['orderedSeats']);
    }
    //проверка на наличие выбранных мест
    if (count($ordered) == 0) {
      $_SESSION['err'] = 'Выберите места, билеты на которые хотите приобрести!';
      $this->returnBack();
    } 

    //проверка на количество выбранных мест
    $max = mysqli_fetch_row(mysqli_query($this->db, "SELECT information_value FROM order_information WHERE information_name='max_ordered'"))['0'];
    if (count($ordered) > $max) {
      $_SESSION['err'] = 'Выбрано слишком много мест. Максимально возможно количество купленных билетов - '.$max;
      $this->returnBack();
    }

    //проверка количества купленных билетов
    if (!empty($_SESSION['auth'])) {
      $ordered_count = mysqli_fetch_row(mysqli_query($this->db, "SELECT COUNT(seat_id) FROM tickets WHERE user_id='".$_SESSION['auth']."'"))['0'];
      if ($ordered_count == $max) {
        $_SESSION['err'] = 'Вы уже приобрели максимальное количество билетов на данный спектакль. Дополнительный заказ невозможен.';        
          $this->returnBack();
      }
      if (count($ordered) > ($max - $ordered_count)) {
        $_SESSION['err'] = 'Выбрано слишком много мест. Максимально возможно количество купленных билетов - '.$max . '. Сейчас Вами куплено ' . $ordered_count . ' билетов. Дополнительно Вы можете купить еще ' . ($max - $ordered_count) . ' билетов.';        
          $this->returnBack();
      }
    }

    //Обработка отмеченных билетов
    $content['tickets'] = array();
    $content['ordered_id'] = array();
    $content['summCost'] = 0;

    foreach ($ordered as $seat) {
      $q = mysqli_query($this->db, "SELECT s.seat_id, s.seat_number, s.seat_row, c.price, c.category_name FROM seat s LEFT JOIN category c ON c.category_id = s.category_id WHERE s.seat_id='".$seat."'");
      $r = array();
      while ($r[] = mysqli_fetch_assoc($q)) { $seatInfo = $r; }
      $content['tickets'][] = $seatInfo['0'];
      $content['ordered_id'][] = $seatInfo['0']['seat_id'];
      $content['summCost'] += $seatInfo['0']['price'];
    }
    $content['ordered_id'] = implode(',', $content['ordered_id']);

    //Проверка авторизации
    if (!empty($_SESSION['auth'])) {
      $user_q = mysqli_query($this->db, "SELECT login, email, name, surname FROM user WHERE user_id='".$_SESSION['auth']."'");
      $r = array();
      while ($r[] = mysqli_fetch_assoc($user_q)) {
        $user = $r['0'];
      }
      //заполнение данных о имени пользователя
      if (!empty($user['name']) || !empty($user['surname'])) {
        $content['user_name'] = $user['surname'] . ' ' . $user['name'];
      } else {
        if (!empty($user['login'])) {
          $content['user_name'] = $user['login'];
        } else {
          $content['user_name'] = 'Гость';
        }
      }
      //заполнение контактных данных пользователя
      $content['email'] = $user['email'];
    }

    //Обработка подтверждения
    if (!empty($_POST['confirm'])) {
      $registered = false;
      if (!empty($_SESSION['auth'])) {
        $id = $_SESSION['auth'];
        $registered = true;
      }
      if (!empty($_POST['newUser'])) {
        $validate = new Validate('registration', 'user', HOST, USER, PASSWORD, DATABASE);
        $validate->uniqLogin($_POST['login'], 'login');
        $validate->password($_POST['pass'], $_POST['rep_pass'], 'password');
        $validate->uniqMail($_POST['email'], 'email');
        $validate->agree($_POST['agree']);

        if ($validate->validated()) {
          mysqli_query($validate->database, "INSERT INTO user SET login='".$validate->val['login']."', password='".$validate->val['password']."', email='".$validate->val['email']."', type='user'");
          $id = mysqli_fetch_row(mysqli_query($validate->database, "SELECT user_id FROM user WHERE login='".$validate->val['login']."'"))['0'];
          $_SESSION['auth'] = $id;
          $registered = true;
        } else {
          $validate->endValidation();
        }
      }      
      if ($registered) {
        foreach ($ordered as $ticket) { 
          mysqli_query($this->db, "INSERT INTO tickets SET order_name='". ((string)time() . '_' . $id) ."', user_id='".$id."', seat_id='".$ticket."', order_status_id='1'");
        }
        $_SESSION['err'] = 'Ваш заказ принят!';
        header('Location: /index.php?route=home');
      }
    }

    $this->viewName = 'order';
    $header['title'] = 'Подтверждения заказа';
    $content['h1'] = 'Подтвердите выбранные Вам билеты';
    $this->getFullView($header, $content);
  }
}
$OrderController = new OrderController;

?>