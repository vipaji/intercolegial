<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of DashboardController
 *
 * @author mrvipaji
 */
class DashboardController extends Controller
{

    public function init()
    {
        $this->auth = new AuthHelper();
        $this->auth->setLoginControllerAction('Login', 'index')->checkLogin('redirect');

        $this->session = new SessionHelper();
        $this->dados['userInfo'] = $this->session->selectSession('userData');

        $this->dados['title_page'] = "Dashboard &bull; Intercolegial Tina Tune &#8482;";
        $this->dados['page_context'] = "Dashboard";
        $this->dados['page_icon'] = "fa fa-dashboard";
        $this->dados['page_url'] = 'https://www.intercolegialtinatune.co.ao/Dashboard/';
        $this->dados['home_url'] = 'https://www.intercolegialtinatune.co.ao/Dashboard/';
    }

    public function indexAction()
    {
        try {
            if ((Method::lowerGeneral($this->session->selectSession('userData')->getPerfil()->getNome()) == Geral::CONS_PERFIL_ALUNO) OR (Method::lowerGeneral($this->session->selectSession('userData')->getPerfil()->getNome()) == Geral::CONS_PERFIL_TINA_TUNE)) {
                $utilizadorDAO = new UtilizadorDAO();
                $retorno = $utilizadorDAO->buscarID($this->session->selectSession('userData')->getId());

                $this->dados['entity'] = ($retorno != null ? $retorno : null);
                $this->dados['logs'] = (new LogDAO())->logUtilizador($this->session->selectSession('userData')->getId());
                $this->dados['documentos'] = (new DocumentoDAO())->mostrarDocs($this->session->selectSession('userData')->getId());
                $this->dados['perfis'] = (new PerfilDAO())->listarTodos();

                $this->view('utilizador/perfil', $this->dados);
            } else
            {
                $this->dados['escolas'] = (new EscolaDAO())->listarTodas();
                $this->dados['estudantes'] = (new UtilizadorDAO())->listarEstudantes();
                $this->dados['total_estudante'] = count((new UtilizadorDAO())->listarEstudante());
                $this->dados['total_escola'] = count((new EscolaDAO())->listarTodas());
                $this->dados['total_evento'] = count((new EventoDAO())->listarTodos());
                $this->view('dashboard/index', $this->dados);
            }
        } catch (Exception $exc) {
            $this->dados['mensagem'] = $exc->getMessage();
            $this->view('erro/in', $this->dados);
        }
    }

    /**
     * @Método: uploadMultimediaAction
     * @Descrição: faz upload de imagem para o utilizador
     * 
     */
    public function uploadMultimediaAction() {

        try {
            /*if (!$this->auth->HasPermission("uploadMultimediaDoocumento")) {
                throw new \Exception(Geral::CONS_MESSAGE_ERRO_PERFIL_SEM_PERMISSOES);
            }*/


            $utilizadorDAO = new UtilizadorDAO();
            $utilizador = $utilizadorDAO->buscarID(base64_decode(filter_input(INPUT_POST, 'id_utilizador')));

            if ($utilizador == null) {
                throw new \Exception(sprintf(Geral::CONS_MESSAGE_ERRO_ENTIDADE_NAO_ENCONTRADO, "Utilizador"));
            }

            $erro = null;

            if (!empty($_FILES['file'])) {
                $files = Upload::reArrayFiles($_FILES['file']);

                foreach ($files as $file) {
                    try {
                        $upload = new Upload($file, '..https://www.intercolegialtinatune.co.ao/web-files/uploads/documentos/');
                        if ($upload->upload() == TRUE) {

                            $documento = new Documento();
                            $documento->setDescricao($upload->getFicheiroDescricao())
                                    ->setFicheiro($upload->getFicheiroNome())
                                    ->setData((new Data())->getDataMySQL())
                                    ->setTipo(Method::devolveConstanteTipoMultimediaByTipo($upload->getFicheiroType()))
                                    ->setUtilizador((new UtilizadorDAO())->buscarID($this->session->selectSession('userData')->getId()));

                            $documentoDAO = new DocumentoDAO();
                            $documentoDAO->salvar($documento);
                        } else {
                            /* echo "<pre>";
                              print_r($upload); die; */
                            for ($i = 0; $i < count($upload->getErrors()); $i++) {
                                $erro .= $upload->getErrors()[$i] . "<br/>";
                            }
                        }
                    } catch (Exception $e) {
                        $erro .= $e->getMessage()[0] . "<br/>";
                    }
                }
            }

            if (strlen($erro) > 0) {
                throw new \Exception($erro);
            }
            $redirector = new RedirectorHelper();
            $redirector->setUrlParameter('id', $utilizador->getId());
            $redirector->goToControllerAction('Dashboard', 'index');
        } catch (Exception $exc) {
            $this->dados['mensagem'] = $exc->getMessage();
            $this->view('erro/in', $this->dados);
        }
    }

    /**
     * @Método: imprimirPdfAction
     * @Descrição: Processa a impressão (pdf) da informação da área 
     * 
     */
    public function imprimirPdfAction()
    {
        try {
            $this->dados['entities'] = (new ServicoDAO())->listarTodos();
            $this->view('servico/RelatorioGeralPDF', $this->dados, ".php");
        } catch (Exception $exc) {
            $this->dados['mensagem'] = $exc->getMessage();
            $this->view('erro/erro', $this->dados);
        }
    }
}
