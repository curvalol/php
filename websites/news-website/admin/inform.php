<?php
session_start();
mb_internal_encoding('UTF-8');

// Подключение файла с функцией reques()
require_once $_SERVER['DOCUMENT_ROOT'] . "/system/request.php";
// Подключение конфига с БД
require_once $_SERVER['DOCUMENT_ROOT'] . "/config.php";
// Подключение БД
$db_connect = mysqli_connect(HOST, USER, PASSWORD, DATABASE); 

if (!empty($_POST['page_name'])) {
	$name = $_POST['page_name'];
	unset($_POST['page_name']);
	$desc = $_POST['page_desc'];
	unset($_POST['page_desc']);
	$sql_insert = "INSERT INTO information SET inform_name='".$name."', inform_description='".$desc."'";
	mysqli_query($db_connect, $sql_insert);

	var_dump($sql_insert);
}

if (!empty($_POST)) {
	foreach ($_POST as $k => $v) {
		$sql_del = "DELETE FROM information WHERE inform_id='".$v."'";
		mysqli_query($db_connect, $sql_del);
	}
}


//Возвращение к админ. панели
header('Location: /admin/index.php?route=inform');
exit;

?>