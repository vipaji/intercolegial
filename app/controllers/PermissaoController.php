<?php

Class PermissaoController extends Controller {

    public function init() {
        $this->auth = new AuthHelper();
        $this->auth->setLoginControllerAction('Login', 'index')->checkLogin('redirect');

        $this->session = new SessionHelper();
        $this->dados['userInfo'] = $this->session->selectSession('userData');

        $this->dados['title_page'] = "Permissão &bull; Oliva de Angola &#8482;";
        $this->dados['page_context'] = "Permissão";
        $this->dados['page_icon'] = "fa fa-asterisk";
        $this->dados['page_url'] = 'https://www.intercolegialtinatune.co.ao/Permissao/';
        $this->dados['home_url'] = 'https://www.intercolegialtinatune.co.ao/Dashboard/';
    }

    public function indexAction() {
        try
        {
            $permissaoDAO = new PermissaoDAO();
            $this->dados['entities'] = $permissaoDAO->listarTodas();
            $this->view('permissao/index', $this->dados);
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
            $this->view('permissao/nova', $this->dados);
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
            $permissao = new Permissao();
            $permissao->setNome(filter_input(INPUT_POST, 'nome'))
                    ->setDescricao(filter_input(INPUT_POST, 'descricao'));

            $permissaoDAO = new PermissaoDAO();
            $permissaoDAO->salvar($permissao);
            $redirector = new RedirectorHelper();
            $redirector->goToControllerAction('Permissao', 'index');
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
            $permissaoDAO = new PermissaoDAO();
            $retorno = $permissaoDAO->buscarID($this->getParams('id'));
            $this->dados['entity'] = ($retorno != null ? $retorno : null);

            $this->view('permissao/ver', $this->dados);
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
            $permissaoDAO = new PermissaoDAO();
            $retorno = $permissaoDAO->buscarID($this->getParams('id'));
            $this->dados['entity'] = ($retorno != null ? $retorno : null);

            $this->view('permissao/editar', $this->dados);
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
            $permissaoDAO = new PermissaoDAO();
            $retorno = $permissaoDAO->buscarID(filter_input(INPUT_POST, 'id_permissao'));

            $permissao = $retorno;
            $permissao->setNome(filter_input(INPUT_POST, 'nome'))
                    ->setDescricao(filter_input(INPUT_POST, 'descricao'));

            $permissaoDAO->actualizar($permissao);
            $redirector = new RedirectorHelper();
            $redirector->setUrlParameter('id', $permissao->getId());
            $redirector->goToControllerAction('Permissao', 'ver');

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
            if (!$this->auth->HasPermission("eliminarPermissao")) {
                throw new \Exception("Não estás autorizado a efectuar esta operação.");
            }
            $permissaoDAO = new PermissaoDAO();

            $retorno = $permissaoDAO->buscarID($this->getParams('id'));
            if (!$retorno) {
                echo 'Permissão não encontrada.';
            }
            $permissaoDAO->eliminar($retorno);
            $redirector = new RedirectorHelper();
            $redirector->goToControllerAction('Permissao', 'index');
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