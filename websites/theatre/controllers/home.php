<?php

class HomeController extends Controller {
	public function index() {
		$this->viewName = 'home';
		$header['title'] = 'Главная страница сайта. Театр.';
		$content['h1'] = 'Онлайн бронь билетов';
		$content['amph'] = new CategorySeats('1');
		$content['parter'] = new CategorySeats('2');
		$content['balkon'] = new CategorySeats('3');
		$content['lbalkon'] = new CategorySeats('4');
		$content['rbalkon'] = new CategorySeats('5');

		if (empty($_GET['route'])) {
			$_SESSION['err'] = '';
		}

		//Авторизация
		if (!empty($_POST['login']) || !empty($_POST['password'])) {
			if (!empty($_POST['login']) && !empty($_POST['password'])) {
				$sql = "
					SELECT user_id
					FROM user
					WHERE (login='".$_POST['login']."' AND password='".$_POST['password']."') OR (email='".$_POST['login']."' AND password='".$_POST['password']."') OR (phone='".$_POST['login']."' AND password='".$_POST['password']."')
				";
				$user_id = mysqli_fetch_row(mysqli_query($this->db, $sql))['0'];
				if (!empty($user_id)) {
					$_SESSION['auth'] = $user_id;
					unset($_SESSION['auth_err']);
				} else {
					$_SESSION['auth_err'] = 'Неверно указан логин или пароль!';
					unset($_SESSION['auth']);
				}
			} else {
				$_SESSION['auth_err'] = 'Заполните оба поля, и логин и пароль';
			}
		} else {
			unset($_SESSION['auth_err']);
		}

		if (!empty($_SESSION['auth']) && !empty($_SESSION['auth_err'])) {
			unset($_SESSION['auth_err']);
		}
		//Выход
		if ($_GET['exit'] == 1) {
			unset($_SESSION['auth'], $_SESSION['auth_err']);
		}

		$this->getFullView($header, $content);
	}
}

$home = new HomeController;
?>