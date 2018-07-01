<?php
session_start();
mb_internal_encoding('UTF-8');

// Подключение файла с функцией reques()
require_once $_SERVER['DOCUMENT_ROOT'] . "/system/request.php";
// Подключение конфига с БД
require_once $_SERVER['DOCUMENT_ROOT'] . "/config.php";
// Подключение БД
$db_connect = mysqli_connect(HOST, USER, PASSWORD, DATABASE);

// Объявление переменных со значениями для создания записи в БД
$name = $_POST['name'];
$category = !empty($_POST['category']) ? $_POST['category'] : '1';
$date = time();
$desc = $_POST['desc'];
$shortdesc = $_POST['shortdesc'];
$img = '/img/' . basename($_FILES['img']['name']) != '' ? basename($_FILES['img']['name']) : 'no_image.jpg';

//Перемещение выгруженного файла в директорию с изображениями
$upload_dir = $_SERVER['DOCUMENT_ROOT'] . '/img/';
$upload_file = $upload_dir . basename($_FILES['img']['name']);
move_uploaded_file($_FILES['img']['tmp_name'], $upload_file);

//Добавление записи в БД
$sql_insert = "INSERT INTO news SET news_name='".$name."', category_id='".$category."', date='".$date."', description='".$desc."', short_description='".$shortdesc."', news_image='".$img."'";
mysqli_query($db_connect, $sql_insert);

//Возвращение к админ. панели
header('Location: /admin/');
exit;
?>