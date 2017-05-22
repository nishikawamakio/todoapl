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
      var_dump($data['id']);
      var_dump($data['todo']);
      exit;
      updateDb($data['id'],$data['todo']);
    }
  }
  //詳細の取得
  function detail($id) {
    return getSelectData($id);
  }
  function checkReferer() {
    $httpArr = parse_url($_SERVER['HTTP_REFERER']);
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
    }elseif($path === '/login.php') {
      $data['password'] = hash("sha256", $data['password']);
      /* ログイン処理 */
      if(checkEntry($data) === true) {
        $_SESSION['user_id'] = $data['user_id'];
        return 'index';
      }
    }elseif($path === '/newentry.php') {
      $data['password'] = hash("sha256", $data['password']);
      /* 新規登録 */
      if(checkEntry($data) === true) {
        createEntry($data);
        $_SESSION['user_id'] = $data['user_id'];
        return 'index';
      }
      return 'entry';
    }elseif($path === '/resetpassword.php') {
      $data['password'] = hash("sha256", $data['password']);
      /* パスワードリセット */
      if(checkEntry($data) === true) {
        if(checkReset($data) === true) {
          $data['password_one'] = hash("sha256", $data['password_one']);
          updataEntry($data);
          return 'index';
        }
      }
      return 'reset';
    }
    elseif($path === '/new.php') {
      if(!$res || !empty($_SESSION['err'])) {
        return 'new';
      }
      create($data);
    }elseif($path === '/edit.php') {
      if(!$res || !empty($_SESSION['err'])) {
        $_SESSION['todoid'] = $data['id'];
        return 'edit';
      }
      update($data);
    }
    return 'back';
  }

  function deleteData($id) {
    deleteDb($id);
  }

  function validate($data) {
  return $res = $data != "" ? true : $_SESSION['err'] = '入力がありません';
}

  // ログインの判定
  function checkLoguin() {
    return isset($_SESSION['user_id']);
  }

  // パスワードリセット時の比較
  function checkReset($data) {
    //データ比較
    if(($data['password_one'] === $data['password_two']) && ($data['password_one']) != '') {
      return true;
    }else {
      $_SESSION['err'] = '新パスワードと確認用パスワードが間違っています';
      return false;
    }
  }

  //登録確認
  function checkEntry($data) {
    /* 確認をするために暗号化 */
    $space = hash("sha256", "");
    //$data['password'] = hash("sha256", $data['password']);
    $entrylist = getEntry($data);
    switch ($data) {
      case $data['password'] === $space && $data['user_id'] === '':
        $_SESSION['err'] = 'ユーザ名とパスワードを入力してください';
        return false;
        break;
      case $data['user_id'] === '':
        $_SESSION['err'] = 'ユーザ名を入力してください';
        return false;
        break;
      case $data['password'] === $space:
        $_SESSION['err'] = 'パスワードを入力してください';
        return false;
        break;
        /* typeによって分岐する処理 */
        /* 入力とDBのuser_idが違う場合 */
      case $data['user_id'] != $entrylist['name']:
        /* ログイン時とエントリー時で結果を変える */
        if($data['type'] === 'entry') {
            return true;
        }elseif($data['type'] === 'login') {
          $_SESSION['err'] = 'ユーザ名が間違っています';
          return false;
        }
        break;
        /* 入力とDBのuser_idが同じ場合 */
      case $data['user_id'] === $entrylist['name']:
        /* ログイン時とエントリー時で結果を変える */
        if($data['type'] === 'entry') {
          $_SESSION['err'] = '既に登録されているユーザ名です';
          return false;
        }elseif($data['type'] === 'login') {
          if($data['password'] === $entrylist['pass']) {
            return true;
          }else {
            $_SESSION['err'] = 'パスワードが間違っています';
            return false;
          }
        }elseif($data['type'] === 'resetpassword') {
          if($data['password'] === $entrylist['pass']) {
            return true;
          }else {
            $_SESSION['err'] = '旧パスワードが間違っています';
            return false;
          }
        }
        break;
      }
    return true;
  }