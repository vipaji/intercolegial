<?php

Class EventoController extends Controller {

    public function init() {
        $this->auth = new AuthHelper();
        $this->auth->setLoginControllerAction('Login', 'index')->checkLogin('redirect');

        $this->session = new SessionHelper();
        $this->dados['userInfo'] = $this->session->selectSession('userData');

        $this->dados['title_page'] = "Eventos &bull; Intercolegial Tina Tune &#8482;";
        $this->dados['page_context'] = "Evento";
        $this->dados['page_icon'] = "fa fa-start";
        $this->dados['page_url'] = 'https://www.intercolegialtinatune.co.ao/Evento/';
        $this->dados['home_url'] = 'https://www.intercolegialtinatune.co.ao/Dashboard/';
        $this->dados['id'] = 'evento';
    }

    public function indexAction() {
        try
        {
            $eventoDAO = new EventoDAO();
            $this->dados['entities'] = $eventoDAO->listarTodos();
            $this->view('evento/index', $this->dados);
        }
        catch (Exception $exc)
        {
            $this->dados['mensagem'] = $exc->getMessage();
            $this->view('erro/in', $this->dados);
        }
    }

    public function novoAction() {
        try
        {
            $this->view('evento/novo', $this->dados);
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
            $eventos = (new EventoDAO())->findByNome(filter_input(INPUT_POST, 'nome'));
            if (count($eventos) > 0) {
                throw new \Exception("Já existe um evento com este nome.");
            }

            $evento = new Evento();
            $evento->setNome(filter_input(INPUT_POST, 'nome'))
                ->setData(filter_input(INPUT_POST, 'data'))
                ->setDescricao(filter_input(INPUT_POST, 'descricao'));

            $eventoDAO = new EventoDAO();
            $eventoDAO->salvar($evento);

            Method::registaLog("Adição", "Adicionou novo Evento: <b>".filter_input(INPUT_POST, 'nome')."</b>", $this->session->selectSession('userData')->getId());
            $redirector = new RedirectorHelper();
            $redirector->goToControllerAction('Evento', 'index');
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
            $eventoDAO = new EventoDAO();
            $retorno = $eventoDAO->buscarID($this->getParams('id'));
            $this->dados['entity'] = ($retorno != null ? $retorno : null);

            $this->view('evento/ver', $this->dados);
        }
        catch (Exception $exc)
        {
            $this->dados['mensagem'] = $exc->getMessage();
            $this->view('erro/in', $this->dados);
        }
    }

    public function editarAction() {
        try
        {
            $eventoDAO = new EventoDAO();
            $retorno = $eventoDAO->buscarID($this->getParams('id'));
            $this->dados['entity'] = ($retorno != null ? $retorno : null);

            $this->view('evento/editar', $this->dados);
        }
        catch (Exception $exc)
        {
            $this->dados['mensagem'] = $exc->getMessage();
            $this->view('erro/in', $this->dados);
        }
    }

    // Action Actualizar
    public function actualizarAction() {
        try
        {
            $eventoDAO = new EventoDAO();
            $retorno = $eventoDAO->buscarID(filter_input(INPUT_POST, 'id_evento'));

            $evento = $retorno;
            $evento->setNome(filter_input(INPUT_POST, 'nome'))
                    ->setData(filter_input(INPUT_POST, 'data'))
                    ->setDescricao(filter_input(INPUT_POST, 'descricao'));

            $eventoDAO->actualizar($evento);
            $redirector = new RedirectorHelper();
            $redirector->setUrlParameter('id', $evento->getId());
            $redirector->goToControllerAction('Evento', 'ver');

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
            /*if (!$this->auth->HasPermission("eliminarEvento")) {
                throw new \Exception("Não estás autorizado a efectuar esta operação.");
            }*/
            $eventoDAO = new EventoDAO();

            $retorno = $eventoDAO->buscarID($this->getParams('id'));
            if (!$retorno) {
                echo 'Permissão não encontrada.';
            }
            $eventoDAO->eliminar($retorno);
            $redirector = new RedirectorHelper();
            $redirector->goToControllerAction('Evento', 'index');
            unset($redirector);
        }
        catch (Exception $exc)
        {
            $this->dados['mensagem'] = $exc->getMessage();
            $this->view('erro/in', $this->dados);
        }
    }
}