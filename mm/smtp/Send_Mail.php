<?php
function Send_Mail($to,$subject,$body)
{
require 'class.phpmailer.php';
$from       = "smhrashid@pragatilife.com";
$mail       = new PHPMailer();
$mail->IsSMTP(true);            // use SMTP
$mail->IsHTML(true);
$mail->SMTPAuth   = true;                  // enable SMTP authentication
$mail->Host       = "192.168.1.111"; // Amazon SES server, note "tls://" protocol
$mail->Port       =  25;                    // set the SMTP port
$mail->Username   = "noreply@pragatilife.com";  // SMTP  username
$mail->Password   = "3edc1RFV";  // SMTP password
$mail->SetFrom($from, 'Pragati Life Insurance Ltd.');
$mail->AddReplyTo($from,'Pragati Life Insurance Ltd.');
$mail->Subject    = 'Pragati Life Insurance Ltd Email verification';
$mail->MsgHTML($body);
$address = $to;
$mail->AddAddress($address, $to);
$mail->Send();   
}
?>
