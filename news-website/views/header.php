<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
	<meta name="viewport" content="width=device-width" />

	<link rel="stylesheet" href="views/style/normalize.css" />
	<link rel="stylesheet" href="views/style/grid.min.css" />
	<!-- <link rel="stylesheet" href="views/style/animate.css" /> -->
	<link rel="stylesheet" href="views/style/style.css" />

	<!-- <script src="js/validate.min.js" defer></script> -->
	<script src="views/js/scripts.js" defer></script>

	<title><?php echo $data['title']; ?></title>
</head>
<body>
<div class="wrapper">
<header class="header">
	<div class="container">
		<div class="row">
			<a href="/" class="col-sm-2 img logo">
				<img src="img/logo.png" alt="logo">
			</a>
			<div class="col-sm-10">
				<nav class="header_nav">
					<a href="/"><span>Последние новости</span></a>
					<?php foreach($data['category'] as $cat) { ?>
						<a href="<?php echo addLink('category', $cat['category_id']); ?>"><?php echo $cat['category_name']; ?></a>
					<?php } ?>
				</nav>
			</div>
		</div>
	</div>
</header>
<main>
	<div class="container main">
	


 