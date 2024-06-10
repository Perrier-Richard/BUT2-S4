<?php

    header("Access-Control-Allow-Origin: *");
    header("Content-Type: application/json; charset=UTF-8");
    header("Access-Control-Allow-Methods: GET");

    include_once '../../config/database.php';
    include_once '../../class/tickets.php';
    include_once '../../class/interactive/element.php';
    include_once '../../class/interactive/text.php';
    include_once '../../class/interactive/sondage.php';
    include_once '../../class/interactive/image.php';

    $database = new Database();
    $db = $database -> getConnection();

    $item = new Ticket($db);

    $result = [];
    
    $data = $_GET;
    
    $item -> id = $data['id'];

    $stmt = $item -> getTicket();
    $stmt2 = Element::getBilletContent($db, $data['id'], $data['html']);

    $result['ticket'] = $stmt -> fetchAll()[0];
    $result['content'] = $stmt2;

    echo json_encode($result);