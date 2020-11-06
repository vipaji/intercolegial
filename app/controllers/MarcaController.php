<?php

Class MarcaController extends Controller {

    public function init() {
        $this->auth = new AuthHelper();
        $this->auth->setLoginControllerAction('Login', 'index')->checkLogin('redirect');

        $this->session = new SessionHelper();
        $this->dados['userInfo'] = $this->session->selectSession('userData');

        $this->dados['title_page'] = "Marca &bull; Oliva de Angola &#8482;";
        $this->dados['page_context'] = "Marca";
        $this->dados['page_icon'] = "fa fa-start";
        $this->dados['page_url'] = '/intercolegial/Marca/';
        $this->dados['home_url'] = '/intercolegial/Dashboard/';
    }

    public function indexAction() {
        try
        {
            $marcaDAO = new MarcaDAO();
            $this->dados['entities'] = $marcaDAO->listarTodas();
            $this->view('marca/index', $this->dados);
        }
        catch (Exception $exc)
        {
            //$this->dados['mensagem'] = ($exc->getCode() == "23000" ? "Dado(s) duplicado(s)" : "");
            $this->dados['mensagem'] = $exc->getMessage();
            $this->view('erro/in', $this->dados);
        }
    }

    public function novaAction() {
        try
        {
            $this->view('marca/nova', $this->dados);
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
            $marca = new Marca();
            $marca->setNome(filter_input(INPUT_POST, 'nome'))
                ->setDescricao(filter_input(INPUT_POST, 'descricao'));

            $marcaDAO = new MarcaDAO();
            $marcaDAO->salvar($marca);
            $redirector = new RedirectorHelper();
            $redirector->goToControllerAction('Marca', 'index');
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
            $marcaDAO = new MarcaDAO();
            $retorno = $marcaDAO->buscarID($this->getParams('id'));
            $this->dados['entity'] = ($retorno != null ? $retorno : null);

            $this->view('marca/ver', $this->dados);
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
            $marcaDAO = new MarcaDAO();
            $retorno = $marcaDAO->buscarID($this->getParams('id'));
            $this->dados['entity'] = ($retorno != null ? $retorno : null);

            $this->view('marca/editar', $this->dados);
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
            $marcaDAO = new MarcaDAO();
            $retorno = $marcaDAO->buscarID(filter_input(INPUT_POST, 'id_marca'));

            $marca = $retorno;
            $marca->setNome(filter_input(INPUT_POST, 'nome'))
                    ->setDescricao(filter_input(INPUT_POST, 'descricao'));

            $marcaDAO->actualizar($marca);
            $redirector = new RedirectorHelper();
            $redirector->setUrlParameter('id', $marca->getId());
            $redirector->goToControllerAction('Marca', 'ver');

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
            if (!$this->auth->HasPermission("eliminarMarca")) {
                throw new \Exception("Não estás autorizado a efectuar esta operação.");
            }
            $marcaDAO = new MarcaDAO();

            $retorno = $marcaDAO->buscarID($this->getParams('id'));
            if (!$retorno) {
                echo 'Permissão não encontrada.';
            }
            $marcaDAO->eliminar($retorno);
            $redirector = new RedirectorHelper();
            $redirector->goToControllerAction('Marca', 'index');
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