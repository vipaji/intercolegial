<?php

Class InicialController extends Controller {

    public function init() {
        $this->auth = new AuthHelper();
        $this->auth->setLoginControllerAction('Login', 'index')->checkLogin('redirect');

        $this->session = new SessionHelper();
        $this->dados['userInfo'] = $this->session->selectSession('userData');

        $this->dados['title_page'] = "Página Inicial do Editor | Câmara do Comércio e Indústria Angola - EAU";
        $this->dados['page_context'] = "Página Inicial";
        $this->dados['page_icon'] = "fa fa-dashboard";
        $this->dados['page_url'] = '/autenticador/Inicial/';
    }

    /**
     * @Método: indexAction
     * @Descrição:
     * 
     */
    public function indexAction() {
        try {
            $this->dados['publicacoes'] = count((new PublicacaoDAO())->listarTodas());
            $this->dados['utilizadores'] = count((new UtilizadorDAO())->listarTodos());
            //Carrega as funções para a visão 
            $this->dados['funcoes'] = (new FuncaoDAO())->listarTodas();
           
            $this->view('inicial/index', $this->dados);
        } catch (Exception $exc) {
            $this->dados['mensagem'] = $exc->getMessage();
            $this->view('erro/erro', $this->dados);
        }
    }
}
