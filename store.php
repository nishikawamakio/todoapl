<?php
  require('functions.php');
  $res = checkReferer();
  if($res === 'back') {
    header('location: ./index.php');
  }elseif($res === 'index') {
    header('location: ./index.php');
  }elseif($res === 'login') {
    header('location: ./login.php');
  }elseif($res === 'entry') {
    header('location: ./newentry.php');
  }
  else {
    header('location: '.$_SERVER['HTTP_REFERER'].'');
  }
?>