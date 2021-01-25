<?php

Class EstudanteController extends Controller {

    public function init() {
        $this->auth = new AuthHelper();
        $this->auth->setLoginControllerAction('Login', 'index')->checkLogin('redirect');

        $this->session = new SessionHelper();
        $this->dados['userInfo'] = $this->session->selectSession('userData');

        $this->dados['title_page'] = "Estudantes &bull; Intercolegial Tina Tune &#8482;";
        $this->dados['page_context'] = "Estudante";
        $this->dados['page_icon'] = "fa fa-start";
        $this->dados['page_url'] = '/Estudante/';
        $this->dados['home_url'] = '/Dashboard/';
        $this->dados['id'] = 'escola';
    }

    public function indexAction() {
        try
        {
            $estudanteDAO = new UtilizadorDAO();
            $this->dados['entities'] = $estudanteDAO->listarEstudante();
            $this->view('estudante/index', $this->dados);
        }
        catch (Exception $exc)
        {
            $this->dados['mensagem'] = $exc->getMessage();
            $this->view('erro/in', $this->dados);
        }
    }

    public function novaAction() {
        try
        {
            $this->dados['perfis'] = (new PerfilDAO())->listarTodos();
            $this->dados['escolas'] = (new EscolaDAO())->listarTodas();
            $this->view('estudante/nova', $this->dados);
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
            $estudantes = (new UtilizadorDAO())->findByEmail(filter_input(INPUT_POST, 'email'));
            if (count($estudantes) > 0) {
                throw new \Exception("Já existe uma inscrição com este email.");
            }

            $estudante = new Utilizador();
            $estudante->setNome(filter_input(INPUT_POST, 'nome'))
                ->setEmail(filter_input(INPUT_POST, 'email'))
                ->setPassword(md5(filter_input(INPUT_POST, 'passe')))
                ->setPerfil((new PerfilDAO())->buscarID(filter_input(INPUT_POST, 'perfil')))
                ->setEstado(Geral::CONS_UTILIZADOR_DESACTIVADO)
                ->setTelefone(filter_input(INPUT_POST, 'telefone'))
                ->setEscola((new EscolaDAO())->buscarID(filter_input(INPUT_POST, 'escola')))
                ->setDataInscricao(date('Y-m-d'));

            $estudanteDAO = new UtilizadorDAO();
            $estudanteDAO->salvar($estudante);

            Method::registaLog("Adição", "Adicionou novo Estudante: <b>".filter_input(INPUT_POST, 'nome')."</b>", $this->session->selectSession('userData')->getId());
            $redirector = new RedirectorHelper();
            $redirector->goToControllerAction('Estudante', 'index');
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
            $estudanteDAO = new UtilizadorDAO();
            $retorno = $estudanteDAO->buscarID($this->getParams('id'));
            $this->dados['entity'] = ($retorno != null ? $retorno : null);
            $this->dados['perfis'] = (new PerfilDAO())->listarTodos();
            $this->dados['escolas'] = (new EscolaDAO())->listarTodas();
            $this->dados['documentos'] = (new DocumentoDAO())->mostrarDocs($this->getParams('id'));

            $this->view('estudante/ver', $this->dados);
        }
        catch (Exception $exc)
        {
            $this->dados['mensagem'] = $exc->getMessage();
            $this->view('erro/in', $this->dados);
        }
    }

    /**
     * @Método: eliminarMultimediaAction
     * @Descrição:  
     * 
     */
    public function eliminarMultimediaAction() {
        try {
            /*if (!$this->auth->HasPermission("eliminarMultimedia")) {
                throw new \Exception(Geral::CONS_MESSAGE_ERRO_PERFIL_SEM_PERMISSOES);
            }*/
            $documentoDAO = new DocumentoDAO();
            $retorno = $documentoDAO->buscarID($this->getParams('id'));
            if ($retorno == null) {
                throw new Exception("Geral");
            }
            $documentoDAO->eliminar($retorno);

            $redirector = new RedirectorHelper();

            $redirector->setUrlParameter('id', $this->getParams('id_utilizador'));
            $redirector->goToControllerAction('Estudante', 'ver');

            unset($redirector);
            unset($documentoDAO);
        } catch (Exception $exc) {
            $this->dados['mensagem'] = $exc->getMessage();
            $this->view('erro/in', $this->dados);
        }
    }

    public function editarAction() {
        try
        {
            $estudanteDAO = new UtilizadorDAO();
            $retorno = $estudanteDAO->buscarID($this->getParams('id'));
            $this->dados['entity'] = ($retorno != null ? $retorno : null);
            $this->dados['perfis'] = (new PerfilDAO())->listarTodos();
            $this->dados['escolas'] = (new EscolaDAO())->listarTodas();
            $this->dados['documentos'] = (new DocumentoDAO())->mostrarDocs($this->getParams('id'));

            $this->view('estudante/editar', $this->dados);
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
            /*$estudantes = (new UtilizadorDAO())->findByEmail(filter_input(INPUT_POST, 'email'));
            if (count($estudantes) > 0) {
                throw new \Exception("Já existe uma inscrição com este email.");
            }*/

            $estudanteDAO = new UtilizadorDAO();
            $retorno = $estudanteDAO->buscarID(filter_input(INPUT_POST, 'id_estudante'));

            $estudante = $retorno;
            $estudante->setNome(filter_input(INPUT_POST, 'nome'))
                    ->setEmail(filter_input(INPUT_POST, 'email'))
                    ->setPassword(md5(filter_input(INPUT_POST, 'passe')))
                    ->setPerfil((new PerfilDAO())->buscarID(filter_input(INPUT_POST, 'perfil')))
                    ->setEstado(filter_input(INPUT_POST, 'estado'))
                    ->setTelefone(filter_input(INPUT_POST, 'telefone'))
                    ->setEscola((new EscolaDAO())->buscarID(filter_input(INPUT_POST, 'escola')));

            $estudanteDAO->actualizar($estudante);
            $redirector = new RedirectorHelper();
            $redirector->setUrlParameter('id', $estudante->getId());
            $redirector->goToControllerAction('Estudante', 'ver');

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
            if (!$this->auth->HasPermission("eliminarTipoEstudante")) {
                throw new \Exception("Não estás autorizado a efectuar esta operação.");
            }
            $estudanteDAO = new UtilizadorDAO();

            $retorno = $estudanteDAO->buscarID($this->getParams('id'));
            if (!$retorno) {
                echo 'Permissão não encontrada.';
            }
            $estudanteDAO->eliminar($retorno);
            $redirector = new RedirectorHelper();
            $redirector->goToControllerAction('Estudante', 'index');
            unset($redirector);
        }
        catch (Exception $exc)
        {
            $this->dados['mensagem'] = $exc->getMessage();
            $this->view('erro/in', $this->dados);
        }
    }
}