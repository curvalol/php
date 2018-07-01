<?php 
/**
* 
*/
class FooterController extends AdminController {
	public function index() {
		$this->viewName = 'footer';
		$this->view('footer');
	}
}
$footer = new FooterController;
?>