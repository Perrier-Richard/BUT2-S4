<?php

    header("Access-Control-Allow-Origin: *");
    header("Content-Type: application/json; charset=UTF-8");
    header("Access-Control-Allow-Methods: POST");

    include_once '../../config/database.php';
    include_once '../../class/user.php';

    if (session_status() != PHP_SESSION_ACTIVE) {
        session_start();
    }

    $database = new Database();
    $db = $database -> getConnection();

    $item = new User($db);
    $result = [];

    $data = json_decode(file_get_contents("php://input"));

    $item -> username = $data -> username;
    $item -> password = hash("sha512",$data -> password);

    $stmt = $item -> getUser();
    $resultArr = $stmt -> fetchAll();

    if ($resultArr != null) {
        $_SESSION['LOGGED_USER'] = $resultArr[0]['id'];
        $result['result'] = $resultArr;
    } else {
        $result['result'] = FALSE;
    }

    echo json_encode($result);