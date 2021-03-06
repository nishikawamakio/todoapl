<?php
  require_once('config.php');

  // DB接続
  function connectPdo() {
    try{
      return new PDO(DSN,DB_USER,DB_PASSWORD);
    } catch (PDOException $e) {
      echo $e->getMessage();
    }
  }

  // 作成処理
  function insertDb($data) {
    $dbh = connectPdo();
    $sql = 'INSERT INTO todos (todo) VALUES (:todo)';
    $stmt = $dbh->prepare($sql);
    $stmt->bindParam(':todo',$data,PDO::PARAM_STR);
    $stmt->execute();
  }

  // 全権取得
  function selectAll() {
    $dbh = connectPdo();
    $sql = 'SELECT * FROM todos WHERE deleted_at IS NULL';
    $todo = array();
    foreach($dbh->query($sql) as $row) {
      array_push($todo,$row);
    }
    return $todo;
  }

  // 更新処理
  function updateDb($id, $data) {
    $dbh = connectPdo();
    $sql = 'UPDATE todos SET todo = :todo WHERE id = :id';
    $stmt = $dbh->prepare($sql);
    $stmt->bindParam(':todo', $data, PDO::PARAM_STR);
    $stmt->bindValue(':id',(int)$id, PDO::PARAM_INT);
    $stmt->execute();
  }

  //詳細取得
  function getSelectData($id) {
    $dbh = connectPdo();
    $sql = 'SELECT todo FROM todos WHERE id = :id AND deleted_at IS NULL';
    $stmt = $dbh->prepare($sql);
    $stmt->execute(array(':id' => (int)$id));
    $data = $stmt->fetch();
    return $data['todo'];
  }

  function deleteDb($id) {
    $dbh = connectPdo();
    $nowTime = date("Y-m-d H:i:s");
    $sql = 'UPDATE todos SET deleted_at = :deleted_at WHERE id = :id';
    $stmt = $dbh->prepare($sql);
    $stmt->bindParam(':deleted_at', $nowTime);
    $stmt->bindValue(':id',$id, PDO::PARAM_INT);
    $stmt->execute();
  }

  // ユーザ登録情報取得
  function getEntry($data) {
    $dbh = connectPdo();
    $sql = 'SELECT * FROM user_infos WHERE name = :name AND deleted_at IS NULL';
    $stmt = $dbh->prepare($sql);
    $stmt->execute(array(':name' => (string)$data['user_id']));
    $res = $stmt->fetch();
    $_SESSION['id'] = $res['id'];
    return $res;
  }

  // ユーザ情報登録
  function createEntry($data) {
    $dbh = connectPdo();
    $sql = 'INSERT INTO user_infos (name,pass) VALUES (:name,:pass)';
    $password = crypt($data['password']);
    $stmt = $dbh->prepare($sql);
    $stmt->bindParam(':name',$data['user_id'],PDO::PARAM_STR);
    $stmt->bindParam(':pass',$data['password'],PDO::PARAM_STR);
    $stmt->execute();
  }
  /* パスワードの変更 */
  function updataEntry($data) {
    $dbh = connectPdo();
    $sql = 'UPDATE user_infos SET pass = :pass WHERE id = :id';
    $stmt = $dbh->prepare($sql);
    $stmt->bindParam(':pass', $data['password_one'], PDO::PARAM_STR);
    $stmt->bindParam(':id', $_SESSION['id'], PDO::PARAM_STR);
    $stmt->execute();
  }