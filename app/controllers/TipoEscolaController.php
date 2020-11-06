<?php

Class TipoEscolaController extends Controller {

    public function init() {
        $this->auth = new AuthHelper();
        $this->auth->setLoginControllerAction('Login', 'index')->checkLogin('redirect');

        $this->session = new SessionHelper();
        $this->dados['userInfo'] = $this->session->selectSession('userData');

        $this->dados['title_page'] = "Tipo de Escola &bull; Intercolegial Tina Tune &#8482;";
        $this->dados['page_context'] = "Tipo de Escola";
        $this->dados['page_icon'] = "fa fa-start";
        $this->dados['page_url'] = '/intercolegial/TipoEscola/';
        $this->dados['id'] = 'tipoescola';
    }

    public function indexAction() {
        try
        {
            $tipoescolaDAO = new TipoEscolaDAO();
            $this->dados['entities'] = $tipoescolaDAO->listarTodos();
            $this->view('tipoescola/index', $this->dados);
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
            $this->view('tipoescola/novo', $this->dados);
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
            $tipoescola = new TipoEscola();
            $tipoescola->setNome(filter_input(INPUT_POST, 'nome'))
                ->setDescricao(filter_input(INPUT_POST, 'descricao'));

            $tipoescolaDAO = new TipoEscolaDAO();
            $tipoescolaDAO->salvar($tipoescola);
            Method::registaLog("Adição", "Adicionou novo Tipo de Escola: <b>".filter_input(INPUT_POST, 'nome')."</b>", $this->session->selectSession('userData')->getId());
            $redirector = new RedirectorHelper();
            $redirector->goToControllerAction('TipoEscola', 'index');
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
            $tipoescolaDAO = new TipoEscolaDAO();
            $retorno = $tipoescolaDAO->buscarID($this->getParams('id'));
            $this->dados['entity'] = ($retorno != null ? $retorno : null);

            $this->view('tipoescola/ver', $this->dados);
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
            $tipoescolaDAO = new TipoEscolaDAO();
            $retorno = $tipoescolaDAO->buscarID($this->getParams('id'));
            $this->dados['entity'] = ($retorno != null ? $retorno : null);

            $this->view('tipoescola/editar', $this->dados);
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
            $tipoescolaDAO = new TipoEscolaDAO();
            $retorno = $tipoescolaDAO->buscarID(filter_input(INPUT_POST, 'id_tipoescola'));

            $tipoescola = $retorno;
            $tipoescola->setNome(filter_input(INPUT_POST, 'nome'))
                    ->setDescricao(filter_input(INPUT_POST, 'descricao'));

            $tipoescolaDAO->actualizar($tipoescola);
            $redirector = new RedirectorHelper();
            $redirector->setUrlParameter('id', $tipoescola->getId());
            $redirector->goToControllerAction('TipoEscola', 'ver');

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
            /*if (!$this->auth->HasPermission("eliminarTipoEscola")) {
                throw new \Exception("Não estás autorizado a efectuar esta operação.");
            }*/
            $tipoescolaDAO = new TipoEscolaDAO();

            $retorno = $tipoescolaDAO->buscarID($this->getParams('id'));
            if (!$retorno) {
                echo 'Permissão não encontrada.';
            }
            $tipoescolaDAO->eliminar($retorno);
            $redirector = new RedirectorHelper();
            $redirector->goToControllerAction('TipoEscola', 'index');
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