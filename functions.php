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
      if(checkentry($data)) {
        $_SESSION['myname'] = $data['my_name'];
        return 'index';
      }else {
        $_SESSION['err'] = 'ユーザー名またはパスワードが間違っています';
      }
    }elseif($path === '/newentry.php' && $data['type'] === 'entry') {
      /* 新規登録 */
      if(checknewentry($data)) {
        setentry($data);
        $_SESSION['myname'] = $data['my_name'];
        return 'index';
      }
      return 'entry';
    }elseif($path === '/resetpassword.php' && $data['type'] === 'resetpassword') {
      /* パスワードリセット */
      if(resetentry($data) && checkentry($data)) {
        updataentry($data);
        $_SESSION['myname'] = $data['my_name'];
        return 'index';
      }else {
          return 'reset';
      }
    }
    elseif(!$res || !empty($_SESSION['err'])) {
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
  // パスワードリセット時の比較
  function resetentry($data) {
    $ans = false;
    //データ比較
    if(($data['password_one'] === $data['password_two']) && ($data['password_one'] != "")) {
      $ans = true;
    }else {
      $_SESSION['err'] = '新パスワードと確認用パスワードが間違っています';
    }
    return $ans;
  }
  //新規登録
  function checknewentry($data) {
    $ans = ture;
    $entrylist = getentry();
    if($data["my_name"] === '' || $data["password"] === '') {
      $_SESSION['err'] = 'ユーザ名とパスワードを入力してください';
      $ans = false;
    }
    foreach($entrylist as $var) {
      if($var["name"] === $data["my_name"]) {
        //　既に登録されていれば弾く
        $_SESSION['err'] = '既に登録されています';
        $ans = false;
      }
    }
    return $ans;
  }

  // ユーザ情報の比較
  function checkentry($data) {
    $ans = false;
    $entrylist = getentry();
    foreach($entrylist as $var) {
      if($var["name"] === $data["my_name"] && $var["pass"] === $data["password"]) {
        $_SESSION['id'] = $var['id'];
        $ans = true;
      }
      else{
        $_SESSION['err'] = 'パスワードが間違っています';
      }
    }
    return $ans;
  }
?>