<?php
include_once ("../config/Mail.php");

//send email to confirm registration
$mail = new Mail();
$html_text_email = file_get_contents("../mail/email.html");
str_replace("%cliente%", "Marco" . " " . "Russodivito", $html_text_email);
$mail->sendEmail("russodivito.marco@gmail.com", "Benvenuto in scroKING", $html_text_email);
