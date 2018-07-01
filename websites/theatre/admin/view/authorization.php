<h1><?php echo $data['h1']; ?></h1>
<form action="/admin/index.php" method="post">
  <label>Логин: <input type="text" name="login"></label><br>
  <label>Пароль: <input type="password" name="password"></label><br>
  <input type="submit" value="Войти">
</form>