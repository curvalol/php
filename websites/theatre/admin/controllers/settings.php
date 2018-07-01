<?php  
/**
* 
*/
class SettingsController extends AdminController {
  public function index() {
    $this->viewName = 'settings';
    $header['title'] = 'Панель администратора';
    $content['h1'] = 'Настройки зала';

    if (!empty($_POST)) {
      $temp = array();
      $order_status = array();
      $information = array();

      foreach ($_POST as $k => $v) {
        if (strpos($k, 'order_status') === 0) {
          $temp[str_replace('order_status_', '', $k)] = $v;
        } elseif (strpos($k, 'information_') === 0) {
          $information[str_replace('information_', '', $k)] = $v;
        }
      }

      foreach ($temp as $k => $v) {
        $order_status[explode('_', $k)[1]][explode('_', $k)[0]] = $v;
        $field = explode('_', $k)[0];
        $id = explode('_', $k)[1];
      } 

      foreach ($order_status as $id => $fields) {
        mysqli_query($this->db, "UPDATE order_status SET order_status_name='".$fields['name']."', order_status_hint='".$fields['hint']."' WHERE order_status_id='".$id."'");
      }

      foreach ($information as $id => $val) {
        mysqli_query($this->db, "UPDATE order_information SET information_value='".$val."' WHERE information_id='".$id."'");
      }
    }

    $q = mysqli_query($this->db, "SELECT * FROM order_information");
    $r = array();
    while ($r[] = mysqli_fetch_assoc($q)) { $content['order_information'] = $r; }

    $q = mysqli_query($this->db, "SELECT * FROM order_status");
    $r = array();
    while ($r[] = mysqli_fetch_assoc($q)) { $content['order_status'] = $r; }

    $this->getFullView($header, $content);
  }
}

$home = new SettingsController;
?>