<?php
$category = db_select("SELECT category_name, category_description FROM category WHERE category_id='".$_GET['category_id']."'");
$data['title'] = 'Новости. ' . $category['0']['category_name'] . '.';
$data['h1'] = $category['0']['category_name'];
$data['desc'] = $category['0']['category_description'];

getView('category', $data);
?>