<?php
    //Import PHPMailer classes into the global namespace
    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\Exception;

    require '../config/PHPMailer/Exception.php';
    require '../config/PHPMailer/PHPMailer.php';
    require '../config/PHPMailer/SMTP.php';

    class Mail {
        //SMTP server params
        private const VIRGILIO_SMTP_HOSTNAME = "out.virgilio.it";
        private const VIRGILIO_SMTP_PORT = 465;
        private const VIRGILIO_SMTP_SECURE = "ssl";

        //account parmas
        private const VIRGILIO_USERNAME = "info_scroking@virgilio.it";
        private const VIRGILIO_PASSWORD = "Facile12";

        //mail info
        private const VIRGILIO_EMAIL = "info_scroking@virgilio.it";
        private const VIRGILIO_NAME = "Scroking Team";

        //debug messages
        private const OFF = 0; //for production use)
        private const CLIENT_MESSAGE = 1; //only client message logs
        private const CLIENT_SERVER_MESSAGE = 2; //client and server message logs

        //delega
        private $mail;

        public function __construct() {
            //Create a new PHPMailer instance
            $this->mail = new PHPMailer;

            //Tell PHPMailer to use SMTP
            $this->mail->isSMTP();

            //Enable or disable SMTP debugging
            $this->mail->SMTPDebug = Mail::OFF;

            //Set the hostname of the mail server
            $this->mail->Host = Mail::VIRGILIO_SMTP_HOSTNAME;

            //Set the SMTP port number
            $this->mail->Port = Mail::VIRGILIO_SMTP_PORT;

            //Set the encryption system to use - ssl or tls
            $this->mail->SMTPSecure = Mail::VIRGILIO_SMTP_SECURE;

            //Whether to use SMTP authentication
            $this->mail->SMTPAuth = true;

            //Username to use for SMTP authentication - use full email address for gmail
            $this->mail->Username = Mail::VIRGILIO_USERNAME;

            //Password to use for SMTP authentication
            $this->mail->Password = Mail::VIRGILIO_PASSWORD;
        }

        /**
         * @param $to
         * @param $subject
         * @param $htmlMessage
         * @throws Exception
         */
        public function sendEmail($to, $subject, $htmlMessage) {
            //Set who sent the message is to be sent by
            $this->mail->setFrom(Mail::VIRGILIO_EMAIL, Mail::VIRGILIO_NAME);

            //Set who the message is to be sent to
            $this->mail->addAddress($to);

            //Set the subject line
            $this->mail->Subject = $subject;

            //Set the html message
            $this->mail->msgHTML($htmlMessage);

            $this->mail->send();
        }
    }
