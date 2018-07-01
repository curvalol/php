<?php 
/**
* 
*/
class FooterController extends Controller {
	public function index() {
		$this->viewName = 'footer';
		$this->view('footer');
	}
}
$footer = new FooterController;
?>