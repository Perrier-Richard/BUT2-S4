<?php

    header("Access-Control-Allow-Origin: *");
    header("Content-Type: application/json; charset=UTF-8");
    header("Access-Control-Allow-Methods: POST");

    if (session_status() != PHP_SESSION_ACTIVE) {
        session_start();
    }

    if (isset($_SESSION['LOGGED_USER'])) {

        include_once '../../config/database.php';
        include_once '../../class/tickets.php';

        $database = new Database();
        $db = $database -> getConnection();

        $item = new Ticket($db);

        $item -> title = $_POST['title'];
        $item -> content = $_POST['content'];
        $result = [];

        if ($item -> createTicket()) {
            if ($_FILES['addImage']['size'] != 0) {
                move_uploaded_file($_FILES['addImage']['tmp_name'], '../../../Images/ticket_image/' . $item -> id . '.jpg');
                $item -> image = $item -> id . '.jpg';
                if ($item -> addImage()) {
                    $result['result'] = TRUE;
                } else {
                    $result['result'] = FALSE;
                }
            } else {
                $result['result'] = TRUE;
            }
        } else {
            $result['result'] = FALSE;
        }

        echo json_encode($result);

}