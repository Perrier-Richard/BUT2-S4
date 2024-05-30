<?php

    header("Access-Control-Allow-Origin: *");
    header("Content-Type: application/json; charset=UTF-8");
    header("Access-Control-Allow-Methods: GET");

    include_once '../../config/database.php';
    include_once '../../class/user.php';

    if (session_status() != PHP_SESSION_ACTIVE) {
        session_start();
    }

    $database = new Database();
    $db = $database -> getConnection();

    $item = new User($db);
    $result = [];

    if (isset($_SESSION['LOGGED_USER'])) {
        $item -> id = $_SESSION['LOGGED_USER'];
        $stmt = $item -> getUserFromId();
        $resultArr = $stmt -> fetchAll();
        $result['result'] = $resultArr[0]['username'];
    } else {
        $result['result'] = FALSE;
    }

    echo json_encode($result);