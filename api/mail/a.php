<?php
    include_once "../config/Mail.php";

    try {
        $mail = new Mail();
        $html = "<img src='http://scroking.ddns.net/scroKING-TravelAgency/IMG/scroking_black.png'/>";
        $html = $html . "<p>Scroking <strong>Walter</strong>,</p>";
        $html = $html . "<p>sei stato scelto come amministratore unico di Scroking Team per i tuoi poteri da scroccatore</p>";
        $mail->sendEmail("christian.discenza@gmail.com", "Amministratore di Scroking Team", $html);
        echo "ok";
    } catch(Exception $e) {
        echo "cacca";
    }
