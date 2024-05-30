<?php

    header("Access-Control-Allow-Origin: *");
    header("Content-Type: application/json; charset=UTF-8");
    header("Access-Control-Allow-Methods: GET");

    include_once '../../config/database.php';
    include_once '../../class/tickets.php';

    $database = new Database();
    $db = $database -> getConnection();

    $items = new Ticket($db);
    $result = [];

    $data = $_GET;

    $items -> page = intval($data['page']);
    $items -> count = intval($data['count']);

    $stmt = $items -> getTickets();

    $result['result'] = $stmt -> fetchAll();

    echo json_encode($result);