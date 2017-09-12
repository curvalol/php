<?php
session_start();
mb_internal_encoding('UTF-8');

// Подключение файла с функцией reques()
require_once $_SERVER['DOCUMENT_ROOT'] . "/system/request.php";
// Подключение конфига с БД
require_once $_SERVER['DOCUMENT_ROOT'] . "/config.php";
// Подключение БД
$db_connect = mysqli_connect(HOST, USER, PASSWORD, DATABASE); 

if (!empty($_POST['category_name'])) {
	$name = $_POST['category_name'];
	unset($_POST['category_name']);
	if (!empty($_POST['category_desc'])) {
		$desc = $_POST['category_desc'];
		unset($_POST['category_desc']);
	} else {
		$desc = 'Последние новости категории '.$name;
	}
	$sql_insert = "INSERT INTO category SET category_name='".$name."', category_description='".$desc."'";
	mysqli_query($db_connect, $sql_insert);
}

if (!empty($_POST)) {
	foreach ($_POST as $k => $v) {
		$sql_del = "DELETE FROM category WHERE category_id='".$v."'";
		mysqli_query($db_connect, $sql_del);
	}
}


//Возвращение к админ. панели
header('Location: /admin/index.php?route=category');
exit;

?>