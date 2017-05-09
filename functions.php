<?php
  require('connection.php');
  function create($data) {
    insertDb($data['todo']);
  }

  // 全件取得
  function index() {
    return $todos = selectAll();
  }
  //　更新
  function update($data) {
    var_dump($data);
    updateDb($data['id'],$data['todo']);
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