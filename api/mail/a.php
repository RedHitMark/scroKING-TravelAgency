<?php
    include_once "../config/Mail.php";

    try {
        $mail = new Mail();
        $html = "<img src='http://scroking.ddns.net/scroKING-TravelAgency/IMG/scroking_black.png'/>";
        $html = $html . "<p>Complimenti <strong>Giovanni Ciaramella</strong>,</p>";
        $html = $html . "<p>sei stato scelto come amministratore unico di Scroking Team per i tuoi poteri da scroccatore</p>";
        $mail->sendEmail("russodivito.marco@gmail.com", "Amministratore di Scroking Team", $html);
    } catch(Exception $e) {
        echo "cacca";
    }
