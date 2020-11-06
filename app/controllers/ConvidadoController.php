<?php

Class ConvidadoController extends Controller {

    public function init() {
        /*
        $this->auth = new AuthHelper();
        $this->auth->setLoginControllerAction('Login', 'index')->checkLogin('redirect');

        $this->session = new SessionHelper();
        $this->dados['userInfo'] = $this->session->selectSession('userData');
        */

        $this->dados['title_page'] = 'Modo Convidado | Autenticador Online';
        $this->dados['page_context'] = "Modo Convidado | Autenticador Online";
        $this->dados['page_icon'] = "fa fa-dashboard";
        $this->dados['page_url'] = '/autenticador/Login/';
    }

    public function indexAction() {
        try {

            //$this->dados['publicacoes'] = (new PublicacaoDAO())->listarTodasPublicadas();

            $this->view('convidado/index', $this->dados);
        } catch (Exception $exc) {
            $this->dados['mensagem'] = $exc->getMessage();
            $this->view('erro/erro', $this->dados);
        }
    }

    public function contactarAction() {
        try
        {
            // Enviar email de activação da conta
            Ini_set ('display_errors', 1);
            Error_reporting (E_ALL);

            $to = "norulles.org@hotmail.com";
            $from = filter_input(INPUT_POST, 'email');
            $name = filter_input(INPUT_POST, 'nome');
            $subject = filter_input(INPUT_POST, 'assunto');
            $cmessage = filter_input(INPUT_POST, 'mensagem');

            $headers = "From: $from";
            $headers = "From: " . $from . "\r\n";
            $headers .= "Reply-To: ". $from . "\r\n";
            $headers .= "MIME-Version: 1.0\r\n";
            $headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";

            $subject = ".";

            $logo = 'https://www.angoeauchamber.com/autenticador/web-files/img/logo.png';
            $link = 'https://www.angoeauchamber.com/';

            $body = "<!DOCTYPE html><html lang='en'><head><meta charset='UTF-8'><title>E-mail Expresso</title></head><body>";
            $body .= "<table style='width: 100%;'>";
            $body .= "<thead style='text-align: center;'><tr><td style='border:none;' colspan='2'>";
            $body .= "<a href='{$link}'><img src='{$logo}' alt=''></a><br><br>";
            $body .= "</td></tr></thead><tbody><tr>";
            $body .= "<td style='border:none;'><strong>Nome:</strong> {$name}</td>";
            $body .= "<td style='border:none;'><strong>Email:</strong> {$from}</td>";
            $body .= "</tr>";
            $body .= "<tr><td style='border:none;'><strong>Assunto:</strong> {$subject}</td></tr>";
            $body .= "<tr><td></td></tr>";
            $body .= "<tr><td colspan='2' style='border:none;'>{$cmessage}</td></tr>";
            $body .= "</tbody></table>";
            $body .= "</body></html>";

            $send = mail($to, $subject, $body, $headers);		
            if(!$send)
            {
                echo "<script>alert('Não foi possivel enviar mensagem.');</script>";
                $this->view('home/contacto', $this->dados);
            }
            else
            {
                echo "<script>alert('Mensagem enviada com sucesso.');</script>";
                $this->view('home/contacto', $this->dados);
            }
            // Fim do envio de email para activação da conta
            
        } 
        catch (Exception $exc)
        {
            $this->dados['mensagem'] = $exc->getMessage();
            $this->view('erro/erro', $this->dados);
        }
    }

}