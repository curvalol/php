<?php  
/**
* 
*/
class HomeController extends AdminController {
  public function index() {
    $this->viewName = 'home';
    $header['title'] = 'Панель администратора';
    $content['h1'] = 'Список активных заказов';

    if (!empty($_POST['action']) && count($_POST['tickets']) > 0) {
      foreach ($_POST['tickets'] as $ticket) {
        mysqli_query($this->db, "UPDATE tickets SET order_status_id='".$_POST['action']."' WHERE ticket_id='".$ticket."'");
      }
    }

    $sql = "
      SELECT t.ticket_id, t.order_name, os.order_status_name, s.seat_number, s.seat_row, c.category_name, u.login
      FROM tickets t 
      LEFT JOIN seat s ON t.seat_id = s.seat_id
      LEFT JOIN category c ON s.category_id = c.category_id
      LEFT JOIN order_status os ON t.order_status_id = os.order_status_id
      LEFT JOIN user u ON t.user_id = u.user_id
      WHERE t.order_status_id=1 OR t.order_status_id=2
      ORDER BY t.order_name
    ";
    $q = mysqli_query($this->db, $sql);
    $r = array();
    while ($r[] = mysqli_fetch_assoc($q)) { $content['tickets'] = $r; }

    $q = mysqli_query($this->db, "SELECT order_status_name, order_status_id FROM order_status WHERE order_status_id > 1");
    $r = array();
    while ($r[] = mysqli_fetch_assoc($q)) { $content['actions'] = $r; }

    $this->getFullView($header, $content);
  }
}

$home = new HomeController;
?>