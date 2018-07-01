<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
	<meta name="viewport" content="width=device-width" />

	<link rel="stylesheet" href="view/css/grid.min.css" />
	<!-- <link rel="stylesheet" href="view/style/animate.css" /> -->
	<link rel="stylesheet" href="view/css/style.css" />

	<!-- <script src="view/js/validate.min.js" defer></script> -->
	<script src="view/js/scripts.js" defer></script>

	<title><?php echo $data['title']; ?></title>
</head>
<body>
<div class="wrapper">
<header class="header nav">
	<a class="nav__item" href="/admin/index.php?route=home">
		Активные заказы
	</a>
	<a class="nav__item" href="/admin/index.php?route=users">
		Пользователи
	</a>
	<a class="nav__item" href="/admin/index.php?route=settings">
		Настройки зала
	</a>
	<a class="nav__item" href="/admin/index.php?route=archive">
		Архив заказов
	</a>
</header>
<main>
	<div class="container main">

 