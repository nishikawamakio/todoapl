<?php
  require_once('functions.php');
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>新規登録</title>
</head>
<body>
  <h1>新規登録</h1>
  <?php if(isset($_SESSION['err'])): ?>
    <p><?php echo $_SESSION['err'] ?></p>
  <?php endif; ?>
  <form action="store.php" method="POST">
    <label>ユーザ名
      <input type="text" name="user_id" value="">
    </label>
    <lavel>パスワード
      <input type="password" name="password" id="password">
    </label>
    <button type="submit" value="entry" name="type">新規登録</button>
  </form>
  <div>
    <a href="login.php">ログイン画面へ戻る</a>
  </div>
</body>
</html>