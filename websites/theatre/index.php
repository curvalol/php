<?php 
session_start();

if (!empty($_GET['route'])) {
  $filename = $_SERVER['DOCUMENT_ROOT'] . "/controllers/" . $_GET['route'] . ".php";
}
require_once $_SERVER['DOCUMENT_ROOT'] . "/config.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/system/classes.php";


if ($_SERVER['REQUEST_URI'] == '/' || $_SERVER['REQUEST_URI'] == '/index.php') {
  require_once $_SERVER['DOCUMENT_ROOT'] . "/controllers/home.php";
} elseif (!empty($filename) && file_exists($filename)) {
  require_once $filename;
} else {
  require_once $_SERVER['DOCUMENT_ROOT'] . "/controllers/404.php";
}
?>