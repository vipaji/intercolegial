<?php

class HomeController extends Controller
{

    public function init()
    {

        $this->dados['title_page'] = 'Intercolegial Tina Tune';
        $this->dados['page_context'] = "Intercolegial Tina Tune";
        $this->dados['page_icon'] = "fa fa-home";
        $this->dados['page_url'] = 'https://www.intercolegialtinatune.co.ao/Home/';
    }

    public function indexAction()
    {
        try {
            $this->dados['perfis'] = (new PerfilDAO())->listarPerfilInscricao();
            $this->dados['escolas'] = (new EscolaDAO())->listarTodas();
            $this->dados['blogs'] = (new BlogDAO())->listarTodosActivos();
            $this->view('home/index', $this->dados);
        } catch (Exception $exc) {
            $this->dados['mensagem'] = $exc->getMessage();
            $this->view('erro/erro', $this->dados);
        }
    }

    public function blogAction()
    {
        try {
            $blogDAO = new BlogDAO();
            $retorno = $blogDAO->buscarID($this->getParams('id'));
            $this->dados['entity'] = ($retorno != null ? $retorno : null);
            if ($this->dados['entity'] == null) {
                throw new \Exception("Página não encontrada.");
            }
            $this->dados['escolas'] = (new EscolaDAO())->listarTodas();
            $this->dados['recentes'] = (new BlogDAO())->recentes();
            $this->view('home/blog', $this->dados);
        } catch (Exception $exc) {
            $this->dados['mensagem'] = $exc->getMessage();
            $this->view('erro/erro', $this->dados);
        }
    }

    public function registarAction()
    {
        try {
            echo "Inscrição feita";
        } catch (Exception $exc) {
            $this->dados['mensagem'] = $exc->getMessage();
            $this->view('erro/erro', $this->dados);
        }
    }

    public function activacaoAction()
    {
        try {
            $utilizadorDAO = new UtilizadorDAO();
            $retorno = $utilizadorDAO->buscarEMAIL($this->getParams('email'));

            $utilizador = $retorno;

            $utilizador->setEstado(Geral::CONS_UTILIZADOR_ACTIVADO);

            $utilizadorDAO->activar($utilizador);
            $redirector = new RedirectorHelper();
            $redirector->goToControllerAction('Login', 'index');

            unset($redirector);
        } catch (Exception $exc) {
            $this->dados['mensagem'] = $exc->getMessage();
            $this->view('erro/erro', $this->dados);
        }
    }

    public function inscricaoAction()
    {
        try {
            $estudantes = (new UtilizadorDAO())->findByEmail(filter_input(INPUT_POST, 'email'));

            if (count($estudantes) > 0) {
                $arr_resposta["codigo"] = 300;
                echo json_encode($arr_resposta);
            } else {
                $estudante = new Utilizador();
                $estudante->setNome(filter_input(INPUT_POST, 'nome'))
                    ->setEmail(filter_input(INPUT_POST, 'email'))
                    ->setPassword(md5(filter_input(INPUT_POST, 'passe')))
                    ->setPerfil(2)
                    ->setEstado(Geral::CONS_UTILIZADOR_DESACTIVADO)
                    ->setTelefone(filter_input(INPUT_POST, 'telefone'))
                    ->setEscola((new EscolaDAO())->buscarID(filter_input(INPUT_POST, 'escola')))
                    ->setDataInscricao(date('Y-m-d'));

                $estudanteDAO = new UtilizadorDAO();
                $objUtilizador = $estudanteDAO->salvar($estudante);
                if ($objUtilizador != null) {

                    // Enviar email 
                    Ini_set('display_errors', 1);
                    Error_reporting(E_ALL);

                    $to = filter_input(INPUT_POST, 'email');
                    $nome = filter_input(INPUT_POST, 'nome');
                    $from = "intercolecialtinatune@jam.co.ao";

                    $headers = "From: $from";
                    $headers = "From: " . $from . "\r\n";
                    $headers .= "Reply-To: " . $from . "\r\n";
                    $headers .= "MIME-Version: 1.0\r\n";
                    $headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";

                    $subject = "INSCRICAO | INTERCOLEGIAL TINA TUNE";

                    $logo = 'https://www.jam.co.ao/jam/web-files/assets/img/logo-dark.png';
                    $link = 'https://www.jam.co.ao/';

                    $body = "<!DOCTYPE html><html lang='en'><head><meta charset='UTF-8'><title>Activar conta</title></head><body>";
                    $body .= "<div style='width:100%'>";
                    $body .= "<h3 style='color:#DC3E0F; text-align:center;'>ACTIVA&Ccedil;&Atilde;O DA CONTA</h3><hr>";
                    $body .= "<p style='text-align:justify; color:#000000;'><span style='font-size:18px;'><b>Parab&eacute;ns!</b></span><br>A sua inscri&ccedil;&atilde;o foi com sucesso.<br><br>";
                    $body .= "<a href='https://www.jam.co.ao/Home/activacao/" . base64_encode("email") . '/' . base64_encode(filter_input(INPUT_POST, 'email')) . "'>Activar a conta agora</a>";
                    $body .= "<br>Ap&oacute;s activa&ccedil;&atilde;o da conta, o site redicionar&aacute;-lo para o <a href='https://www.jam.co.ao/Login'>in&iacute;cio de sess&atilde;o.</a></p>";
                    $body .= "<p style='color:#000000;'>{$nome}</p>";
                    $body .= "<br><br><hr><a href='{$link}'><img src='{$logo}' alt='JAM Entertainment'></a>";
                    $body .= "<br><span style='font-size:12px;'>Tel: +(244) 931 199 396<br>Estrada do Lar do Patriota, Edif. Kissange, 1&ordf; Andar A<br>Luanda, Angola</span>";
                    $body .= "</div>";
                    $body .= "</body></html>";
                   
                    if (@mail($to, $subject, $body, $headers)) {
                        $arr_resposta["codigo"] = 200;
                        echo json_encode($arr_resposta);
                    } else {
                        $arr_resposta["codigo"] = 500;
                        echo json_encode($arr_resposta);
                    }
                    // Fim do envio de email para activação da conta

                }
            }
        } catch (Exception $exc) {
            $this->dados['mensagem'] = $exc->getMessage();
            $this->view('erro/erro', $this->dados);
        }
    }

    public function emailAction()
    {
        // Enviar email 
        Ini_set('display_errors', 1);
        Error_reporting(E_ALL);

        $to = "intercolegialtinatune@jam.co.ao";
        $nome = filter_input(INPUT_POST, 'nome');
        $from = filter_input(INPUT_POST, 'email');
        $assunto = filter_input(INPUT_POST, 'assunto');
        $message = filter_input(INPUT_POST, 'mensagem');

        $headers = "From: $from";
        $headers = "From: " . $from . "\r\n";
        $headers .= "Reply-To: " . $from . "\r\n";
        $headers .= "MIME-Version: 1.0\r\n";
        $headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";

        $subject = "MAIL EXPRESS | ".$assunto;

        $logo = 'https://www.intercolegialtinatune.co.ao/web-files/images/logo_front.png';
        $link = 'https://www.intercolegialtinatune.co.ao/';

        $body = "<!DOCTYPE html><html lang='en'><head><meta charset='UTF-8'><title>MAIL EXPRESS</title></head><body>";
        $body .= "<div style='width:100%'>";
        $body .= "<h3 style='color:#DC3E0F; text-align:center;'>*</h3><hr>";
        $body .= "<p style='text-align:justify; color:#000000;'>{$message}<br><br>";
        $body .= "Por: {$nome}<br></p>";
        $body .= "<br><br><hr><a href='{$link}'><img src='{$logo}' alt='INTERCOLEGIAL TINA TUNE'></a>";
        $body .= "<br><span style='font-size:12px;'>Este email foi enviado via Web.</span>";
        $body .= "</div>";
        $body .= "</body></html>";
       
        if (@mail($to, $subject, $body, $headers)) {
            $arr_resposta["codigo"] = 200;
            echo json_encode($arr_resposta);
        } else {
            $arr_resposta["codigo"] = 500;
            echo json_encode($arr_resposta);
        }
        // Fim do envio de email para activação da conta
    }
}
