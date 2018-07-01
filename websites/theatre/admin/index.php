<?php 
session_start();

require_once $_SERVER['DOCUMENT_ROOT'] . "/config.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/admin/system/controller.php";

//проверка авторизации учетной записи администратора
if (!empty($_SESSION['auth'])) {
  $db = mysqli_connect(HOST, USER, PASSWORD, DATABASE);
  $admin = mysqli_fetch_assoc(mysqli_query($db, "SELECT login FROM user WHERE user_id='".$_SESSION['auth']."' AND type='admin'"));
} else {
  $admin = '';
}

if (!empty($_SESSION['auth']) && !empty($admin)) { 
  if (!empty($_GET['route'])) {
    $filename = $_SERVER['DOCUMENT_ROOT'] . "/admin/controllers/" . $_GET['route'] . ".php";
  }

  if ($_SERVER['REQUEST_URI'] == '/admin/' || $_SERVER['REQUEST_URI'] == '/admin/index.php') {
    require_once $_SERVER['DOCUMENT_ROOT'] . "/admin/controllers/home.php";
  } elseif (!empty($filename) && file_exists($filename)) {
    require_once $filename;
  } else {
    require_once $_SERVER['DOCUMENT_ROOT'] . "/controllers/404.php";
  }
} else {
  require_once $_SERVER['DOCUMENT_ROOT'] . "/admin/controllers/authorization.php";
}
?>