<?php 
class UserController extends Controller {
	public function index() {
    if (empty($_SESSION['auth'])) {
      header('Location: /');
      exit;
    }

		$this->viewName = 'user';
    $header['title'] = 'Личный кабинет пользователя';
    $content['h1'] = 'Кабинет';

    //внесение изменений
    if (!empty($_POST)) {
      if ($_POST['form_type'] == 'del_ticket') {
        if (count($_POST['tickets']) > 0) {
          foreach ($_POST['tickets'] as $ticket_id) {
            $sql = "
              UPDATE tickets
              SET order_status_id=3
              WHERE ticket_id='".$ticket_id."'
            ";
            mysqli_query($this->db, $sql);
          }
          $content['mes'] = 'Выбранные билеты были удалены';
        } else {
          $content['mes'] = 'Чтобы удалить, выберите по крайней мере один билет';
        }
      } elseif ($_POST['form_type'] == 'user_info') {

        $current = mysqli_fetch_assoc(mysqli_query($this->db, "SELECT * FROM user WHERE user_id='".$_SESSION['auth']."'"));
        if (stripos($_POST['email'], '@')) {
          if ($_POST['email'] != $current['email']) { 
            $sql = "
              SELECT user_id
              FROM user
              WHERE email='".$_POST['email']."'
            ";
            $conj = mysqli_fetch_assoc(mysqli_query($this->db, $sql));
            if (empty($conj)) {
              $sql = "
                UPDATE user
                SET email='".$_POST['email']."'
                WHERE user_id='".$_SESSION['auth']."'
              ";
              mysqli_query($this->db, $sql);
            } else {
              $content['mes'] .= ' Такая почта уже существует.';
            }
          }
        }

        if ($_POST['name'] != $current['name']) {
          if (strlen($_POST['name']) > 4) {
            $sql = "
              UPDATE user
              SET name='".$_POST['name']."'
              WHERE user_id='".$_SESSION['auth']."'
            ";
            mysqli_query($this->db, $sql);
          }
        }

        if ($_POST['surname'] != $current['surname']) {
          if (strlen($_POST['surname']) > 4) {
            $sql = "
              UPDATE user
              SET surname='".$_POST['surname']."'
              WHERE user_id='".$_SESSION['auth']."'
            ";
            mysqli_query($this->db, $sql);
          }
        }

        if (''.$_POST['phone'] != $current['phone']) {
          if (strlen($_POST['phone']) > 9) {
            $sql = "
              UPDATE user
              SET phone='".''.$_POST['phone']."'
              WHERE user_id='".$_SESSION['auth']."'
            ";
            mysqli_query($this->db, $sql);
          }
        }
      }
    }

    //Извлечени из БД и сохранение в массиве информации о пользователе
    $user = mysqli_fetch_assoc(mysqli_query($this->db, "SELECT * FROM user WHERE user_id='".$_SESSION['auth']."'"));
    unset($user['user_id'], $user['type']);
    foreach ($user as $k => $v) {
      $content[$k] = $v;
    }

    //Извлечение из БД данных о активных бронях билетов пользователем
    $sql = "
      SELECT t.ticket_id, t.order_name, s.seat_number, s.seat_row, c.category_name, c.price, os.order_status_name
      FROM tickets t
      LEFT JOIN order_status os ON t.order_status_id = os.order_status_id
      LEFT JOIN seat s ON t.seat_id = s.seat_id
      LEFT JOIN category c ON s.category_id = c.category_id
      WHERE t.user_id='".$_SESSION['auth']."' AND (t.order_status_id=1 OR t.order_status_id=2)
    ";
    $q = mysqli_query($this->db, $sql);
    $r = array();
    while ($r[] = mysqli_fetch_assoc($q)) { $content['tickets'] = $r; }
    $this->getFullView($header, $content);
	} 
}
$user = new UserController;
?>