<?php

    header("Access-Control-Allow-Origin: *");
    header("Content-Type: application/json; charset=UTF-8");
    header("Access-Control-Allow-Methods: DELETE");

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

        $item = new Ticket($db);
        $result = [];

        $data = json_decode(file_get_contents("php://input"));

        $billet = $data -> id;
        $item -> id = $billet;

        try{

            $elements = Element::getBilletContent($db, $billet, false);

            for($i = 0; $i < count($elements); $i++){
                $element = Element::buildContent($db, $billet, $elements[$i]['type'], $elements[$i]['content']);
                if($element == null) continue;
                $element -> setId($elements[$i]['id']);
                $element -> delete();    
            }

            $item -> deleteTicket();

            $result['result'] = 'Ticket has been deleted';
        } catch(Exception $ex){
            $result['result'] =  'Could not delete ticket';
        }

        echo json_encode($result);

}