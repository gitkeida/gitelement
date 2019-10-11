<?php

    header("Content-Type:application/json");
    require_once("./init.php");

    $sql = "SELECT * FROM m_banner";

    $result = sql_execute($sql);
    
    if(count($result)){
        echo json_encode($result);
    }

