<?php
  require('connection.php');
  session_start();
  function h($s) {
    return htmlspecialchars($s, ENT_QUOTES, "UTF-8");
  }

  function setToken() {
    $token = sha1(uniqid(mt_rand(), true));
    $_SESSION['token'] = $token;
  }

  function checkToken($data) {
    if(empty($_SESSION['token']) || ($_SESSION['token'] != $data)) {
      $_SESSION['err'] = '不正な操作です';
      header('location: '.$_SERVER['HTTP_REFERER'].'');
      exit();
    }
    return true;
  }

  function unsetSession() {
    if(!empty($_SESSION['err'])) $_SESSION['err'] = '';
  }

  function create($data) {
    if(checkToken($data['token'])) {
      insertDb($data['todo']);
    }
  }

  // 全件取得
  function index() {
    return $todos = selectAll();
  }
  //　更新
  function update($data) {
    if(checkToken($data['token'])) {
      updateDb($data['id'],$data['todo']);
    }
  }
  //詳細の取得
  function detail($id) {
    return getSelectData($id);
  }
  function checkReferer() {
    var_dump("test0");
    $httpArr = parse_url($_SERVER['HTTP_REFERER']);
    return $res = transition($httpArr['path']);
  }
  function transition($path) {
    $data = $_POST;
    var_dump($data);
    var_dump($path);
    if($path === '/index.php' && $data['type'] === 'delete') {
      deleteData($data['id']);
      return 'index';
    }
    elseif($path === '/new.php') {
      create($data);
    }elseif($path === '/edit.php') {
      update($data);
    }
    //exit();
  }
  function deleteData($id) {
    deleteDb($id);
  }
?>