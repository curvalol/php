<?php
session_start();
  
require_once $_SERVER['DOCUMENT_ROOT'] . "/config.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/system/request.php";

$category_name = array();
$categories = db_select("SELECT * FROM category");
$news = db_select("SELECT news_id, news_name, category_id, short_description FROM news");
$inform_pages = db_select("SELECT * FROM information");

foreach ($categories as $cat) {
  $category_name[] = $cat['category_name'];
}

if (!empty($_POST['exit'])) {
	unset($_SESSION['auth']);
	unset($_SESSION['err']);
}

if (!empty($_POST['user_name'])) {
	if (!empty($_POST['user_password'])) {
		$sql_auth = "SELECT user_id FROM users WHERE user_name='" . $_POST['user_name'] . "' AND user_password='" . $_POST['user_password'] . "' AND user_type='admin'";
		$auth = db_select($sql_auth);
		if (!empty($auth)) {
			$_SESSION['auth'] = $auth;
			unset($_SESSION['err']);
		} else {
			$_SESSION['err'] = 'Пароль или логин введены неверно!';
		}
	} else {
		$_SESSION['err'] = 'Введите пароль!';
	}
} else

?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Панель администратора</title>
	<link rel="stylesheet" href="..\views/style/grid.min.css">
	<link rel="stylesheet" href="style.css">
</head>
<body>
<div class="container">
<?php if ($_SESSION['auth']) { ?>


	<form action="" method="post" class="row">
		<h1 class="col-sm-11">Панель администратора</h1>
		<input type="hidden" name="exit" value="1">
		<input type="submit" value="Выйти" class="col-sm-1">
	</form>

	<nav class="row">
		<a class="col-sm-2" href="/admin/index.php">Добавить новость</a>
		<a class="col-sm-2" href="/admin/index.php?route=news">Новости</a>
		<a class="col-sm-2" href="/admin/index.php?route=category">Категории</a>
		<a class="col-sm-2" href="/admin/index.php?route=inform">Информа страницы</a>
	</nav>

	<?php if ($_GET['route'] == 'category') { ?>

	<form action="/admin/category.php" method="post" class="row">		
		<h2>Категории:</h2>
		<table>
			<thead>
				<tr>
					<th></th>
					<th>Название</th>
					<th>Описание</th>
				</tr>
			</thead>
			<tbody>
				<?php foreach($categories as $cat) { ?>
					<tr>
						<td>
							<input type="checkbox" name="id_<?php echo $cat['category_id']; ?>" value="<?php echo $cat['category_id']; ?>">
						</td>
						<td>
							<a href="/admin/update.php?category=<?php echo $cat['category_id']; ?>"><?php echo $cat['category_name']; ?></a>
						</td>
						<td>
							<?php echo $cat['category_description']; ?>
						</td>
					</tr>
				<?php } ?>
					<tr>
						<td></td>
						<td>
							<input type="text" name="category_name" placeholder="Имя категории">
						</td>
						<td>
							<input type="text" name="category_desc" placeholder="Описание категории">
						</td>
					</tr>
			</tbody>
		</table>
		<input type="submit">
	</form>

	<?php } elseif ($_GET['route'] == 'inform') { ?>

	<form action="/admin/inform.php" method="post">
		<h2>Информ страницы:</h2>
		<table>
			<thead>
				<tr>
					<th></th>
					<th>
						Имя информ страницы:
					</th>
				</tr>
			</thead>
			<tbody>
				<?php foreach ($inform_pages as $i) { ?>
				<tr>
					<td>
						<input type="checkbox" name="id_<?php echo $i['information_id']; ?>" value="<?php echo $i['information_id']; ?>">
					</td>
					<td>
						<a href="/admin/update.php?information=<?php echo $i['information_id']; ?>"><?php echo $i['inform_name']; ?></a>
					</td>	
				</tr>
				<?php } ?>
			</tbody>
		</table>
		<p>
			<h5>Добавить информ страницу</h5>
			<label>Имя страницы: <input type="text" name="page_name"></label><br>
			<label>Содержание страницы: <br><textarea name="page_desc"></textarea></label>
		</p>
		<input type="submit" value="Отправить">
	</form>

	<?php } elseif ($_GET['route'] == 'news') { ?>

	<form action="/admin/delete.php" method="post">
		<div class="row">			
			<h2 class="col-sm-11">Удаление новостей</h2>
			<input class="col-sm-1" type="submit" value="Удалить">
		</div>
		<table>
			<thead>
				<tr>
					<th></th>
					<th>Имя</th>
					<th>Категория</th>
					<th>Краткое описание</th>
				</tr>
			</thead>
			<tbody>
			<?php foreach(array_reverse($news) as $new) { ?>
				<tr>
					<td>
						<input type="checkbox" name="id_<?php echo $new['news_id']; ?>" value="<?php echo $new['news_id']; ?>">
					</td>
					<td>
						<a href="/admin/update.php?news=<?php echo $new['news_id']; ?>"><?php echo $new['news_name']; ?></a>
					</td>
					<td>
						<?php echo $category_name[$new['category_id'] - 1]; ?>
					</td>
					<td>
						<?php echo $new['short_description']; ?>
					</td>
				</tr>
			<?php } ?>
			</tbody>
		</table>
		<input type="submit" value="Удалить">
	</form>

	<?php } else { ?> 

	<form action="/admin/add.php" enctype="multipart/form-data" method="post">
		<h2>Добавить новость</h2>
		<ul>	
			<li>
				<label>Имя новости: <input type="text" name="name" /></label>
			</li>
			<li>
				<select name="category">
					<option value="0">--Выберите категорию--</option>
					<?php foreach ($categories as $category) { ?>
					<option value="<?php echo $category['category_id']; ?>">
						<?php echo $category['category_name']; ?>				
					</option>
					<?php } ?>
				</select>			
			</li>
			<li>
				<label>Краткое описание новости: <textarea name="shortdesc"></textarea></label>
			</li>
			<li>
				<label>Описание новости: <textarea name="desc" rows="10"></textarea></label>
			</li>
			<li>
				<label>
					Изображение: 
					<input type="hidden" name="MAX_FILE_SIZE" value="1024000">
					<input type="file" name="img">
				</label>
			</li>
			<li>
				<input type="submit" value="Добавить">
			</li>
		</ul>
	</form>

	<?php } ?>

<?php } else { ?>
<form action="" method="post">
	<h1>Авторизация панели администратора:</h1>
	<?php if (!empty($_SESSION['err'])) { ?>
		<p class='err'><?php echo $_SESSION['err']; ?></p>
	<?php } ?>
	<label>Логин: <input type="text" name="user_name"></label>
	<br>
	<label>Пароль: <input type="password" name="user_password"></label>
	<input type="submit">
</form>


<?php } ?>
</div>
</body>
</html>

