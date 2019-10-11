<?php

$db_host = '127.0.0.1';
$db_user = 'root';
$db_password = 'tx08351393';
$db_database = 'mine';
$db_port = 3306;
$db_charset = 'UTF8';

$origin = isset($_SERVER['HTTP_ORIGIN']) ? $_SERVER['HTTP_ORIGIN'] : '';  

$allow_origin = array(
    'http://localhost',
    'http://127.0.0.1' ,
    'http://localhost:8080',
    'http://localhost:8088',
    'http://119.29.67.165'
);

if(in_array($origin, $allow_origin)){  
    header('Access-Control-Allow-Origin:'.$origin);  
}
header('Access-Control-Allow-Credentials:true');		//允许携带凭证

$conn = mysqli_connect($db_host, $db_user, $db_password, $db_database, $db_port);

mysqli_query($conn, "SET NAMES $db_charset");

function sql_execute($sql){
  global $conn;
  $result = mysqli_query($conn, $sql);
  if(stripos($sql,"select") === 0)
    if(!$result){
      return  "查询执行失败！请检查SQL语法：$sql";
    }else {
      return $rowList = mysqli_fetch_all($result,MYSQLI_ASSOC);
    }
  else
    return $result;
}