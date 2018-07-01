<?php  
/**
* 
*/
class HomeController extends AdminController {
  public function index() {
    if (empty($_POST['login']) && empty($_POST['password'])) {
      $this->viewName = 'authorization';
      $header['title'] = 'Панель администратора. Авторизация';
      $content['h1'] = 'Авторизируйтесь';

      $this->getFullView($header, $content);      
    } else {
      $admin = mysqli_fetch_array(mysqli_query($this->db, "SELECT user_id FROM user WHERE login='".$_POST['login']."' AND password='".$_POST['password']."' AND type='admin'"))[0];
      if (!empty($admin)) {
        $_SESSION['auth'] = $admin;
        header('Location: /admin/index.php');
      }
    }
  }
}

$home = new HomeController;
?>