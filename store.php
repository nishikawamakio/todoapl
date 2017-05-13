<?php
  require('functions.php');
  $res = checkReferer();
  var_dump($res);
  //exit();
  if($res != 'back') {
    header('location: ./index.php');
  }elseif($res === 'index') {
    header('location: ./index.php');
  }elseif($res === 'login') {
    header('location: ./login.php');
  }else {
    header('location: '.$_SERVER['HTTP_REFERER'].'');
  }
?>