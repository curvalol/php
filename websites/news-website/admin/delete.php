<?php
session_start();
mb_internal_encoding('UTF-8');

// Подключение файла с функцией reques()
require_once $_SERVER['DOCUMENT_ROOT'] . "/system/request.php";
// Подключение конфига с БД
require_once $_SERVER['DOCUMENT_ROOT'] . "/config.php";
// Подключение БД
$db_connect = mysqli_connect(HOST, USER, PASSWORD, DATABASE);


// Проверка на наличие отмеченных записей
if (empty($_POST)) {	
  header('Location: /admin/');
  exit;
}

// Удаление записи(-ей)
foreach ($_POST as $id) {
  $sql_del = "DELETE FROM news WHERE news_id='".$id."'";
  mysqli_query($db_connect, $sql_del);
}

//Возвращение к админ. панели
header('Location: /admin/index.php?route=news');
exit;
?>