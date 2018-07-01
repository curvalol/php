<?php  
/**
* 
*/
class UsersController extends AdminController {
  public function index() {
    $this->viewName = 'users';
    $header['title'] = 'Панель администратора';
    $content['h1'] = 'Список пользователей';

    $sql = "
      SELECT user_id, login, phone, email
      FROM user
      WHERE type='user'
    ";
    $q = mysqli_query($this->db, $sql);
    $r = array();
    while ($r[] = mysqli_fetch_assoc($q)) { $users = $r; }
    $new_orders_keys = array();
    foreach ($users as $key => $user) {
      $sql = "
        SELECT ticket_id
        FROM tickets
        WHERE 
          order_status_id = '1'
            AND
          user_id=".$user['user_id']."
        ";
      if (mysqli_fetch_array(mysqli_query($this->db, $sql))) {
        $new_orders_keys[] = $key;
      }
    }

    for ($i = 0; $i < count($new_orders_keys); $i++) {
      $new_order_user = array_splice($users, $new_orders_keys[$i] - $i, 1);
      $new_order_user['0']['new_order'] = true;
      $content['users'][] = $new_order_user['0'];
    }

    $content['users'] = array_merge($content['users'], $users);

    $this->getFullView($header, $content);
  }
}

$home = new UsersController;
?>