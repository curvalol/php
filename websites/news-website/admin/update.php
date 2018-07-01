<?php 

require_once $_SERVER['DOCUMENT_ROOT'] . "/config.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/system/request.php";

if (!empty($_GET['news'])) {
	$table = 'news';
} elseif (!empty($_GET['category'])) {
	$table = 'category';
} elseif (!empty($_GET['information'])) {
	$table = 'information';
}

$sql = "SELECT * FROM " . $table . " WHERE " . $table . "_id='" . $_GET[$table] . "'";
$row = db_select($sql);
$row = $row['0'];
?>
<h1>Редактирование записи с идентификатором <?php echo $table . '_id: ' . $_GET[$table]; ?> из таблицы <?php echo $table; ?></h1>
<form action="/admin/update_form.php" method="post">
<input type="hidden" name="table" value="<?php echo $table; ?>">
<input type="hidden" name="<?php echo $table . '_id'; ?>" value="<?php echo $_GET[$table]; ?>">
<?php 
foreach ($row as $col_name => $col_val) {
	if ($col_name != $table . '_id') { 
?>
	<label>
		<?php echo $col_name; ?>: 
		<?php if (stripos($col_name, 'description') || stripos($col_name, 'description') === 0) { ?>
			<textarea cols="100" rows="10" name="<? echo $col_name; ?>"><?php echo $col_val; ?></textarea>
		<?php } else { ?>		
			<input type="text" name="<? echo $col_name; ?>" value="<?php echo $col_val; ?>">
		<?php } ?>
	</label>
	<br/>
	<?php } ?>
<?php } ?>
<input type="submit" value="Обновить">

</form>
