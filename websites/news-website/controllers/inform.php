<?php
$sql = "SELECT * FROM information WHERE information_id='".$_GET['inform_id']."'";
$data['inform'] = db_select($sql);
$data['inform'] = $data['inform']['0'];
$data['title'] = $data['inform']['inform_name'];

getView('inform', $data);

?>