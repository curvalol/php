<?php 
$number = !empty($data['number']) ? $data['number'] : '10';
$start = !empty($data['start']) ? $data['start'] : '0';
$category = !empty($data['category']) ? $data['category'] : '0';

$sql_count = "SELECT COUNT(*) FROM news" . ;
$sql_count .= !empty($category) ? " WHERE category_id='".$category."'" : "";
$count_db = db_select($sql_count);
$count_db = $count_db['0']['COUNT(*)'];

$data['columns'] = !empty($data['columns']) ? $data['columns'] : '1';
$data['el_width'] = 12 / $data['columns'];

$sql = "SELECT n.news_id, n.news_name, n.date, n.short_description, n.news_image, n.category_id";
$sql .= $data['show_category'] == 'no' ? "" : ", c.category_name";
$sql .= " FROM news n LEFT JOIN category c ON (n.category_id=c.category_id)";
$sql .= !empty($category) ? " WHERE n.category_id='".$category."'" : "";
$sql .= " ORDER BY date DESC LIMIT ".$start*$number.", ".$number."";

$data['news_array'] = db_select($sql);

$data['count'] = count($data['news_array']);
$data['max_page'] = ceil($count_db / $number);
$data['current_page'] = $start;

getView('catalog', $data);
?>