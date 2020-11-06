<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

include_once('PHPMailer/src/PHPMailer.php');
include_once('PHPMailer/src/SMTP.php');
include_once('PHPMailer/src/Exception.php');

class Email {

    public function enviar($To, $From, $assunto = null, $texto = null, $CC = null, $BCC = null) {

        $mail = new PHPMailer(true);                              // Passing `true` enables exceptions
        try {
//Server settings
//          luanda.angoweb.biz
//          mail.grupoboavida.co.ao
//          $mail->SMTPDebug = 2;                                 // Enable verbose debug output
            $mail->isSMTP();                                      // Set mailer to use SMTP
            $mail->Host = 'benguela.angoweb.biz';              // Specify main and backup SMTP servers
            $mail->SMTPAuth = true;                               // Enable SMTP authentication
            $mail->Username = Geral::EMAIL_MUXIMA_NOTIFICACAO;     // SMTP username
            $mail->Password = Geral::PASSWORD_MUXIMA_NOTIFICACAO;                           // SMTP password
            $mail->SMTPSecure = 'ssl';                            // Enable TLS encryption, `ssl` also accepted
            $mail->Port = Geral::SMTP_PORT;                                    // TCP port to connect to
            //Recipients
            $mail->addAddress($To);     // Add a recipient  
            $mail->setFrom($From);
            $mail->AddEmbeddedImage('web-files/default/Email/images/banner2.png', 'teste','rocks.png');

            $cssCode = '* { margin: 0; padding: 0; font-size: 100%; font-family: "Avenir Next", "Helvetica Neue", "Helvetica", Helvetica, Arial, sans-serif; line-height: 1.65; }
img { max-width: 100%; display: block;  padding:0px; }
body, .body-wrap { width: 100% !important; height: 100%; background: #f8f8f8; }
a { color: #378fbc; text-decoration: none; }
a:hover { text-decoration: underline; }
.text-center { text-align: center; }
.text-right { text-align: right; }
.text-left { text-align: left; }
.button { display: inline-block; color: white; background: #378fbc; border: solid #378fbc; border-width: 10px 20px 8px; font-weight: bold; border-radius: 4px; }
.button:hover { text-decoration: none; }
h1, h2, h3, h4, h5, h6 { margin-bottom: 20px; line-height: 1.25; }
h1 { font-size: 32px; }
h2 { font-size: 28px; }
h3 { font-size: 24px; }
h4 { font-size: 20px; }
h5 { font-size: 16px; }
p, ul, ol { font-size: 16px; font-weight: normal; margin-bottom: 20px; }
.container { display: block !important; clear: both !important; margin: 0 auto !important; max-width: 580px !important; }
.container table { width: 100% !important; border-collapse: collapse; }

.container .masthead h1 { margin: 0 auto !important; max-width: 90%; text-transform: uppercase; }
.container .content { background: white; padding: 10px 35px; }
.container .content.footer { background: none; }
.container .content.footer p { margin-bottom: 0; color: #888; text-align: center; font-size: 14px; }
.container .content.footer a { color: #888; text-decoration: none; font-weight: bold; }
.container .content.footer a:hover { text-decoration: underline; }';


            $message = '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">';
            $message .= '<html xmlns="http://www.w3.org/1999/xhtml"><head>';
            $message .= '<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />';
            $message .= '<meta name="viewport" content="width=device-width"/>';
            $message .= '<style type="text/css"> ' . $cssCode . ' </style></head>';
            $message .= '<body><img src="cid:teste"><table class="body-wrap"><tr><td class="container">';
            $message .= '<!-- Message start --><table ><tr><td align="center" class="masthead" >';
            $message .= '</td></tr> <tr style = "border-bottom: 1px solid #378fbc;"><td class="content"><h2>Saudações prezado(a),</h2>';
            $message .= '<p>' . $texto . '</p><table><tr><td align="center"><p>';
            $message .= '<a href="#" class="button">Aceder ao Muxima Helpdesk Service </a></p></td></tr></table>';
            $message .= '</td></tr></table></td></tr><tr><td class="container"><table><tr><td class="content footer" align="center">';
            $message .= '<p>Enviado por <a href="#">Grupo Boa Vida</a>, <br/>Avenida Comandante Fidel de Castro (Ex-Via Expresso) sentido Benfica Viana, próximo à entrada do Lar do Patriota,<br/>Tel.: +244  927 688 888</p>';
            $message .= '<p>E-mail:<a href="mailto:">muximacentral@grupoboavida.co.ao</a></p></td></tr></table></td>';
            $message .= '</tr></table></body></html>';

            $CC != null ? $mail->addCC($CC) : "";
            $BCC != null ? $mail->addBCC($BCC) : "";

            // Name is optional
            $mail->addReplyTo('no-reply@grupoboavida.co.ao');

//Content
            $mail->isHTML(true);
            $mail->CharSet = 'UTF-8';
            // Set email format to HTML
            $mail->Subject = "Muxima Helpdesk Service - " . $assunto;


            $mail->Body = $message;
            $mail->AltBody = $message;


            $mail->send();
        } catch (Exception $e) {
             throw new \Exception("Falhou o envio de e-mail.");
        }
    }

}
