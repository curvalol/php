<?php getHeader($data); ?>
<h1><?php echo $data['h1']; ?></h1>
<p><?php echo $data['desc']; ?></p>
<?php getCatalog([
	'start' => !empty($_GET['page']) ? $_GET['page'] - 1 : '',
	'category' => $_GET['category_id'],
	'show_category' => 'no'
]);?> 


<?php getFooter(); ?>