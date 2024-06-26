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

        $item = new Ticket($db);
        $itemContent = "";

        $item -> title = $_POST['title'];
        $item -> content = "";

        $result = array();

        try{
            if ($item -> createTicket()) {

                for($i = 0; $i < count($_POST) - 1; $i++) {
                    $data = explode(",", $_POST[$i]);
                    $values = [];

                    for($j = 1; $j < count($data); $j++){
                       $values[$j - 1] = $data[$j]; 
                    }

                    if($data[0] == Image::$type){
                        $values = [];
                        $values[0] = $_FILES[$i]['name'];
                    }

                    $billetElement = Element::buildContent($db, $item -> id, $data[0], $values);

                    if($billetElement == null) continue;

                    $billetElement -> create();
                    $billetElementId = $billetElement -> getId();

                    $itemContent .= $billetElementId." ";

                    if($data[0] == Image::$type){
                        $billetImageExt = pathinfo($values[0], PATHINFO_EXTENSION);
                        $billetImageName = $billetElementId.'.'.$billetImageExt;
                        move_uploaded_file($_FILES[$i]['tmp_name'], '../../../Images/ticket_image/'.$billetImageName);
                        $billetElement -> setContent([$billetImageName]);
                        $billetElement -> update();
                    }
                }
                
                $item -> content = $itemContent;
                $item -> updateTicket();
            } 
        } catch(Exception $ex){
            $result['error'] = true;
        }

        echo json_encode($result);
    }