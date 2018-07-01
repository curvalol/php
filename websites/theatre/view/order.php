<h1><?php echo $data['h1']; ?></h1>
<div class="row">
	<ul class="col-sm-3 info">
	<?php foreach($data['tickets'] as $ticket) { ?>
	<li><?php echo $tikcet['category_name']; ?>Место: <?php echo $ticket['seat_number']; ?>, Ряд: <?php echo $ticket['seat_row']; ?>, цена <?php echo $ticket['price']; ?> грн.</li>
	<?php } ?>
	<li class="orderSum">Сумма заказа составляет: <?php echo $data['summCost']; ?> грн.</li>
	</ul>
	<form action="/index.php?route=order" method="post" class="col-sm-9 orderConfirm">
	<?php if (!empty($data['user_name'])) { ?>
		<p>Здравствуй, <?php echo $data['user_name']; ?>. Подтверждаешь ли ты бронь выбранных мест? В случае подтверждения информация о данной броне будет отправлена на твой адресс электронной почты: <?php echo $data['email']; ?>, - и менеджер свяжется с Вами в ближайшее время</p>
	<?php } else { ?>
		<p>Здравствуй, Гость. Тобой были забронированы места. Для подтверждения брони тебе необходимо зарегистрироваться, для этого заполни указанные поля. В случае корректного заполнения данной формы заказ будет подтвержден, информация о броне будет отправлена на указанные Вами адресс электронной почты и менеджер свяжится с Вами в ближайшее время.</p>
		<input type="hidden" name="newUser" value="1">
	<?php if (!empty($_SESSION['registration']['err'])) { ?>
		<div class="error"><?php echo $_SESSION['registration']['err']; ?></div>
	<?php } ?><br>
		<label><span>Логин: </span><input type="text" name="login"></label><br/>
		<label><span>Пароль: </span><input type="password" name="pass"></label><br/>
		<label><span>Повторите пароль: </span><input type="password" name="rep_pass"></label><br/>
		<label><span>Почта: </span><input type="text" name="email"></label><br/>
		<label><input type="checkbox" name="agree"> Я прочитал и согласен с <a href="/someurl" target="_blank">правилами использования данного сайта</a></label><br/>
	<?php } ?>
		<input type="hidden" name="confirm" value="1">
		<input type="hidden" name="orderedSeats" value="<?php echo $data['ordered_id']; ?>">
		<input type="submit" value="Подтвердить">
	</form>

</div>
