<?php

session_start();

header("Content-Type:application/json");

require_once('./init.php');


$data = json_decode(file_get_contents("php://input"));

$user_db = intval($data->user_db);

// if(!$_SESSION['user_id']) die('{"code":"-1","msg":"用户未登录"}');

$sql = "SELECT user_id,user_name,user_email,reg_time,expire,user_db FROM m_user_admin WHERE user_db <= $user_db";

$result = sql_execute($sql);

if(count($result)){

    echo '{"code":1, "msg":"请求成功", "data":'.json_encode($result).'}';

} else {

    echo '{"code":-3, "msg":"普通管理员暂无权限"}';

}