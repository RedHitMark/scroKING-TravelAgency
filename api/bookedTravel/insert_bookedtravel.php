<?php
    //headers
    header("Access-Control-Allow-Origin: *");
    header("Content-Type: application/json; charset=UTF-8");
    header("Access-Control-Allow-Methods: POST");
    header("Access-Control-Max-Age: 3600");
    header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

    //include
    include_once("../config/MongoDB.php");
    include_once("../config/Session.php");
    include_once("../config/Mail.php");
    include_once("../config/timestamp.php");
    include_once("../models/BookedTravel.php");


    $params = json_decode(file_get_contents("php://input"));

    try {

        if (isset($params->id_travel) && strlen($params->id_travel) >= 24) {

            $session = new Session();
            if ($session->isSet("id")) {
                //book travel only if user is logged

                //new mongo instance
                $mongo = new MongoDB();

                $travel = $mongo->ReadOneQuery("scroKING", "Travels", $params->id_travel);
                $user = $mongo->ReadOneQuery("scroKING", "Users", $session->get("id"), ['email']);

                if ($travel && $user) {
                    //Query blockchain
                    $description = "Prenotazione viaggio n." . $params->id_travel;
                    $url = "http://vox3715217.mynet.vodafone.it:6999//prenotazione_viaggio?user_id=" . rawurlencode($session->get('id')) . "&money=" . rawurlencode($travel->price) . "&description=" . rawurlencode($description);
                    $curl = curl_init();

                    curl_setopt($curl, CURLOPT_URL, $url);
                    curl_setopt($curl, CURLOPT_RETURNTRANSFER,true);
                    curl_setopt($curl, CURLOPT_HEADER, false);

                    $result = curl_exec($curl);
                    $http_status_code = curl_getinfo($curl,  CURLINFO_HTTP_CODE);

                    //close connection
                    curl_close($curl);
                    if ($http_status_code == "200") {
                        $doc = new BookedTravel($mongo->getNewIdObject(), $params->id_travel, $session->get("id"), getTimestamp());


                        //insert booked travel in db
                        $mongo->WriteOneQuery("scroKING", "BookedTravels", $doc);

                        //send mail of confirm
                        $mail = new Mail();
                        $mail->sendEmail($user->mail, "Prenotazione effettuata con succeso", "Congratulazioni la tua prenotazione è avvenuta con successo");

                        //response: 200 Success
                        http_response_code(200);
                        echo json_encode(array("message" => "Prenotato con successo"));
                    } else if ($http_status_code == "406"){
                        //response: 406 Not Acceptable
                        http_response_code(406);
                        echo json_encode(array("message" => "Non abbastanza soldi"));
                    } else {
                        //response: 500 Internal Server Error
                        http_response_code(500);
                        echo json_encode(array("message" => "Node server error"));
                    }

                } else {
                    //response: 404 Not Found
                    http_response_code(404);
                    echo json_encode(array("message" => "ID viaggio non presente"));
                }
            } else {
                //response: 401 Unauthorized
                http_response_code(401);
                echo json_encode(array("message" => "Utente non loggato."));
            }
        } else {
            //response: 400 Bad Request
            http_response_code(400);
            echo json_encode(array("message" => "Parametri mancanti o errati."));
        }

    } catch (Exception | MongoDB\Driver\Exception\Exception $e) {
        //response: 500 Internal Server Error
        http_response_code(500);
        echo json_encode(array("message" => "Errore lato server.", "verbose" => $e->getMessage()));
    }
