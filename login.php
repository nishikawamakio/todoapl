<?php
require_once('functions.php');
if (isset($_COOKIE['my_id'])){
    $myId = $_COOKIE['my_id'];
}else{
    $myId = '';
}
session_destroy();
?>

<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <title>TODOアプリログイン画面</title>
</head>
<body>
<form action="store.php" method="POST">
    <input type="hidden" name="type" value="login">
    <dl>
        <dt>ユーザ名</dt>
        <dd><input type="text" name="my_name" value="<?php echo $myId; ?>"></dd>

        <dt>パスワード</dt>
        <dd><input type="password" name="password" id="password" /></dd>
    </dl>
    <p><input type="checkbox" name="save" id="save" value="on" /><label for="save" >IDを保存する</label></p>
    <input type="submit" value="送信する" />
</form>
    <?php if(isset($_SESSION['err'])): ?>
        <p><?php echo $_SESSION['err'] ?></p>
    <?php endif; ?>
</body>
</html>