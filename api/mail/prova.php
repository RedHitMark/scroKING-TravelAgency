<?php
include_once ("../config/Mail.php");

//send email to confirm registration
$mail = new Mail();
$html_text_email = file_get_contents("http://scroking.ddns.net/scroKING-TravelAgency/api/mail/registration_email.htm");

$html_text_email = str_replace("%cliente%", "Marco Russodivito", $html_text_email);
echo $html_text_email;

$mail->sendEmail("russodivito.marco@gmail.com", "Benvenuto in scroKING", $html_text_email);
