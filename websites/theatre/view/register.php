<h1><?php echo $data['h1']; ?></h1>
<form action="/index.php?route=register" method="post" class="registerForm">
	<?php if (!empty($_SESSION['registration']['err'])) { ?>
	<div class="error"><?php echo $_SESSION['registration']['err']; ?></div>
	<?php } ?>
	<?php if (!empty($_SESSION['message'])) { ?>
	<div class="message"><?php echo $_SESSION['message']; ?></div>
	<?php } ?>
	<label><span>Логин: </span><input type="text" name="login"></label><br/>
	<label><span>Пароль: </span><input type="password" name="pass"></label><br/>
	<label><span>Повторите пароль: </span><input type="password" name="rep_pass"></label><br/>
	<label><span>Почта: </span><input type="text" name="email"></label><br/>
	<label><input type="checkbox" name="agree"> Я прочитал и согласен с <a href="/someurl" target="_blank">правилами использования данного сайта</a></label><br/>
	<input type="submit" value="Отправить">
</form>