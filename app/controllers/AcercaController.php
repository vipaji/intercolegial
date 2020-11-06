<?php

Class AcercaController extends Controller {

    public function init() {
        $this->dados['title_page'] = 'Sobre o Autenticador Online &#153; - Sistema de Autenticidade de Documentos Legais';
        $this->dados['page_context'] = "Sobre o Autenticador Online &#153; - Sistema de Autenticidade de Documentos Legais";
        $this->dados['page_url'] = '/autenticador/Login/';
    }

    public function indexAction() {
        try {
            $this->view('acerca/index', $this->dados);
        } catch (Exception $exc) {
            $this->dados['mensagem'] = $exc->getMessage();
            $this->view('erro/erro', $this->dados);
        }
    }

}