<?php
  require('functions.php');
  $login = checkLoguin();
  if(!$login) {
    header('location: /login.php');
  }
?>
<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <title>Home</title>
</head>
<body>
  <div>
    <a href="new.php">新規作成</a>
    <a href="resetpassword.php">パスワード変更</a>
    <a href="login.php">ログアウト</a>
  </div>
  <div>
    <table>
        <tr>
          <th>ID</th>
          <th>内容</th>
          <th>更新</th>
          <th>削除</th>
        </tr>
        <?php foreach(index() as $todo): ?>
          <tr>
            <td><?php echo h($todo['id']) ?></td>
            <td><?php echo h($todo['todo']) ?></td>
            <td>
              <a href="edit.php?id=<?php $_SESSION['todoid'] = $todo['id']; ?>">更新</a>
            </td>
            <td>
              <form action="store.php" method="POST">
                <input type="hidden" name="id" value="<?php echo h($todo['id']) ?>">
                <input type="hidden" name="type" value="delete">
                <button type="submit">削除</button>
              </form>
            </td>
          </tr>
        <?php endforeach; ?>
    </table>
  </div>
</body>
</html>