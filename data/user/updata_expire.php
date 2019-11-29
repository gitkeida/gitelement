<?php 
header("Content-Type:application/json");

require_once('../init.php');

$data = json_decode(file_get_contents("php://input"));

@$user_id = $data->user_id or die('{"code":-1,"msg":"缺少用户id字段"}');

@$int_user_id = $data->int_user_id or die('{"code":-1,"msg":"缺少指定用户id字段"}');

$sql = "SELECT s.user_db,s.expire FROM m_user_admin as s WHERE user_id = $user_id";

$sql2 = "SELECT user_db,expire FROM m_user_admin WHERE user_id = $int_user_id";

$result = sql_execute($sql);

$result2 = sql_execute($sql2);

if(count($result) && count($result2)) {
    
    $user_user_db = $result[0]['user_db'];
    $int_user_expire = $result2[0]['expire'];
    $int_user_user_db = $result2[0]['user_db'];

    $num = $int_user_expire == 1 ? 0 : 1;

    $sql3 = "UPDATE m_user_admin SET expire = $num WHERE user_id = $int_user_id AND $user_user_db > $int_user_user_db";

    $result3 = sql_execute($sql3);

    if(mysqli_affected_rows($conn)) {
        echo '{"code":1,"msg":"修改成功"}';
    } else {
        echo '{"code":-1,"msg":"修改失败"}';
    }


} else {
    echo '{"code": -2, "msg": "未找到该用户id"}';
}