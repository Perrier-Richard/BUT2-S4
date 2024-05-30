<?php

    header("Access-Control-Allow-Origin: *");
    header("Content-Type: application/json; charset=UTF-8");
    header("Access-Control-Allow-Methods: DELETE");

    if (session_status() != PHP_SESSION_ACTIVE) {
        session_start();
    }

    if (isset($_SESSION['LOGGED_USER'])) {

        include_once '../../config/database.php';
        include_once '../../class/comments.php';

        $database = new Database();
        $db = $database -> getConnection();

        $item = new Comment($db);
        $result = [];

        $data = json_decode(file_get_contents("php://input"));

        $item -> id = intval($data -> id);

        if ($item -> deleteComment()) {
            $result['result'] = true;
        } else {
            $result['result'] = false;
        }

        echo json_encode($result);

}