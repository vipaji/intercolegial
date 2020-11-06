<?php

Class CategoriaController extends Controller {

    public function init() {
        $this->auth = new AuthHelper();
        $this->auth->setLoginControllerAction('Login', 'index')->checkLogin('redirect');

        $this->session = new SessionHelper();
        $this->dados['userInfo'] = $this->session->selectSession('userData');

        $this->dados['title_page'] = "Categoria &bull; Oliva de Angola &#8482;";
        $this->dados['page_context'] = "Categoria";
        $this->dados['page_icon'] = "fa fa-start";
        $this->dados['page_url'] = '/intercolegial/Categoria/';
    }

    public function indexAction() {
        try
        {
            $categoriaDAO = new CategoriaDAO();
            $this->dados['entities'] = $categoriaDAO->listarTodas();
            $this->view('categoria/index', $this->dados);
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
            $this->view('categoria/nova', $this->dados);
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
            $categoria = new Categoria();
            $categoria->setNome(filter_input(INPUT_POST, 'nome'))
                ->setDescricao(filter_input(INPUT_POST, 'descricao'));

            $categoriaDAO = new CategoriaDAO();
            $categoriaDAO->salvar($categoria);
            $redirector = new RedirectorHelper();
            $redirector->goToControllerAction('Categoria', 'index');
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
            $categoriaDAO = new CategoriaDAO();
            $retorno = $categoriaDAO->buscarID($this->getParams('id'));
            $this->dados['entity'] = ($retorno != null ? $retorno : null);

            $this->view('categoria/ver', $this->dados);
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
            $categoriaDAO = new CategoriaDAO();
            $retorno = $categoriaDAO->buscarID($this->getParams('id'));
            $this->dados['entity'] = ($retorno != null ? $retorno : null);

            $this->view('categoria/editar', $this->dados);
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
            $categoriaDAO = new CategoriaDAO();
            $retorno = $categoriaDAO->buscarID(filter_input(INPUT_POST, 'id_categoria'));

            $categoria = $retorno;
            $categoria->setNome(filter_input(INPUT_POST, 'nome'))
                    ->setDescricao(filter_input(INPUT_POST, 'descricao'));

            $categoriaDAO->actualizar($categoria);
            $redirector = new RedirectorHelper();
            $redirector->setUrlParameter('id', $categoria->getId());
            $redirector->goToControllerAction('Categoria', 'ver');

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
            if (!$this->auth->HasPermission("eliminarCategoria")) {
                throw new \Exception("Não estás autorizado a efectuar esta operação.");
            }
            $categoriaDAO = new CategoriaDAO();

            $retorno = $categoriaDAO->buscarID($this->getParams('id'));
            if (!$retorno) {
                echo 'Permissão não encontrada.';
            }
            $categoriaDAO->eliminar($retorno);
            $redirector = new RedirectorHelper();
            $redirector->goToControllerAction('Categoria', 'index');
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