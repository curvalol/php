<?php
/**
* 
*/
class View {

  protected $view;
  public $headerData;
  public $mainData;

  private function setHeaderData($dataName, $dataVal) {
    $this->headerData[$dataName] = $dataVal;
  }

  private function getHeaderData($dataName) {
    if (isset($this->headerData[$dataName])) {
      return $this->headerData[$dataName];
    }
  }

  public function title($val = '') {
    if (!empty($val)) {
      self::setHeaderData('title', $val);
    } else {
      self::getHeaderData('title');
    }
  }

  public function data($name, $val) {
    $this->mainData[$name] = $val;
  }

  private function view($name, $data = '') {    
    return require_once $_SERVER['DOCUMENT_ROOT'] . '/view/'.trim($name).'.php';
  }

  private function header($data) {
    return self::view('header', $data);
  }
  private function footer() {
    return self::view('footer');
  }

  function __construct ($viewName) {
    $this->view = $viewName;
  }

  function __destruct () {
    $headerData = $this->headerData;
    return self::header($headerData);

    $mainData = $this->mainData;
    return self::view($this->view, $mainData);

    return self::footer();
  }
}

?>