<?php

    header("Access-Control-Allow-Origin: *");
    header("Content-Type: application/json; charset=UTF-8");
    header("Access-Control-Allow-Methods: GET");

    include_once '../../config/database.php';
    include_once '../../class/comments.php';

    $database = new Database();
    $db = $database -> getConnection();

    $item = new Comment($db);
    $result = [];
    
    $data = $_GET;

    $item -> billet_id = intval($data['billet_id']);
    $stmt = $item -> countComments();

    $result['result'] = $stmt -> fetchAll();

    echo json_encode($result);