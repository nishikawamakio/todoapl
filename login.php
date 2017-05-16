<?php
require_once('functions.php');
session_destroy();
?>

<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <title>TODOアプリログイン画面</title>
</head>
<body>
  <h1>TODOアプリログイン画面</h1>
  <?php if(isset($_SESSION['err'])): ?>
    <p><?php echo $_SESSION['err'] ?></p>
  <?php endif; ?>
  <form action="store.php" method="POST">
    <label>ユーザ名
      <input type="text" name="user_id" value="">
    </label>
    <label>パスワード
      <input type="password" name="password" id="password">
    </label>
    <button type="submit" value="login" name="type">ログイン</button>
  </form>
  <a href="newentry.php">新規登録</a>
</body>
</html>