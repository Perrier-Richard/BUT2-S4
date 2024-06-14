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
        include_once '../../class/interactive/element.php';
        include_once '../../class/interactive/text.php';
        include_once '../../class/interactive/sondage.php';
        include_once '../../class/interactive/image.php';

        $database = new Database();
        $db = $database -> getConnection();

        $data = json_decode(file_get_contents("php://input"));

        $result = array();

        $billet = $data -> billet_id;
        $element = $data -> element_id;
        $value = $data -> value;

        if(Element::addUserInteraction($db, $_SESSION['LOGGED_USER'], intVal($billet), $element, $value)){
        	$result['result'] = TRUE;
        }else{
        	$result['result'] = FALSE;
        }

        echo json_encode($result);
    }
