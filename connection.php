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
?>