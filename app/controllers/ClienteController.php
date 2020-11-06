<?php

Class ClienteController extends Controller {

    public function init() {
        $this->auth = new AuthHelper();
        $this->auth->setLoginControllerAction('Login', 'index')->checkLogin('redirect');

        $this->session = new SessionHelper();
        $this->dados['userInfo'] = $this->session->selectSession('userData');

        $this->dados['title_page'] = "Cliente &bull; Oliva de Angola &#8482;";
        $this->dados['page_context'] = "Cliente";
        $this->dados['page_icon'] = "fa fa-users";
        $this->dados['page_url'] = 'https://www.intercolegialtinatune.co.ao/Cliente/';
        $this->dados['home_url'] = 'https://www.intercolegialtinatune.co.ao/Dashboard/';
    }

    public function indexAction() {
        try
        {
            $clienteDAO = new ClienteDAO();
            $this->dados['entities'] = $clienteDAO->listarTodos();
            $this->view('cliente/index', $this->dados);
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
            $this->view('cliente/novo', $this->dados);
        }
        catch (Exception $exc)
        {
            //$this->dados['mensagem'] = ($exc->getCode() == "23000" ? "Dado(s) duplicado(s)" : "");
            $this->dados['mensagem'] = $exc->getMessage();
            $this->view('erro/in', $this->dados);
        }
    }

    public function registarAction() {
        try
        {
            $cliente = new Cliente();

            $ultimoCliente = (new ClienteDAO())->ultimoCliente();

                $NumUltimoCliente = $ultimoCliente == null ? date("Y") . "." . "00000" : substr($ultimoCliente->getNumero(), 5);
                $numero = $ultimoCliente == null ? $NumUltimoCliente : date("Y") . "." . Method::geraNumeroCliente($NumUltimoCliente);

            $cliente->setNumero($numero)
                    ->setNome(filter_input(INPUT_POST, 'nome'))
                    ->setEmail(filter_input(INPUT_POST, 'email'))
                    ->setTelefone(filter_input(INPUT_POST, 'telefone'))
                    ->setDataRegisto(date('Y-m-d H:i:s'));
                    //echo "<pre>";
                    //print_r($ultimoCliente); die;

            $clienteDAO = new ClienteDAO();
            $clienteDAO->salvar($cliente);
            $redirector = new RedirectorHelper();
            $redirector->goToControllerAction('Cliente', 'index');
            unset($redirector);
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
            $clienteDAO = new ClienteDAO();
            $retorno = $clienteDAO->buscarID($this->getParams('id'));
            $this->dados['entity'] = ($retorno != null ? $retorno : null);

            $this->view('cliente/ver', $this->dados);
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
            $clienteDAO = new ClienteDAO();
            $retorno = $clienteDAO->buscarID($this->getParams('id'));
            $this->dados['entity'] = ($retorno != null ? $retorno : null);

            $this->view('cliente/editar', $this->dados);
        }
        catch (Exception $exc)
        {
            //$this->dados['mensagem'] = ($exc->getCode() == "23000" ? "Dado(s) duplicado(s)" : "");
            $this->dados['mensagem'] = $exc->getMessage();
            $this->view('erro/in', $this->dados);
        }
    }

    // Action Actualizar
    public function actualizarAction() {
        try
        {
            $clienteDAO = new ClienteDAO();
            $retorno = $clienteDAO->buscarID(filter_input(INPUT_POST, 'id_cliente'));

            $cliente = $retorno;
            $cliente->setNome(filter_input(INPUT_POST, 'nome'))
                    ->setEmail(filter_input(INPUT_POST, 'email'))
                    ->setTelefone(filter_input(INPUT_POST, 'telefone'));

            $clienteDAO->actualizar($cliente);
            $redirector = new RedirectorHelper();
            $redirector->setUrlParameter('id', $cliente->getId());
            $redirector->goToControllerAction('Cliente', 'ver');

            unset($redirector);
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
            if (!$this->auth->HasPermission("eliminarCliente")) {
                throw new \Exception("Não estás autorizado a efectuar esta operação.");
            }
            $clienteDAO = new ClienteDAO();

            $retorno = $clienteDAO->buscarID($this->getParams('id'));
            if (!$retorno) {
                echo 'Permissão não encontrada.';
            }
            $clienteDAO->eliminar($retorno);
            $redirector = new RedirectorHelper();
            $redirector->goToControllerAction('Cliente', 'index');
            unset($redirector);
        }
        catch (Exception $exc)
        {
            //$this->dados['mensagem'] = ($exc->getCode() == "23000" ? "Dado(s) duplicado(s)" : "");
            $this->dados['mensagem'] = $exc->getMessage();
            $this->view('erro/in', $this->dados);
        }
    }
}