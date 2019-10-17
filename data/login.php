<?php

header("Content-Type:application/json");

require_once('./init.php');

// session_start();

$data = json_decode(file_get_contents("php://input"));

@$uname = $data->name or die('{"code":-1,"data":"请输入用户名"}');

@$pwd = $data->pwd or die('{"code":-1,"data":"请输入密码"}');

$uPattern='/[a-z0-9]{3,12}/';
$pPattern='/[a-z0-9]{4,12}/';


if(!preg_match($uPattern,$uname)){  //验证用户名格式
    die('{"code":-2,"msg":"用户名格式不正确"}');
}

if(!preg_match($pPattern,$pwd)){  //验证密码格式
    die('{"code":-2,"msg":"密码格式不正确"}');
}


$sql = "SELECT user_id, user_name FROM m_user_admin WHERE user_name='$uname' AND user_password='$pwd'";

$result = sql_execute($sql);

if(count($result)){
    // $_SESSION['user_id'] = $result[0]['user_id'];
    
    // $result[0]['token'] = set_token($uname);

    echo '{"code":1, "data":'.json_encode($result[0]).'}';

} else {
    echo '{"code":-3, "data":"用户名或密码错误"}';
}

// function set_token($user_name){

//     $information ['state'] = false;    
//     $time = time();    
//     $header = array(        'typ' => 'JWT');    
    
//     $array = array(        
//         'iss' => 'auth', // 权限验证作者

//         'iat' => $time, // 时间戳

//         'exp' => 3600, // token有效期，1小时

//         'sub' => 'demo', // 案例

//         'user_name' => $user_name  // 用户名

//     );    
    
//     $str = base64_encode(json_encode($header)) . '.' . base64_encode(json_encode($array)); // 数组转成字符

//     $str = urlencode($str); // 通过url转码

//     $information ['token'] = $str;    
    
//     $this->save_token($user_name, $information ['token']); // 将用户token存放进用户数据库

//     $information ['username'] = $user_name; // 返回用户名

//     $information ['state'] = true;    
    
//     return $information;

// }