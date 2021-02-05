<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;

require __DIR__ . '/../PHPMailer/PHPMailer.php';
require __DIR__ . '/../PHPMailer/SMTP.php';
require __DIR__ . '/../PHPMailer/Exception.php';

require_once __DIR__ . '/Controller.php';

class ContactController extends Controller
{
    function __construct()
    {
    }

    public function contact()
    {
        if (!empty($_POST['action'])) {
            $data['FirstName'] = $_POST['firstname'];
            $data['LastName'] = $_POST['lastname'];
            $data['Email'] = $_POST['email'];
            $data['Phone'] = $_POST['tel'];
            $data['Question'] = $_POST['vraag'];

            $mail = new PHPMailer();
            $mail->isSMTP();

            // SMTP::DEBUG_OFF = off (for production use)
            // SMTP::DEBUG_SERVER = client and server messages
            $mail->SMTPDebug = SMTP::DEBUG_OFF;


            $mail->Host = 'smtp.gmail.com';
            // $mail->Host = gethostbyname('smtp.gmail.com');

            $mail->Port = 587;
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->SMTPAuth = true;
            $mail->Username = 'smtp.lichtenliefde@gmail.com';
            $mail->Password = 'siwacefoxrkrcdyi';

            $mail->setFrom('smtp.lichtenliefde@gmail.com', 'Licht En Liefde');
            $mail->addReplyTo($data['Email'], $data['FirstName'] . ' ' . $data['LastName']);

            //Set who the message is to be sent to
            $mail->addAddress('soilin.sly@gmail.com', 'Pieter Jan');

            $mail->Subject = 'Vraag voor Licht en Liefde';

            $msg = "Deze mail is verzonden op " . date("d-m-Y") . "\n";
            $msg .= "Naam: " . $data['FirstName'] . ' ' . $data['LastName'] . "\n";
            $msg .= "Email: " . $data['Email'] . "\n";
            if (!empty($data['Phone'])) {
                $msg .= "Telefoon: " . $data['Phone'] . "\n";
            }
            $msg .= "Vraag: \n";
            $msg .= $data['Question'];

            $mail->msgHTML(nl2br($msg));
            $mail->AltBody = $msg;

            if (!$mail->send()) {
                $_SESSION['error'] = $mail->ErrorInfo;
            } else {
                $_SESSION['info'] = 'Mail verzonden';
            }
        }
    }
}
