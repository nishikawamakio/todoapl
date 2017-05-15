<?php
  require('functions.php');
  $login = checkloguin();
  if(!$login) {
    header('location: /login.php');
  }
?>
<!DOCTYPE html>
<html lang="js">
<head>
  <meta charset="UTF-8">
  <title>パスワードリセット</title>
</head>
<body>
  <form action="store.php" method="POST">
      <input type="hidden" name="type" value="resetpassword">
      <dl>
          <dt>ユーザ名</dt>
          <dd><input type="hidden" name="my_name" value="<?php echo $_SESSION['myname'] ?>">
            <p><?php echo $_SESSION['myname'] ?></p>
          </dd>
          <dt>旧パスワード</dt>
          <dd><input type="password" name="password" id="password" /></dd>
          <dt>新パスワード</dt>
          <dd><input type="password" name="password_one" id="password" /></dd>
          <dt>新パスワード</dt>
          <dd><input type="password" name="password_two" id="password" /></dd>
      </dl>
      <input type="submit" value="登録" />
</form>
      <?php if(isset($_SESSION['err'])): ?>
        <p><?php echo $_SESSION['err'] ?></p>
      <?php endif; ?>
</body>
</html>