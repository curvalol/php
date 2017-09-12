<div class="catalog">
<?php for($i = 0; $i < $data['count']; $i += $data['columns']) { ?>

	<!-- Для редактирования -->
<div class="row">
	<!--  -->

	<?php for($n = $i; $n < $i + $data['columns']; $n++) { 
		$new = $data['news_array'][$n];
		if (!empty($new)) {
	?>

	<!-- Для редактирования -->
		<div class="col-sm-<?php echo $data['el_width']; ?> news_item">
			<div class="row">
				<div class="col-sm-4">
					<div class="img news_item_image">
						<img src="<?php echo $new['news_image']; ?>" alt="news image">
					</div>					
				</div>
				<div class="col-sm-8">
					<span class="news_item_date"><?php echo date('d.m.Y h:i', $new['date']); ?></span>
					<h5 class="news_item_title">
						<?php echo $new['news_name']; ?>					
					</h5>
					<div class="news_item_short_desc">
						<?php echo $new['short_description']; ?>
					</div>
					<a href="<?php echo addLink('new', $new['news_id']); ?>" class="news_link">
						Подробнее
					</a>
					<?php if(!empty($new['category_name'])) { ?>					
					  <br/>
					  <span class="category_tag"><a href="<?php echo addLink('category', $new['category_id']); ?>"><?php echo $new['category_name']; ?></a></span>
					<?php } ?>		
				</div>
			</div>
		</div>
	<!--  -->

	<?php }} ?>
</div>
<?php } 
$inp = '';
if (!empty($_GET)) {
	foreach ($_GET as $key => $value) {
		if ($key !== 'page') {
				$inp .= '<input type="text" name="'.$key.'" value="'.$value.'" hidden="true" />';
		}
	}
}
?>
<div class="pages">
	<!-- КНОПКА ПРЕДИДУЩАЯ СТРАНИЦА -->
	<?php if ($data['current_page'] + 1 != '1') { ?>
	<form action="<?php echo $_SERVER["REQUEST_URI"]; ?>" method="get" class="page_nav prev_page">
		<?php echo $inp; ?>
		<input type="text" name="page" value="<?php echo $data['current_page']; ?>" hidden="true">
		<input type="submit" value="<">
	</form>
	<?php } ?>

	<!-- СПИСОК КНОПОК НОМЕРОВ СТРАНИЦ -->
	<form action="<?php echo $_SERVER["REQUEST_URI"]; ?>" method="get">
		<?php echo $inp; ?>
	<?php
		// Простой список страниц, для их количества меньше 10
	if ($data['max_page'] > 1 && $data['max_page'] < 10) {
		for ($i = 0; $i < $data['max_page']; $i++) {
			$p = $i + 1;
	?>
		<input type="submit" name="page" value="<?php echo $p; ?>" <?php echo $i == $data['current_page'] ? 'disabled class="disabled"' : '' ?>>
	<?php 
		} 
		// Случай если страниц больше 10
    } else { 
    	$cur_page = $data['current_page'] + 1;
    		// Случай когда текущая страница находится в промежутке от 1 до 4
    	if ($cur_page <= 4) {
			for ($i = 0; $i < 5; $i++) {
				$p = $i + 1;
	?>
			<input type="submit" name="page" value="<?php echo $p; ?>" <?php echo $i == $data['current_page'] ? 'disabled class="disabled"' : '' ?>>
	<?php 
			} 
	?>
			<span>...</span>
			<input type="submit" name="page" value="<?php echo $data['max_page']; ?>">
	<?php
    		// Случай когда текущая страница находится в промежутке последних 4-х страниц
    	} elseif ($cur_page >= $data['max_page'] - 4) {
    ?>
			<input type="submit" name="page" value="1">
			<span>...</span>
    <?php
    		for ($i = $data['max_page'] - 5; $i <= $data['max_page']; $i++) {
    ?>
			<input type="submit" name="page" value="<?php echo $i; ?>" <?php echo $i == $cur_page ? 'disabled class="disabled"' : '' ?>>
	<?php
    		}
    		// Случай когда текущая страница находится в промежутке между 4 и (n - 4) страницей
    	} else {
    ?>
			<input type="submit" name="page" value="1">
			<span>...</span>
    <?php 
    		for ($i = $cur_page - 2; $i <= $cur_page + 2; $i++) {
    ?>
			<input type="submit" name="page" value="<?php echo $i; ?>" <?php echo $i == $cur_page ? 'disabled class="disabled"' : '' ?>>
    <?php
    		}
    ?>
			<span>...</span>
			<input type="submit" name="page" value="<?php echo $data['max_page']; ?>">
    <?php
    	}
	?>


	<?php } ?>
	</form>

	<!-- КНОПКА СЛЕДУЮЩАЯ СТРАНИЦА -->
	<?php if ($data['current_page'] + 1 != $data['max_page']) { ?>
	<form action="<?php echo $_SERVER["REQUEST_URI"]; ?>" method="get" class="page_nav next_page">
		<?php echo $inp; ?>
		<input type="text" name="page" value="<?php echo $data['current_page'] + 2; ?>" hidden="true">
		<input type="submit" value=">">
	</form>
	<?php } ?>
</div>
</div>
