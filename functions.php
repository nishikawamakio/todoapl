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
    $httpArr = parse_url($_SERVER['HTTP_REFERER']);
    //とりあえず関係ないけどここに異常系入れたい
    return $res = transition($httpArr['path']);
  }
  function transition($path) {
    unsetSession();
    $data = $_POST;
    if(isset($data['todo'])) {
      $res = validate($data['todo']);
    }
    if($path === '/index.php' && $data['type'] === 'delete') {
      deleteData($data['id']);
      return 'index';
    }elseif($path === '/login.php' && $data['type'] === 'login') {
      //ログイン処理
      if(checkentry($data) === '/index.php') {
        $_SESSION['myname'] = $data['my_name'];
        return 'index.php';
      }else {
        $_SESSION['err'] = 'ユーザー名またはパスワードが間違っています';
      }
    }elseif(!$res || !empty($_SESSION['err'])) {
      return 'back';
    }elseif($path === '/new.php') {
      create($data);
    }elseif($path === '/edit.php') {
      update($data);
    }
  }

  function deleteData($id) {
    deleteDb($id);
  }

  function validate($data) {
  return $res = $data != "" ? true : $_SESSION['err'] = '入力がありません';
}

  // ログインの判定
  function checkloguin() {
    return isset($_SESSION['myname']);
  }

  // ユーザ情報の比較
  function checkentry($data) {
    $ans = "";
    $entrylist = getentry();
    foreach($entrylist as $var) {
      if(($var["name"] === $data["my_name"]) && ($var["name"] === $data["password"])) {
        $ans = '/index.php';
      }else{
        $ans = '/login.php';
      }
    }
    return $ans;
  }
?>