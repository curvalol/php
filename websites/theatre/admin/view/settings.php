<h1><?php echo $data['h1']; ?></h1>
<form action="/admin/index.php?route=settings" method="post">
  <h4>Редактирование информации о статусе заказа</h2>
<?php foreach ($data['order_status'] as $status) { ?>
  <label><?php echo $status['order_status_id']; ?>: </label>
  <input type="text" name="order_status_name_<?php echo $status['order_status_id']; ?>" value="<?php echo $status['order_status_name']; ?>" size="13">
  <input type="text" name="order_status_hint_<?php echo $status['order_status_id']; ?>" value="<?php echo $status['order_status_hint']; ?>" size="65">
  <br>
<?php } ?>
  <h4>Редактирование заказов</h4>
<?php foreach ($data['order_information'] as $info) ?>
  <label><?php echo $info['information_name']; ?>: <input type="text" name="information_<?php echo $info['information_id']; ?>" value="<?php echo $info['information_value']; ?>" size="10"></label><br>
<?php  ?>
  <input type="submit" value="Внести изменения в базу">
</form>