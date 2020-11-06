<?php
Class LoginController extends Controller {

    public function indexAction() {
        $session = new SessionHelper();

        if ($session->checkSession('erros')) {
            $this->dados['erros'] = $session->selectSession('erros');
            $session->deleteSession('erros');
        }
        $this->dados['title_page'] = 'Iniciar Sessão &bull; Intercolegial Tina Tune';

        $this->view('login/index', $this->dados);
    }

    public function loginAction() {
        try
        {
            $this->auth = new AuthHelper();
            $nome_utilizador = filter_input(INPUT_POST, 'nome-utilizador');
            $password = filter_input(INPUT_POST, 'password');
            try {

                $this->auth->setUser($nome_utilizador)
                    ->setPass(md5($password))->setLoginControllerAction('Dashboard', 'index')->login();
            } catch (Exception $exc) {
                $session = new SessionHelper();
                $session->createSession('erros', $exc->getMessage());
                $redirect = new RedirectorHelper();
                $redirect->goToControllerAction('Login', 'index');
                unset($session, $redirect);
            }
        }
        catch (Exception $exc)
        {
            //$this->dados['mensagem'] = ($exc->getCode() == "23000" ? "Dado(s) duplicado(s)" : "");
            $this->dados['mensagem'] = $exc->getMessage();
            $this->view('erro/index', $this->dados);
        }
    }

    public function logoutAction() {
        try
        {
            $this->auth = new AuthHelper();
            $this->auth->setLoginControllerAction('Login', 'index')->logout();
        }
        catch (Exception $exc)
        {
            //$this->dados['mensagem'] = ($exc->getCode() == "23000" ? "Dado(s) duplicado(s)" : "");
            $this->dados['mensagem'] = $exc->getMessage();
            $this->view('erro/index', $this->dados);
        }
    }

    public function recoverAction() {
        try
        {
            $this->dados['title_page'] = 'Recuperar palavra-passe &bull; Oliva de Angola';
            $this->view('login/recover', $this->dados);
        }
        catch (Exception $exc)
        {
            $this->dados['mensagem'] = $exc->getMessage();
            $this->view('erro/index', $this->dados);
        }
    }

}