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
  <?php if(isset($_SESSION['err'])): ?>
    <p><?php echo $_SESSION['err'] ?></p>
  <?php endif; ?>
  <form action="store.php" method="POST">
      <label>ユーザ名
        <?php echo $_SESSION['user_id'] ?>
        <input type="hidden" name="user_id" value="<?php echo $_SESSION['user_id'] ?>">
      </label>
      <div>
        <label>旧パスワード
          <input type="password" name="password" id="password">
        </label>
      </div>
      <div>
        <label>新パスワード
          <input type="password" name="password_one" id="password">
        </label>
      </div>
      <div>
        <lavele>確認用パスワード
          <input type="password" name="password_two" id="password">
        </lavele>
      </div>
      <button type="submit" name="type" value="resetpassword">登録</button>
  </form>
      <a href="index.php">一覧へ戻る</a>
</body>
</html>