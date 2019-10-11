<?php

    // header("Content-Type:application/json");

    require_once("./init.php");

    $data = json_decode(file_get_contents("php://input"));
    print_r($data);

