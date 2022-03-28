<?php

use PHPMailer\PHPMailer\SMTP;



$mail = new PHPMailer\PHPMailer\PHPMailer(True);
$mail->isSMTP();
$mail->SMTPAuth = true;
$mail->CharSet = 'UTF-8';
$mail->Host = "smtp.gmail.com"; // Servidor SMTP
$mail->SMTPSecure = "tls"; // conexão segura com TLS
$mail->Port = 587;
$mail->SMTPAuth = true; // Caso o servidor SMTP precise de autenticação
$mail->Username = "walkworksuporte@gmail.com"; // SMTP username
$mail->Password = "@walkwork"; // SMTP password
$mail->From = "walkworksuporte@gmail.com"; // From
$mail->FromName = "Laboratório Nacional de Engenharia Civil" ; // Nome de quem envia o email
$mail->AddAddress($mailDestino, $nome); // Email e nome de quem receberá //Responder
$mail->WordWrap = 50; // Definir quebra de linha
$mail->IsHTML = true ; // Enviar como HTML
$mail->Subject = $assunto ; // Assunto
$mail->Body = '<br/>' . $mensagem . '<br/>' ; //Corpo da mensagem caso seja HTML
$mail->AltBody = "$mensagem" ; //PlainText, para caso quem receber o email não aceite o corpo HTML
$mail->SMTPSecure = PHPMailer\PHPMailer\PHPMailer::ENCRYPTION_STARTTLS;
//$mail->SMTPDebug = SMTP::DEBUG_SERVER;

if(!$mail->send()) // Envia o email
{
    echo "Erro no envio da mensagem";
}
?>