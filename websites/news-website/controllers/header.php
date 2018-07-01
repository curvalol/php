 <?php 
$category = db_select("SELECT category_id, category_name FROM category");
$data['category'] = $category;
getView('header', $data);
?>