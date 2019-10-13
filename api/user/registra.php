<?php
    //headers
    header("Access-Control-Allow-Origin: *");
    header("Content-Type: application/json; charset=UTF-8");
    header("Access-Control-Allow-Methods: POST");
    header("Access-Control-Max-Age: 3600");
    header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

    //include
    include_once("../config/MongoDB.php");
    include_once("../models/Address.php");
    include_once("../models/User.php");
    include_once("../models/RegistrationLog.php");
    include_once ("../config/Mail.php");
    include_once ("../config/timestamp.php");
    include_once ("../config/security.php");

    //params from http body
    $params = json_decode(file_get_contents("php://input"));

    try {

        if (isset($params->username) && isset($params->password) && isset($params->name) && isset($params->surname) && isset($params->email) && isset($params->address) ) {
            $mongo = new MongoDB();

            $result_with_existent_email = $mongo->ReadQuery("scroKING", "Users", ["email" => $params->email], [], 1);
            $result_with_existent_username = $mongo->ReadQuery("scroKING", "Users", ["username" => $params->username], [], 1);

            if (count($result_with_existent_email) == 0 && count($result_with_existent_username) == 0) {
                $address = new Address($params->address->street, $params->address->city, $params->address->cap, $params->address->region, $params->address->state);
                $doc = new User( $mongo->getNewIdObject(),$params->name ,$params->surname, $address, $params->email, $params->username , $params->password, "customer",0, 0);

                //write new user in db
                $mongo->WriteOneQuery("scroKING", "Users", $doc);

                //save registration log in db
                $registrationLog = new RegistrationLog(getTimestamp(), getClientIp(), $params->username, $params->email, "OK");
                $mongo->WriteOneQuery("scroKING", "RegistrationLog", $registrationLog);

                //mail instance
                $mail = new Mail();

                //load html text of mail from file and replace with new client name
                $html_text_email = file_get_contents("http://scroking.ddns.net/scroKING-TravelAgency/api/mail/registration_email.htm");
                $html_text_email = str_replace("%cliente%", $params->name . " " . $params->surname, $html_text_email);

                //send mail to confirm registration
                $mail->sendEmail($params->email, "Benvenuto in scroKING", $html_text_email);

                //response: 200  Success
                http_response_code(200);
                echo json_encode(array("message" => "Registrazione effettuata correttamente."));
            } else {
                $message = count($result_with_existent_email) == 0 ? "Username già utilizzato" : "Email già utilizzata";
                $message = count($result_with_existent_email) >= 1 && count($result_with_existent_username) >= 1? "Username e email già utilizzate" : $message;

                //response: 406 Not Acceptable
                http_response_code(406);
                echo json_encode(array("message" => $message));
            }

        } else {
            //response: 400 Bad Request
            http_response_code(400);
            echo json_encode(array("message" => "Parametri mancanti."));
        }
        
    } catch (Exception | MongoDB\Driver\Exception\Exception $e) {
        //response: 500 Internal Server Error
        http_response_code(500);
        echo json_encode(array("message" => "Errore lato server.", "verbose" => $e->getMessage()));
    }
