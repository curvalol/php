	</div>
</main>
<footer class="footer">
<div class="container">
	<div class="row">
		<div class="col-sm-10">
			<h3>Дополнительная информация</h3>
			<ul>
				<?php foreach($data['info'] as $inform) { ?>
					<li><a href="<?php echo addLink('inform', $inform['information_id']); ?>"><?php echo $inform['inform_name'] ?></a></li>
				<?php } ?>
			</ul>
		</div>		
		<a href="/" class="col-sm-2 img logo">
			<img src="img/logo.png" alt="logo">
		</a>
	</div>
	<div class="row copyrights">
		© 2000-<?php echo date('Y', time()); ?>, ООО «Рога&Копыта». Все права защищены.
	</div>
</div>
</footer>
</div>
</body>
</html>