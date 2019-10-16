<?php

    header("Content-Type:application/json");

    require_once("./init.php");

    $data = json_decode(file_get_contents("php://input"));

    @$id = $data->bannerid or die('{"code":-1,"msg":"id required"}');
    @$img_url = $data->imgurl or die('{"code":-1,"msg":"uname required"}');
    @$link = $data->link;
    @$title = $data->title;
    @$text = $data->bannerText;
    
    $sql = "UPDATE m_banner SET imgurl='$img_url',link='$link',title='$title',bannerText='$text' where bannerid=$id";

    $result = sql_execute($sql);

    if($result){
        echo '{"code":1,"data":"修改成功"}';
    } else {
        echo '{"code":-1,"data":"修改失败"}';
    }



