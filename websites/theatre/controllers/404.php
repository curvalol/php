<?php  
/**
* 
*/
class WhrongController extends Controller {
  public function index() {
    $this->viewName = '404';
    $header['title'] = '404. Театр.';
    $content['h1'] = 'Упс! Похоже такой страницы не существует';

    $this->getFullView($header, $content);
  }
}

$home = new WhrongController;
?>