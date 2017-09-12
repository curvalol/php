<?php 
$info = db_select("SELECT information_id, inform_name FROM information");
$data['info'] = $info;
getView('footer', $data);
?>