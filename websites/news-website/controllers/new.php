<?php 
$data['new_data'] = db_select("SELECT * FROM news WHERE news_id='".$_GET['new_id']."'");
$data['new_data'] = $data['new_data']['0'];
$data['title'] = $data['new_data']['news_name'];

getView('new', $data)
?>