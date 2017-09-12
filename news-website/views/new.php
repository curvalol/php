<?php 
getHeader($data); 

$data_arr = $data['new_data'];
?>

<div class="row">
	<div class="col-sm-12">
		<span class="news_date"><?php echo date('d.m.Y h:i', $data_arr['date']); ?></span>
		<h1 class="news_title">
			<?php echo $data_arr['news_name']; ?>
		</h1>
		<div class="short_desc">
			<?php echo $data_arr['short_description']; ?>
		</div>
		<div class="img news_img">
			<img src="<?php echo $data_arr['news_image']; ?>" alt="<?php echo $data['title']; ?>">
		</div>
		<div class="news_description">
			<?php echo nl2br($data_arr['description']); ?>
		</div>
	</div>
</div>

<?php getFooter(); ?>