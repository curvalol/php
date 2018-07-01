<h1><?php echo $data['h1']; ?></h1>
<form action="/admin/index.php?route=home" method="post">  
  <label>Выберите действие: 
    <select name="action">
<?php foreach ($data['actions'] as $action) { ?>
      <option value="<?php echo $action['order_status_id']; ?>"><?php echo $action['order_status_name']; ?></option>
<?php } ?>
    </select>
    <input type="submit" value="Применить к выбранным билетам">
  </label>
  <table>
    <thead>
      <tr>
        <th></th>
        <th>Номер заказа</th>
        <th></th>
        <th>Место</th>
        <th>Ряд</th>
        <th>Пользователь</th>
        <th>Статус</th>
      </tr>
    </thead>
    <tbody>
<?php foreach ($data['tickets'] as $ticket) { ?>
      <tr>
        <td><input type="checkbox" name="tickets[]" value="<?php echo $ticket['ticket_id']; ?>"></td>
        <td><?php echo $ticket['order_name'] ?></td>
        <td><?php echo $ticket['category_name'] ?></td>
        <td><?php echo $ticket['seat_number'] ?></td>
        <td><?php echo $ticket['seat_row'] ?></td>
        <td><?php echo $ticket['login'] ?></td>
        <td><?php echo $ticket['order_status_name'] ?></td>
      </tr>
<?php } ?>
    </tbody>
  </table>
</form>