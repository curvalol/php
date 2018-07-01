<?php
/**
* 
*/
class RegisterController extends Controller {
	public function index() {
		//На всякйи случай очистка авторизации
		if (!empty($_SESSION['auth'])) { unset($_SESSION['auth']);}
		if (!empty($_SESSION['auth_err'])) { unset($_SESSION['auth_err']);}

		if (!empty($_POST)) {
			$validate = new Validate('registration', 'user', HOST, USER, PASSWORD, DATABASE);
			$validate->uniqLogin($_POST['login'], 'login');
			$validate->password($_POST['pass'], $_POST['rep_pass'], 'password');
			$validate->uniqMail($_POST['email'], 'email');
			$validate->agree($_POST['agree']);

			if ($validate->validated()) {
				mysqli_query($this->db, "INSERT INTO user SET login='".$validate->val['login']."', password='".$validate->val['password']."', email='".$validate->val['email']."', type='user'");
				$_SESSION['message'] = 'Регистрация выполнена успешно';
			} else {
				$validate->endValidation();
			}
		}

		//Базовые данные для запуска вьюхи
		$this->viewName = 'register';
		$header['title'] = 'Регистрация';
		$header['disable_enter'] = 'yes';
		$content['h1'] = 'Регистрация нового пользователя';

		//Вызов вьюхи
		$this->getFullView($header, $content);
	}
}

$register = new RegisterController;
?>