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

    $new_user = json_decode(file_get_contents("php://input"));

    try {
        $mongo = new MongoDB();

        if (isset($new_user->username) && isset($new_user->password) && isset($new_user->name) && isset($new_user->surname) && isset($new_user->email) && isset($new_user->address) ) {
            $result_with_existent_email = $mongo->ReadQuery("scroKING", "Users", ["email" => $new_user->email], [], 1);
            $result_with_existent_username = $mongo->ReadQuery("scroKING", "Users", ["username" => $new_user->username], [], 1);

            if (count($result_with_existent_email) == 0 && count($result_with_existent_username) == 0) {
                $address = new Address($new_user->address->street, $new_user->address->city, $new_user->address->cap, $new_user->address->region, $new_user->address->state);
                $doc = new User( $mongo->getNewIdObject(),$new_user->name ,$new_user->surname, $address, $new_user->email, $new_user->username , $new_user->password, "customer",0);

                //write new user in db
                $mongo->WriteOneQuery("scroKING", "Users", $doc);

                //save registration log in db
                $registrationLog = new RegistrationLog(getTimestamp(), getClientIp(), $new_user->username, $new_user->email, "OK");
                $mongo->WriteOneQuery("scroKING", "LoginLogs", $registrationLog);

                //send email to confirm registration
                $mail = new Mail();
                $mail->sendEmail($new_user->email, "Conferma della registrazione", "<p>Benvenuto " . $new_user->name . "</p><p>La tua iscrizione a ScroKING Viaggi è completa!</p><p>Inizia subito a scroccare viaggi</p><p>dal Team ScroKING</p>");

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
