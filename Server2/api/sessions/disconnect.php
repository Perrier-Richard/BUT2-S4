<?php

    header("Access-Control-Allow-Origin: *");
    header("Content-Type: application/json; charset=UTF-8");
    header("Access-Control-Allow-Methods: POST");

    include_once '../../config/database.php';
    
    if (session_status() != PHP_SESSION_ACTIVE) {
        session_start();
    }

    if (isset($_SESSION['LOGGED_USER'])) {
        unset($_SESSION['LOGGED_USER']);
        session_destroy();
    }
    echo json_encode(['result'=>TRUE]);