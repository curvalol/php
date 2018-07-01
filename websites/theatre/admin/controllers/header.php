<?php 
/**
* 
*/
class HeaderController extends AdminController {
	public function index($indexData) {
		$data = array();
		$data['title'] = $indexData['title'];
		$data['keywords'] = $indexData['keywords'];
		$data['description'] = $indexData['description'];

		$this->view('header', $data);
	}
}
$header = new HeaderController($headerData);
?>