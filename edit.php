<?php
require_once('functions.php');
setToken();
$login = checkLoguin();
$data = detail($_SESSION['todoid']);
if(!$login) {
  header('location: /login.php');
}
?>
<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <title>編集</title>
</head>
<body>
  <?php if(isset($_SESSION['err'])): ?>
    <p><?php echo $_SESSION['err'] ?></p>
  <?php endif; ?>
  <form action="store.php" method="post">
    <input type="hidden" name="token" value="<?php echo h($_SESSION['token']); ?>">
    <input type="hidden" name="id" value="<?php $_SESSIOM['todoid'] ?>">
    <input type="text" name="todo" value="<?php echo h($data); ?>">
    <input type="submit" value="更新">
  </form>
  <div>
    <a href="index.php">一覧へ戻る</a>
  </div>
  <?php unsetSession(); ?>
</body>
</html>