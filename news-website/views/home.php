<?php getHeader($data); ?>

<h1><?php echo $data['h1']; ?></h1>

<?php getCatalog([
	'start' => !empty($_GET['page']) ? $_GET['page'] - 1 : ''
]); ?> 

<?php getFooter(); ?>