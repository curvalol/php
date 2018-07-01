<?php 
getHeader($data); 
?>
<h1><?php echo $data['title']; ?></h1>
<p><?php echo nl2br($data['inform']['inform_description']); ?></p>



<?php getFooter(); ?>