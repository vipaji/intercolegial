<?php

Class LogController extends Controller {

    public function init() {
        $this->auth = new AuthHelper();
        $this->auth->setLoginControllerAction('Login', 'index')->checkLogin('redirect');

        $this->session = new SessionHelper();
        $this->dados['userInfo'] = $this->session->selectSession('userData');

        $this->dados['title_page'] = "Actividades &bull; Oliva de Angola &#8482;";
        $this->dados['page_context'] = "Actividades";
        $this->dados['page_icon'] = "fa fa-exchange";
        $this->dados['page_url'] = 'https://www.intercolegialtinatune.co.ao/Log/';
        $this->dados['home_url'] = 'https://www.intercolegialtinatune.co.ao/Dashboard/';
    }

    public function indexAction() {
        try
        {
            /*if (!$this->auth->HasPermission("verLog")) {
                throw new \Exception("Utilizador não autorizado a ver logs.");
            }*/
            $logDAO = new LogDAO();
            $this->dados['entities'] = $logDAO->listarTodas();
            
            // $this->dados['minhasLogs'] = $logDAO->logUtilizador($this->getParams('id'));
            $this->view('log/index', $this->dados);
        }
        catch (Exception $exc)
        {
            //$this->dados['mensagem'] = ($exc->getCode() == "23000" ? "Dado(s) duplicado(s)" : "");
            $this->dados['mensagem'] = $exc->getMessage();
            $this->view('erro/in', $this->dados);
        }
    }

    public function novoAction() {
        try
        {
            $this->view('log/novo', $this->dados);
        }
        catch (Exception $exc)
        {
            //$this->dados['mensagem'] = ($exc->getCode() == "23000" ? "Dado(s) duplicado(s)" : "");
            $this->dados['mensagem'] = $exc->getMessage();
            $this->view('erro/in', $this->dados);
        }
    }

   

    public function verAction() {
        try
        {
            $logDAO = new LogDAO();
            $retorno = $logDAO->buscarID($this->getParams('id'));
            $this->dados['entity'] = ($retorno != null ? $retorno : null);

            $this->view('log/ver', $this->dados);
        }
        catch (Exception $exc)
        {
            //$this->dados['mensagem'] = ($exc->getCode() == "23000" ? "Dado(s) duplicado(s)" : "");
            $this->dados['mensagem'] = $exc->getMessage();
            $this->view('erro/in', $this->dados);
        }
    }

    public function editarAction() {
        try
        {
            $logDAO = new LogDAO();
            $retorno = $logDAO->buscarID($this->getParams('id'));
            $this->dados['entity'] = ($retorno != null ? $retorno : null);

            $this->view('log/editar', $this->dados);
        }
        catch (Exception $exc)
        {
            //$this->dados['mensagem'] = ($exc->getCode() == "23000" ? "Dado(s) duplicado(s)" : "");
            $this->dados['mensagem'] = $exc->getMessage();
            $this->view('erro/in', $this->dados);
        }
    }

    public function eliminarAction() {
        try
        {
            if (!$this->auth->HasPermission("eliminarLog")) {
                throw new \Exception("Utilizador não autorizado.");
            }
            $logDAO = new LogDAO();

            $retorno = $logDAO->buscarID($this->getParams('id'));
            if (!$retorno) {
                throw new \Exception("Registo não encontrado.");
            }
            $logDAO->eliminar($retorno);
            $redirector = new RedirectorHelper();
            $redirector->goToControllerAction('log', 'index');
            unset($redirector);
        }
        catch (Exception $exc)
        {
            //$this->dados['mensagem'] = ($exc->getCode() == "23000" ? "Dado(s) duplicado(s)" : "");
            $this->dados['mensagem'] = $exc->getMessage();
            $this->view('erro/in', $this->dados);
        }
    }
    
    
    /**
     * @Método: imprimirPdfAction
     * @Descrição: Processa a impressão (pdf) da informação do banco 
     * 
     */
    public function imprimirPdfAction() {
        try
        {
            $this->dados['entities'] = (new LogDAO())->listarTodos();
            $this->view('log/RelatorioGeralPDF', $this->dados, ".php");
        }
        catch (Exception $exc)
        {
            //$this->dados['mensagem'] = ($exc->getCode() == "23000" ? "Dado(s) duplicado(s)" : "");
            $this->dados['mensagem'] = $exc->getMessage();
            $this->view('erro/in', $this->dados);
        }
    }

}