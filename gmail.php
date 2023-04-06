<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require './PHPMailer/src/Exception.php';
require './PHPMailer/src/PHPMailer.php';
require './PHPMailer/src/SMTP.php';
// $mail = new PHPMailer(true);



$form=filter_input_array(INPUT_POST,FILTER_DEFAULT);
// var_dump($form);
// exit;
if(isset($form['btn-send'])){
    $dados=['email'=>trim($form['email']),'message'=>trim($form['message'])];

    try {
        //Server settings
        // $mail->SMTPDebug = SMTP::DEBUG_SERVER;                      //Enable verbose debug output
        $mail->isSMTP();                                            //Send using SMTP
        $mail->Host       = 'smtp.gmail.com';                     //Set the SMTP server to send through
        $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
        $mail->Username   = '';                     //SMTP username
        $mail->Password   = '';                               //SMTP password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
        $mail->Port       = 465;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`
    
        //Recipients
        $mail->setFrom('example@gmail.com', 'Clever');
        $mail->addAddress($dados['email'], 'Client');     //Add a recipient
    
        //Content
        $mail->isHTML(true);                                  //Set email format to HTML
        $mail->Subject = 'Test';
        $mail->Body    = "This is the HTML message body <b>in clever!</b><br>{$dados['message']}";
        $mail->AltBody = $dados['message'];
    
        $mail->send();
        header("Location:success.php");
    } catch (Exception $e) {
        header("Location:error.php");
        echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
    }

}else{
    die("Error, you didnt click the submit button");
}