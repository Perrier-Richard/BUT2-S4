<?php

    header("Access-Control-Allow-Origin: *");
    header("Content-Type: application/json; charset=UTF-8");
    header("Access-Control-Allow-Methods: GET");

    include_once '../../config/database.php';
    include_once '../../class/tickets.php';

    $database = new Database();
    $db = $database -> getConnection();

    $item = new Ticket($db);
    $result = [];
    
    $data = $_GET;

    $item -> id = $data['id'];

    $stmt = $item -> getTicket();

    $result['result'] = $stmt -> fetchAll()[0];

    echo json_encode($result);