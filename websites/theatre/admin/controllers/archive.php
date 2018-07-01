<?php  
/**
* 
*/
class ArchiveController extends AdminController {
  public function index() {
    $this->viewName = 'archive';
    $header['title'] = 'Панель администратора';
    $content['h1'] = 'Список активных заказов';

    $sql = "
      SELECT t.ticket_id, t.order_name, os.order_status_name, s.seat_number, s.seat_row, c.category_name, u.login
      FROM tickets t 
      LEFT JOIN seat s ON t.seat_id = s.seat_id
      LEFT JOIN category c ON s.category_id = c.category_id
      LEFT JOIN order_status os ON t.order_status_id = os.order_status_id
      LEFT JOIN user u ON t.user_id = u.user_id
      WHERE t.order_status_id=3 OR t.order_status_id=4
    ";
    $q = mysqli_query($this->db, $sql);
    $r = array();
    while ($r[] = mysqli_fetch_assoc($q)) { $content['tickets'] = $r; }

    $this->getFullView($header, $content);
  }
}

$home = new ArchiveController;
?>