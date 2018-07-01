<?php

function getView($name, $data = '') {
  return require_once $_SERVER['DOCUMENT_ROOT'] . '/views/' . $name . '.php';
}
function getHeader($data = '') {
  return require_once $_SERVER['DOCUMENT_ROOT'] . '/controllers/header.php';
}
function getFooter($data = '') {
  return require_once $_SERVER['DOCUMENT_ROOT'] . '/controllers/footer.php';
}
function db_select($sql, $h = HOST, $u = USER, $p = PASSWORD, $db = DATABASE) {
  $db_connect = mysqli_connect($h, $u, $p, $db);
  mysqli_query($db_connect, "SET CHARSET UTF8");
  $query = mysqli_query($db_connect, $sql);
  while ($res[] = mysqli_fetch_assoc($query)) { $val = $res; }
  return $val;
}
function db_update($sql, $h = HOST, $u = USER, $p = PASSWORD, $db = DATABASE) {
  $db_connect = mysqli_connect($h, $u, $p, $db);
  mysqli_query($db_connect, "SET CHARSET UTF8");
  mysqli_query($db_connect, $sql);
}
?>