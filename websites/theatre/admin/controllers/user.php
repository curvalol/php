<?php  
/**
* 
*/
class UserController extends AdminController {
  public function index() {
    $this->viewName = 'user';
    $header['title'] = 'Панель администратора';
    $content['h1'] = 'Данные пользователя ';

    if (empty($_GET['user_id'])) {
      header('Location: /admin/index.php?route=users');
      exit;
    } else {
      $content['user_id'] = $_GET['user_id'];
    }

    if (!empty($_POST)) {
      if ($_POST['form_type'] == 'user_data') {
        foreach (array_slice($_POST, 1) as $field => $value) {
          mysqli_query($this->db, "UPDATE user SET ".$field."='".$value."' WHERE user_id='".$_GET['user_id']."'");
        }
      } elseif ($_POST['form_type'] == 'user_tickets') {
        foreach ($_POST['tickets'] as $ticket_id) {
          mysqli_query($this->db, "UPDATE tickets SET order_status_id='".$_POST['order_status_id']."' WHERE ticket_id='".$ticket_id."'");
        }
      }
    }

    $user = mysqli_fetch_array(mysqli_query($this->db, "SELECT login, name, surname, phone, email FROM user WHERE user_id='".$content['user_id']."'"));
    foreach ($user as $k => $v) {
      $content[$k] = $v;
    }
    $sql = "
      SELECT t.ticket_id, t.order_name, s.seat_number, s.seat_row, c.category_name, c.price, os.order_status_name, t.order_status_id
      FROM tickets t 
      LEFT JOIN seat s ON(t.seat_id=s.seat_id)
      LEFT JOIN category c ON (s.category_id=c.category_id)
      LEFT JOIN order_status os ON(t.order_status_id=os.order_status_id)
      WHERE t.user_id='".$content['user_id']."'
      ORDER BY t.order_status_id
    ";
    $q = mysqli_query($this->db, $sql);
    $r = array();
    while ($r[] = mysqli_fetch_assoc($q)) { $content['user_orders'] = $r; }
    $content['h1'] .= ' ' . $content['login'];

    $this->getFullView($header, $content);
  }
}

$home = new UserController;
?>