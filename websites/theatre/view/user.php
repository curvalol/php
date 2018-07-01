<h1><?php echo $data['h1']; ?></h1>
<nav class="cabMenu">
  <span class="tab_button tickets_tab active">Билеты</span>
  <span class="tab_button info_tab">Изменить данные</span>
</nav>
<div class="userTickets">
<?php if (!empty($data['tickets'])) { ?>
  <h2>Ваши активные билеты:</h2>
  <form action="/index.php?route=user" method="post">
    <input type="hidden" name="form_type" value="del_ticket">
    <table>
      <thead>
        <tr>
          <th></th>
          <th></th>
          <th>место</th>
          <th>ряд</th>
          <th>цена</th>
          <th>№ заказа</th>
          <th>Статус заказа</th>
        </tr>
      </thead>
      <tbody>
  <?php foreach ($data['tickets'] as $ticket) { ?>
        <tr>
          <td><input type="checkbox" name="tickets[]" value="<?php echo $ticket['ticket_id']; ?>"></td>
          <td><?php echo $ticket['category_name']; ?></td>
          <td><?php echo $ticket['seat_number']; ?></td>
          <td><?php echo $ticket['seat_row']; ?></td>
          <td><?php echo $ticket['price']; ?></td>
          <td><?php echo $ticket['order_name']; ?></td>
          <td><?php echo $ticket['order_status_name']; ?></td>
        </tr>
  <?php } ?>
      </tbody>
    </table>
    <input type="submit" value="Удалить выбранные билеты">
  </form>
<?php } else { ?>
  <h2>У Вас нет активных билетов</h2>
<?php } ?>
</div>
<div class="userInformation disabled">
  <h2>Изменить личные данные:</h2>  
  <form action="/index.php?route=user" method="post">
    <input type="hidden" name="form_type" value="user_info">
    <label> <span>Имя: </span><input type="text" name="name" value="<?php echo $data['name']; ?>"></label><br/>
    <label> <span>Фамилия: </span><input type="text" name="surname" value="<?php echo $data['surname']; ?>"></label><br/>
    <label> <span>Телефон: </span><input type="text" name="phone" value="<?php echo $data['phone']; ?>"></label><br/>
    <label> <span>Почта: </span><input type="text" name="email" value="<?php echo $data['email']; ?>"></label><br/>
    <input type="submit" value="Обновить информацию">
  </form>
</div>