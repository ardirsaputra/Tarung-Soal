<?php
require_once('./PHPMailer/PHPMailerAutoload.php');
class Mail {
    public static function sendMail($subject,$body,$address){
        //make a objek email
        $mail = new PHPMailer();
        //set property this objeck
        $mail->isSMTP();
        $mail->SMTPAuth = true;
        $mail->SMTPSecure = 'ssl';
        $mail->Host = 'smtp.gmail.com';
        $mail->Port = '465';
        $mail->isHTML();
        $mail->Username = 'codeindevweb@gmail.com';
        $mail->Password = '!@#qweasdzxc';
        $mail->SetFrom('no-reply@teamars.com');
        $mail->Subject = $subject;
        $mail->Body = $body;
        $mail->AddAddress($address);
        //function to send mail
        $mail->Send();
    }
}
?>


