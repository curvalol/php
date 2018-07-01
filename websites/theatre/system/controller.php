<?php
/**
* 
*/
class Controller {

  public $viewName;
  public $db;

  protected function view($name, $data = '') {    
    return require_once $_SERVER['DOCUMENT_ROOT'] . '/view/'.trim($name).'.php';
  }

  protected function header($headerData = '') {
    return require_once $_SERVER['DOCUMENT_ROOT'] . '/controllers/header.php';
  }
  protected function footer() {
    return require_once $_SERVER['DOCUMENT_ROOT'] . '/controllers/footer.php';
  }

  public function getFullView($headerData = '', $pageData = '') {
    $this->header($headerData);
    $this->view($this->viewName, $pageData);
    $this->footer();
  }

  public function index() {}

  function __construct ($data = '') {
    $this->db = mysqli_connect(HOST, USER, PASSWORD, DATABASE);
    if (empty($data)) {
      $this->index();
    } else {
      $this->index($data);
    }
  }


}

?>