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
?>