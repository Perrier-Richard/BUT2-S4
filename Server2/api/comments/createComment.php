<?php

    header("Access-Control-Allow-Origin: *");
    header("Content-Type: application/json; charset=UTF-8");
    header("Access-Control-Allow-Methods: POST");

    include_once '../../config/database.php';
    include_once '../../class/comments.php';

    $database = new Database();
    $db = $database -> getConnection();

    $item = new Comment($db);
    $result = [];

    $data = json_decode(file_get_contents("php://input"));

    $item -> billet_id = $data -> billet_id;
    $item -> commentaire = $data -> content;
    $item -> pseudo = $data -> pseudo;

    if ($item -> createComment()) {
        $result['result'] =  'Ticket has been created';
    } else {
        $result['result'] = 'Could not create ticket';
    }

    echo json_encode($result);