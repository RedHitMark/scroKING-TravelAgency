<?php
    //Import PHPMailer classes into the global namespace
    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\Exception;

    require '../config/PHPMailer/Exception.php';
    require '../config/PHPMailer/PHPMailer.php';
    require '../config/PHPMailer/SMTP.php';

    try {
        //Create a new PHPMailer instance
        $mail = new PHPMailer;
        //Tell PHPMailer to use SMTP
        $mail->isSMTP();


        //Enable SMTP debugging
        // 0 = off (for production use)
        // 1 = client messages
        // 2 = client and server messages
        $mail->SMTPDebug = 0;
        //Set the hostname of the mail server
        $mail->Host = 'out.virgilio.it';
        // use
        // $mail->Host = gethostbyname('smtp.gmail.com');
        // if your network does not support SMTP over IPv6
        //Set the SMTP port number - 587 for authenticated TLS, a.k.a. RFC4409 SMTP submission
        $mail->Port = 465;
        //Set the encryption system to use - ssl (deprecated) or tls
        $mail->SMTPSecure = 'ssl';
        //Whether to use SMTP authentication
        $mail->SMTPAuth = true;
        //Username to use for SMTP authentication - use full email address for gmail
        $mail->Username = "info_scroking@virgilio.it";
        //Password to use for SMTP authentication
        $mail->Password = "Facile12";
        //Set who the message is to be sent from
        $mail->setFrom('info_scroking@virgilio.it', 'Scroking Team');
        //Set who the message is to be sent to
        $mail->addAddress('russodivito.marco@gmail.com', 'Marco Russodivito');
        //Set the subject line
        $mail->Subject = 'PHPMailer SMTP test';
        //Read an HTML message body from an external file, convert referenced images to embedded,
        //convert HTML into a basic plain-text alternative body
        $mail->msgHTML("<img src='http://scroking.ddns.net/scroKING-TravelAgency/IMG/scroking_black.png' alt='cacca'/>");
        //Replace the plain text body with one created manually
        $mail->AltBody = 'This is a plain-text message body';
        //send the message, check for errors
        if (!$mail->send()) {
            echo "Mailer Error: " . $mail->ErrorInfo;
        } else {
            echo "Message sent!";
            //Section 2: IMAP
            //Uncomment these to save your message in the 'Sent Mail' folder.
            //if (save_mail($mail)) {
            //    echo "Message saved!";
            //}
        }
    } catch(Exception $e) {
        echo "cacca";
    }
