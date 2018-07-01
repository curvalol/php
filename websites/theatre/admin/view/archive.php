<h1><?php echo $data['h1']; ?></h1>
  <table>
    <thead>
      <tr>
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
