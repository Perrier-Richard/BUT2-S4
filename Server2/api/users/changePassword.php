<?php

        header("Access-Control-Allow-Origin: *");
        header("Content-Type: application/json; charset=UTF-8");
        header("Access-Control-Allow-Methods: POST");

        if (isset($_SESSION['LOGGED_USER'])) {

        include_once '../../config/database.php';
        include_once '../../class/user.php';

        if (session_status() != PHP_SESSION_ACTIVE) {
            session_start();
        }

        $database = new Database();
        $db = $database -> getConnection();

        $item = new User($db);

        $data = json_decode(file_get_contents("php://input"));

        $item -> password = hash("sha512",$data -> currentPassword);
        $item -> username = $data -> currentUsername;


        $result = [];

        $stmt = $item -> getUser();
        $resultArr = $stmt -> fetchAll();

        if ($resultArr != null) {
            if (isset($_SESSION['LOGGED_USER']) && $_SESSION['LOGGED_USER'] == $resultArr[0]['id']) {

                $item -> id = $_SESSION['LOGGED_USER'];
                $item -> password = hash("sha512",$data -> newPassword);
                $item -> username = $data -> newUsername;

                $item -> updateUser();
                $result['result'] = TRUE;

            } else {
                $result['result'] = FALSE;
            }
        } else {
            $result['result'] = FALSE;
        }

        echo json_encode($result);

}