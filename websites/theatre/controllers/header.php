<?php 
/**
* 
*/
class HeaderController extends Controller {
	public function index($indexData) {
		$data = array();
		$data['title'] = $indexData['title'];
		$data['keywords'] = $indexData['keywords'];
		$data['description'] = $indexData['description'];
		$data['disable_enter'] = $indexData['disable_enter'];

		if (!empty($_SESSION['auth'])) {
			$data['user'] = mysqli_fetch_row(mysqli_query($this->db, "SELECT login FROM user WHERE user_id='".$_SESSION['auth']."'"))['0'];
		}

		$this->view('header', $data);
	}
}
$header = new HeaderController($headerData);
?>