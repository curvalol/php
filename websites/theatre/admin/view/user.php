<h1><?php echo $data['h1']; ?></h1>
<form action="/admin/index.php?route=user&user_id=<?php echo $data['user_id']; ?>" method="post">
  <input type="hidden" name="form_type" value="user_data">
  <label>Имя: <input type="text" name="name" value="<?php echo $data['name']; ?>"></label>
  <label>Фамилия: <input type="text" name="surname" value="<?php echo $data['surname']; ?>"></label>
  <label>Телефон: <input type="text" name="phone" value="<?php echo $data['phone']; ?>"></label>
  <label>Почта: <input type="text" name="email" value="<?php echo $data['email']; ?>"></label>
  <br>
  <input type="submit" value="Обновить данные пользователя">
</form>
<form action="/admin/index.php?route=user&user_id=<?php echo $data['user_id']; ?>" method="post">
  <input type="hidden" name="form_type" value="user_tickets">
  <table>
    <thead>
      <tr>
        <th></th>
        <th>Номер заказа</th>
        <th></th>
        <th>Место</th>
        <th>Ряд</th>
        <th>Цена</th>
        <th>Статус</th>
      </tr>
    </thead>
    <tbody>
<?php foreach ($data['user_orders'] as $order) { ?>
      <tr>
        <td>
  <?php if ($order['order_status_id'] == 1 || $order['order_status_id'] == 2) { ?>
          <input type="checkbox" name="tickets[]" value="<?php echo $order['ticket_id']; ?>">
  <?php } ?>          
        </td>
        <td><?php echo $order['order_name']; ?></td>        
        <td><?php echo $order['category_name']; ?></td>        
        <td><?php echo $order['seat_number']; ?></td>        
        <td><?php echo $order['seat_row']; ?></td>        
        <td><?php echo $order['price']; ?></td>        
        <td><?php echo $order['order_status_name']; ?></td>        
      </tr>  
<?php } ?>
    </tbody>
  </table>
  <label>Поменять статус на: 
    <select name="order_status_id">
      <option value="2">Активен</option>
      <option value="3">Отозван</option>
      <option value="4">Закрыт</option>
    </select>
  </label>
  <input type="submit" value="Применить">
</form>