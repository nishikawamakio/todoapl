<?php
  require('connection.php');
  function create($data) {
    insertDb($data['todo']);
  }

  // 全件取得
  function index() {
    return $todos = selectAll();
  }
?>