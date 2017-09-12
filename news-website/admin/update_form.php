<?php 
require_once $_SERVER['DOCUMENT_ROOT'] . "/config.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/system/request.php";

$sql_upd = "UPDATE " . $_POST['table'] . " SET";
foreach ($_POST as $k => $v) {
	if ($k != 'table' && $k != $_POST['table'] . '_id') {
		$sql_upd .= " " . $k . "='" . $v . "',";
	}
}
$sql_upd = substr($sql_upd, 0, strlen($sql_upd) - 1);
$sql_upd .= " WHERE " . $_POST['table'] . '_id' . "='".$_POST[$_POST['table'] . '_id']."'";
db_update($sql_upd);

header('Location: /admin/index.php?route='.$_POST['table']);
exit;

?>