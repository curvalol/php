<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
	<meta name="viewport" content="width=device-width" />

	<link rel="stylesheet" href="view/css/normalize.css" />
	<link rel="stylesheet" href="view/css/grid.min.css" />
	<!-- <link rel="stylesheet" href="view/style/animate.css" /> -->
	<link rel="stylesheet" href="view/css/style.css" />

	<!-- <script src="view/js/validate.min.js" defer></script> -->
	<script src="view/js/scripts.js" defer></script>

	<title><?php echo $data['title']; ?></title>
</head>
<body>
<div class="wrapper">
<header class="header">
	<div class="container">
		<div class="row">
			<a href="/" class="col-sm-2 col-sm-offset-1 logo img">
				<img src="view/img/logo.png" alt="logo">
			</a>
			<div class="col-sm-3 col-sm-offset-5">
			<?php if ($data['disable_enter'] != 'yes') { ?>
				<?php if (!empty($data['user'])) { ?>
					Привет, <?php echo $data['user']; ?>!
					<a href="/index.php?route=user">Мой кабинет</a>
					<a href="/index.php?route=home&exit=1" class="exit">Выйти!</a>
				<?php } else { ?>
					<?php if (!empty($_SESSION['auth_err'])) { ?>
					<span class="authError"><?php echo $_SESSION['auth_err']; ?>
					<?php } ?>
					<form action="/" method="post" class="authorization">
						<div class="line login">
							Логин: <input type="text" name="login" placeholder="введите логин, почту или телефон">
						</div>
						<div class="line password">
							Пароль: <input type="password" name="password" placeholder="введите пароль">
						</div>
						<div class="line submit">
							<input type="submit" value="Войти">
							<a href="/index.php?route=register" class="registration">Зарегистрироваться</a>
						</div>					
					</form>
				<?php } ?>
			<?php } ?>
			</div>
		</div>
	</div>
</header>
<main>
	<div class="container main">

 