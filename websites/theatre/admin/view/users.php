<h1><?php echo $data['h1']; ?></h1>
<table>
  <thead>
    <tr>
      <th>логин</th>
      <th>телефон</th>
      <th>почта</th>
    </tr>
  </thead>
  <tbody>
<?php foreach($data['users'] as $user) { ?>
  <tr
  <?php if ($user['new_order']) { ?>
    class="new_order"
  <?php } ?>
  >
    <td>
      <a href="/admin/index.php?route=user&user_id=<?php echo $user['user_id']; ?>">
        <?php echo $user['login']; ?>
      </a>
    </td>
    <td><?php echo !empty($user['phone']) ? $user['phone'] : ''; ?></td>
    <td><?php echo $user['email']; ?></td>
  </tr>
<?php } ?>
  </tbody>
</table>