<h1><?php echo $data['h1']; ?></h1>
<form action="/index.php?route=order" method="post" class="container seats">
	<div class="row">
		<div class="col-sm-1"></div>
		<div class="col-sm-7">
			<?php if (!empty($_SESSION['err'])) { ?>
			<div class="row error"><?php echo $_SESSION['err']; ?></div>
			<?php } ?>
			<div class="row">
				<div class="col-sm-2">
					<span class="categoryName">
						<?php echo $data['lbalkon']->name; ?>
					</span>
					<?php echo $data['lbalkon']; ?>
				</div>
				<div class="col-sm-8">
					<span class="categoryName">
						<?php echo $data['amph']->name; ?>
					</span>
					<?php echo $data['amph']; ?>
					<span class="categoryName">
						<?php echo $data['parter']->name; ?>
					</span>
					<?php echo $data['parter']; ?>			
				</div>
				<div class="col-sm-2">
					<span class="categoryName">
						<?php echo $data['rbalkon']->name; ?>
					</span>
					<?php echo $data['rbalkon']; ?>			
				</div>
			</div>
			<div class="row">
				<div class="col-sm-12">
					<span class="categoryName">
						<?php echo $data['balkon']->name; ?>
					</span>
					<div class="rowDirection">
						<?php echo $data['balkon']; ?>							
					</div>
				</div>
			</div>	
			<input type="submit" value="Купить билеты" class="buyButton">	
		</div>
		<div class="col-sm-3 info">
			<h5 class="infoTitle">Стоимость билетов:</h5>
			<div><?php echo $data['amph']->name . ' - ' . $data['amph']->price . ' грн.'; ?></div>
			<div><?php echo $data['parter']->name . ' - ' . $data['parter']->price . ' грн.'; ?></div>
			<div><?php echo $data['balkon']->name . ' - ' . $data['balkon']->price . ' грн.'; ?></div>
			<div><?php echo $data['rbalkon']->name . ' - ' . $data['rbalkon']->price . ' грн.'; ?></div>
			<div><?php echo $data['lbalkon']->name . ' - ' . $data['lbalkon']->price . ' грн.'; ?></div>
		</div>
	</div>
</form>

