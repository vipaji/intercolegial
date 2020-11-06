<?php

Class EscolaController extends Controller {

    public function init() {
        $this->auth = new AuthHelper();
        $this->auth->setLoginControllerAction('Login', 'index')->checkLogin('redirect');

        $this->session = new SessionHelper();
        $this->dados['userInfo'] = $this->session->selectSession('userData');

        $this->dados['title_page'] = "Escolas &bull; Intercolegial Tina Tune &#8482;";
        $this->dados['page_context'] = "Escola";
        $this->dados['page_icon'] = "fa fa-start";
        $this->dados['page_url'] = '/intercolegial/Escola/';
        $this->dados['home_url'] = '/intercolegial/Dashboard/';
        $this->dados['id'] = 'escola';
    }

    public function indexAction() {
        try
        {
            $escolaDAO = new EscolaDAO();
            $this->dados['entities'] = $escolaDAO->listarTodas();
            $this->view('escola/index', $this->dados);
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
            $this->dados['tipos'] = (new TipoEscolaDAO())->listarTodos();
            $this->view('escola/nova', $this->dados);
        }
        catch (Exception $exc)
        {
            $this->dados['mensagem'] = $exc->getMessage();
            $this->view('erro/in', $this->dados);
        }
    }

    public function registarAction() {
        try
        {
            $escolas = (new EscolaDAO())->findByNome(filter_input(INPUT_POST, 'nome'));
            if (count($escolas) > 0) {
                throw new \Exception("Já existe uma escola com este nome.");
            }

            $escola = new Escola();
            $escola->setNome(filter_input(INPUT_POST, 'nome'))
                ->setTipo(filter_input(INPUT_POST, 'tipo'))
                ->setDescricao(filter_input(INPUT_POST, 'descricao'));

            $escolaDAO = new EscolaDAO();
            $escolaDAO->salvar($escola);

            Method::registaLog("Adição", "Adicionou nova Escola: <b>".filter_input(INPUT_POST, 'nome')."</b>", $this->session->selectSession('userData')->getId());
            $redirector = new RedirectorHelper();
            $redirector->goToControllerAction('Escola', 'index');
            unset($redirector);
        }
        catch (Exception $exc)
        {
            $this->dados['mensagem'] = $exc->getMessage();
            $this->view('erro/in', $this->dados);
        }
    }

    public function verAction() {
        try
        {
            $escolaDAO = new EscolaDAO();
            $retorno = $escolaDAO->buscarID($this->getParams('id'));
            $this->dados['entity'] = ($retorno != null ? $retorno : null);
            $this->dados['tipos'] = (new TipoEscolaDAO())->listarTodos();

            $this->view('escola/ver', $this->dados);
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
            $escolaDAO = new EscolaDAO();
            $retorno = $escolaDAO->buscarID($this->getParams('id'));
            $this->dados['entity'] = ($retorno != null ? $retorno : null);
            $this->dados['tipos'] = (new TipoEscolaDAO())->listarTodos();

            $this->view('escola/editar', $this->dados);
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
            $escolaDAO = new EscolaDAO();
            $retorno = $escolaDAO->buscarID(filter_input(INPUT_POST, 'id_escola'));

            $escola = $retorno;
            $escola->setNome(filter_input(INPUT_POST, 'nome'))
                    ->setTipo(filter_input(INPUT_POST, 'tipo'))
                    ->setDescricao(filter_input(INPUT_POST, 'descricao'));

            $escolaDAO->actualizar($escola);
            $redirector = new RedirectorHelper();
            $redirector->setUrlParameter('id', $escola->getId());
            $redirector->goToControllerAction('Escola', 'ver');

            unset($redirector);
        }
        catch (Exception $exc)
        {
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
            $escolaDAO = new EscolaDAO();

            $retorno = $escolaDAO->buscarID($this->getParams('id'));
            if (!$retorno) {
                echo 'Permissão não encontrada.';
            }
            $escolaDAO->eliminar($retorno);
            $redirector = new RedirectorHelper();
            $redirector->goToControllerAction('Escola', 'index');
            unset($redirector);
        }
        catch (Exception $exc)
        {
            $this->dados['mensagem'] = $exc->getMessage();
            $this->view('erro/in', $this->dados);
        }
    }
}