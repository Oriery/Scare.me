<?php

function sendEmail(string $destAddr, string $subject, string $data) {
    require '../mailer/PHPMailer.php';
    require '../mailer/SMTP.php';
    require '../mailer/Exception.php';

    $from = "fromthedeepsize@gmail.com";
    $mail = new PHPMailer\PHPMailer\PHPMailer();
    $mail->IsHTML(true);
    $mail->IsSMTP();
    $mail->SMTPAuth = true;
    $mail->SMTPSecure = "ssl";
    $mail->Host = "smtp.gmail.com";
    $mail->Port = 465;
    $mail->Username = $from;
    $mail->Password = "dwxlihubhbcuhqlv";
    $mail->setFrom($from, "ScareMe");
    $message = htmlspecialchars($data);
    $message = trim($message);

    $mail->Subject = $subject;
    $mail->Body = $message;

    $mail->addAddress($destAddr);

    try {
        $mail->send();
    } catch (\PHPMailer\PHPMailer\Exception $e) {

    }
}
