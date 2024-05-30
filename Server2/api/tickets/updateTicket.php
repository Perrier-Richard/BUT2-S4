<?php

    header("Access-Control-Allow-Origin: *");
    header("Content-Type: application/json; charset=UTF-8");
    header("Access-Control-Allow-Methods: PATCH");

    if (session_status() != PHP_SESSION_ACTIVE) {
        session_start();
    }

    if (isset($_SESSION['LOGGED_USER'])) {

        include_once '../../config/database.php';
        include_once '../../class/tickets.php';

        $database = new Database();
        $db = $database -> getConnection();

        $item = new Ticket($db);

        $data = json_decode(file_get_contents("php://input"));

        $item -> id = $data -> id;
        $item -> title = $data -> title;
        $item -> content = $data -> content;

        $result = [];

        if ($item -> updateTicket()) {
            $result['result'] = TRUE;
        } else {
            $result['result'] = FALSE;
        }

        echo json_encode($result);

}

    

