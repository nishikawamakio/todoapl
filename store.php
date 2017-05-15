<?php
  require('functions.php');
  $res = checkReferer();
  var_dump($res);
  if($res === 'back') {
    header('location: ./index.php');
  }elseif($res === 'index') {
    header('location: ./index.php');
  }elseif($res === 'login') {
    header('location: ./login.php');
  }elseif($res === 'entry') {
    header('location: ./newentry.php');
  }elseif($res === 'reset') {
    header('location: ./resetpassword.php');
  }
  else {
    header('location: '.$_SERVER['HTTP_REFERER'].'');
  }
?>