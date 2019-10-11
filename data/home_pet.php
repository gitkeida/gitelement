<?php
    header('Content-Type:application/json');
    require_once('./init.php');

    $sql = 'SELECT * FROM m_pet ORDER BY rand() limit 3';

    $result = sql_execute($sql);

    echo json_encode($result);