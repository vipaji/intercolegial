<?php

Class PerfilController extends Controller {

    public function init() {
        
        $this->auth = new AuthHelper();
        $this->auth->setLoginControllerAction('Login', 'index')->checkLogin('redirect');

        $this->session = new SessionHelper();
        $this->dados['userInfo'] = $this->session->selectSession('userData');
        
        $this->dados['title_page'] = 'Perfil &bull; Oliva de Angola &#8482;';
        $this->dados['page_context'] = "Perfil";
        $this->dados['page_icon'] = "fa fa-dashboard";
        $this->dados['page_url'] = '/intercolegial/Perfil/';
        $this->dados['home_url'] = '/intercolegial/Dashboard/';
    }

    public function indexAction() {
        try {
            $this->dados['entities'] = (new PerfilDAO())->listarTodos();
            $this->view('perfil/index', $this->dados);
        } catch (Exception $exc) {
            $this->dados['mensagem'] = $exc->getMessage();
            $this->view('erro/erro', $this->dados);
        }
    }

    public function novoAction() {
        try
        {
            $this->view('perfil/novo', $this->dados);
        } 
        catch (Exception $exc)
        {
            $this->dados['mensagem'] = $exc->getMessage();
            $this->view('erro/in', $this->dados);
        }
    }

    public function registarAction() {
        try {
            $perfil = new Perfil();

            $perfil->setNome(filter_input(INPUT_POST, 'nome'));
            $perfil->setDescricao(filter_input(INPUT_POST, 'descricao'));

            $perfilDAO = new PerfilDAO();
            $perfilDAO->salvar($perfil);
            $redirector = new RedirectorHelper();
            $redirector->goToControllerAction('Perfil', 'index');
            unset($redirector);
        } catch (Exception $exc) {
            $this->dados['mensagem'] = $exc->getMessage();
            $this->view('erro/in', $this->dados);
        }
    }

    public function verAction() {
        try {
            if (!$this->auth->HasPermission("verPerfil")) {
                throw new \Exception("Não tem permissão para ver Perfil.");
            }

            //Tem Permissão
            $perfilDAO = new PerfilDAO();
            $this->dados['entity'] = $perfilDAO->buscarID($this->getParams('id'));
            if ($this->getParams('id') == null ||  $this->dados['entity'] == null ) {
                throw new \Exception("Recurso não encontrado.");
            }
            //Permissoes
            $this->dados['permissoes'] = (new PermissaoDAO())->listarTodas();


            $this->view('perfil/ver', $this->dados);
        } catch (Exception $exc) {
            $this->dados['mensagem'] = $exc->getMessage();
            $this->view('erro/in', $this->dados);
        }
    }

    public function editarAction() {
        try {
            if (!$this->auth->HasPermission("verPerfil")) {
                throw new \Exception("Não tem permissão para ver Perfil.");
            }

            //Tem Permissão
            $perfilDAO = new PerfilDAO();
            $this->dados['entity'] = $perfilDAO->buscarID($this->getParams('id'));
            if ($this->getParams('id') == null ||  $this->dados['entity'] == null ) {
                throw new \Exception("Recurso não encontrado.");
            }
            //Permissoes
            $this->dados['permissoes'] = (new PermissaoDAO())->listarTodas();


            $this->view('perfil/editar', $this->dados);
        } catch (Exception $exc) {
            $this->dados['mensagem'] = $exc->getMessage();
            $this->view('erro/in', $this->dados);
        }
    }

    public function actualizarAction() {

        try {
            if (!$this->auth->HasPermission("editarPerfil")) {
                throw new \Exception("Não autorizado a editar perfil.");
            }

            $perfilDAO = new PerfilDAO();
            $perfil = $perfilDAO->buscarID(filter_input(INPUT_POST, 'id_perfil'));

            $perfil->setNome(filter_input(INPUT_POST, 'nome'))
                    ->setDescricao(filter_input(INPUT_POST, 'descricao'));
            if (is_array(filter_input(INPUT_POST, 'permissoes', FILTER_DEFAULT, FILTER_FORCE_ARRAY))) {
                $perfil->setPermissoes((new PermissaoDAO())->listarTodasIn(filter_input(INPUT_POST, 'permissoes', FILTER_DEFAULT, FILTER_FORCE_ARRAY)));
            }
            $perfilDAO->actualizar($perfil);
            $redirector = new RedirectorHelper();
            $redirector->setUrlParameter('id', $perfil->getId());
            $redirector->goToControllerAction('Perfil', 'ver');

            unset($redirector);
        } catch (Exception $exc) {
            $this->dados['mensagem'] = $exc->getMessage();
            $this->view('erro/in', $this->dados);
        }
    }

    public function eliminarAction() {
        try {

            if (!$this->auth->HasPermission("eliminarPerfil")) {
                throw new \Exception("Não estás autorizado a efectuar esta operação.");
            }
            $perfilDAO = new PerfilDAO();

            $retorno = $perfilDAO->buscarID($this->getParams('id'));
            if (!$retorno) {
                throw new \Exception("Perfil não encontrado.");
            }
            $perfilDAO->eliminar($retorno);
            $redirector = new RedirectorHelper();
            $redirector->goToControllerAction('Perfil', 'index');
            unset($redirector);
        } catch (Exception $exc) {
            $this->dados['mensagem'] = $exc->getMessage();
            $this->view('erro/in', $this->dados);
        }
    }

     /**
     * @Método: imprimirPdfAction
     * @Descrição: Processa a impressão (pdf) da informação das funcoes 
     * 
     */
    public function imprimirPdfAction() {
        try {
            if (!$this->auth->HasPermission("imprimirPDFPerfil")) {
                throw new \Exception("Não estás autorizado a efectuar esta operação.");
            }
            $this->dados['entities'] = (new PerfilDAO())->listarTodos();
            $this->view('perfil/RelatorioGeralPDF', $this->dados, ".php");
        } catch (Exception $exc) {
            $this->dados['mensagem'] = $exc->getMessage();
            $this->view('erro/in', $this->dados);
        }
    }
}

