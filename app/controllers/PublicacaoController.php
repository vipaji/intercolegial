<?php

Class PublicacaoController extends Controller {

    public function init() {
        $this->auth = new AuthHelper();
        $this->auth->setLoginControllerAction('Login', 'index')->checkLogin('redirect');

        $this->session = new SessionHelper();
        $this->dados['userInfo'] = $this->session->selectSession('userData');

        $this->dados['title_page'] = "Publicações | Câmara do Comércio e Indústria Angola - EAU";
        $this->dados['page_context'] = "Publicações";
        $this->dados['page_icon'] = "fa fa-list";
        $this->dados['page_url'] = '/autenticador/Publicacao/';
        $this->dados['page_home'] = '/autenticador/Inicial/';
    }

    /**
     * @Método: indexAction
     * @Descrição: Apresenta a lista de utilizadores  
     * 
     */
    public function indexAction() {
        try {
            $this->dados['entities'] = (new PublicacaoDAO())->listarTodas();

            $this->view('publicacao/index', $this->dados);
        } catch (Exception $exc) {
            $this->dados['mensagem'] = $exc->getMessage();
            $this->view('erro/erro', $this->dados);
        }
    }

    /**
     * @Método: novoAction
     * @Descrição: Apresenta o formulário para cadastro do utilizador 
     * 
     */
    public function novaAction() {
        try {
            if (!$this->auth->HasPermission("criarUtilizador")) {
                throw new \Exception("Utilizador não autorizado a criar outro utilizador.");
            }
            //Carrega as funções para a visão 
            $this->dados['funcoes'] = (new FuncaoDAO())->listarTodas();

            $this->view('publicacao/nova', $this->dados);
        } catch (Exception $exc) {
            $this->dados['mensagem'] = $exc->getMessage();
            $this->view('erro/index', $this->dados);
        }
    }
    

    public function pesquisarAction() {
        try {

            $this->dados['publicacoes'] = (new PublicacaoDAO())->findByPublicacao(filter_input(INPUT_POST, 'chave'));

            $this->view('publicacao/pesquisa', $this->dados);
        } catch (Exception $exc) {
            $this->dados['mensagem'] = $exc->getMessage();
            $this->view('erro/erro', $this->dados);
        }
    }

    /**
     * @Método: registarAction
     * @Descrição: Processa o registo do utilizador 
     * 
     */
    public function registarAction() {
        try {

            $publicacoes = (new PublicacaoDAO())->findByTitulo(filter_input(INPUT_POST, 'titulo'));

            if (count($publicacoes) > 0) {
                throw new \Exception("Já existe uma publicação com o título que está a tentar adicionar.");
            }

            $publicacaoDAO = new PublicacaoDAO();

            $publicacao = new Publicacao();

            if (isset($_FILES)) {
                $uploadImagem = new UploadImagem($_FILES['imagem'], '../autenticador/web-files/img/actividades/');

                $up = $uploadImagem->upload();
                if ($up == TRUE) {
                    $publicacao->setImagem($uploadImagem->getImagemNome());
                } else {

                    $publicacao->setImagem(null);
                    if (!empty($uploadImagem->getErrors())) {
                        $this->dados['mensagem'] = "Não escolheu uma imagem ou escolheu um arquivo em formato inválido. A imagem deve ser <b>jpg</b>, <b>jpeg</b>, <b>bmp</b>, <b>gif</b> ou <b>png</b>. Envie outro arquivo.";
                        $this->view('erro/index', $this->dados);
                    }
                }
            }

            $publicacao->setTitulo(filter_input(INPUT_POST, 'titulo'));
            $publicacao->setDestaque(filter_input(INPUT_POST, 'destaque'));
            $publicacao->setTexto(filter_input(INPUT_POST, 'texto'));
            $publicacao->setEstado(filter_input(INPUT_POST, 'estado'));
            $publicacao->setLocal(filter_input(INPUT_POST, 'local'));
            $publicacao->setData(date('Y-m-d'));
            $publicacao->setUtilizador($this->session->selectSession('userData')->getId());


            $publicacaoDAO->salvar($publicacao);

            $redirector = new RedirectorHelper();
            $redirector->goToControllerAction('Publicacao', 'index');

            unset($redirector);
            unset($publicacao);
            unset($publicacaoDAO);
        } catch (Exception $exc) {
            $this->dados['mensagem'] = $exc->getMessage();
            $this->view('erro/index', $this->dados);
        }
    }

    /**
     * @Método: registarAction
     * @Descrição: Processa o registo do utilizador 
     * 
     */
    public function novafotoAction() {
        try {
            if (!$this->auth->HasPermission("NovaImagemPublicacao")) {
                throw new \Exception("Utilizador não autorizado.");
            }

            $publicacaoDAO = new PublicacaoDAO();
            $publicacao = $publicacaoDAO->buscarID(filter_input(INPUT_POST, 'id_publicacao'));

            //$utilizador = new Utilizador();

            if (isset($_FILES)) {
                $uploadImagem = new UploadImagem($_FILES['imagem'], '../autenticador/web-files/img/actividades/');

                $up = $uploadImagem->upload();
                if ($up == TRUE) {
                    $publicacao->setImagem($uploadImagem->getImagemNome());
                    $publicacaoDAO->novafoto($publicacao);
                } else {
                    $publicacao->setFoto('indisponivel');
                    print_r($uploadImagem->getErrors());
                    die;
                    //Apresentar erros
                }
            }


            $redirector = new RedirectorHelper();
            $redirector->setUrlParameter('id', $publicacao->getId());
            $redirector->goToControllerAction('Publicacao', 'ver');
        } catch (Exception $exc) {
            $this->dados['mensagem'] = $exc->getMessage();
            $this->view('erro/erro', $this->dados);
        }
    }

    /**
     * @Método: verAction
     * 
     */
    public function verAction() {
        try {
            $publicacaoDAO = new PublicacaoDAO();
            $retorno = $publicacaoDAO->buscarID($this->getParams('id'));

            $this->dados['entity'] = ($retorno != null ? $retorno : null);

            $this->view('publicacao/ver', $this->dados);
        } catch (Exception $exc) {
            //$this->dados['mensagem'] = ($exc->getCode() == "23000" ? "Dado(s) duplicado(s)" : "");
            $this->dados['mensagem'] = $exc->getMessage();
            $this->view('erro/erro', $this->dados);
        }
    }

    /**
     * @Método: editarAction
     * @Descrição: Apresenta a tela de edição da informação dos utilizadores  
     * 
     */
    public function editarAction() {
        try {
            /*if (!$this->auth->HasPermission("editarPublicacao")) {
                throw new \Exception(Geral::CONS_MESSAGE_ERRO_PERFIL_SEM_PERMISSOES);
            }*/
            $publicacaoDAO = new PublicacaoDAO();
            $retorno = $publicacaoDAO->buscarID($this->getParams('id'));

            $this->dados['entity'] = ($retorno != null ? $retorno : null);

            $this->view('publicacao/editar', $this->dados);
        } catch (Exception $exc) {
            //$this->dados['mensagem'] = ($exc->getCode() == "23000" ? "Dado(s) duplicado(s)" : "");
            $this->dados['mensagem'] = $exc->getMessage();
            $this->view('erro/index', $this->dados);
        }
    }

    /**
     * @Método: actualizarAction
     * @Descrição: processa a actualização da informação dos utilizadores   
     * 
     */
    public function actualizarAction() {
        try {

            $publicacaoDAO = new PublicacaoDAO();
            $retorno = $publicacaoDAO->buscarID(filter_input(INPUT_POST, 'id_publicacao'));

            $publicacoes = (new PublicacaoDAO())->findByTitulo(filter_input(INPUT_POST, 'titulo'));


            if (count($publicacoes) > 1) {
                throw new \Exception("Já existe uma publicação com o mesmo título que está a tentar adicionar.");
            }

            /*if (isset($_FILES)) {
                $uploadImagem = new UploadImagem($_FILES['imagem'], '../autenticador/web-files/img/actividades/');

                $up = $uploadImagem->upload();
                if ($up == TRUE) {
                    $retorno->setImagem($uploadImagem->getImagemNome());
                } else {

                    $publicacao->setImagem(null);
                    if (!empty($uploadImagem->getErrors())) {
                        $this->dados['mensagem'] = "Não escolheu uma imagem ou escolheu um arquivo em formato inválido. A imagem deve ser <b>jpg</b>, <b>jpeg</b>, <b>bmp</b>, <b>gif</b> ou <b>png</b>. Envie outro arquivo.";
                        $this->view('erro/index', $this->dados);
                    }
                }
            }
            */

            $publicacao = $retorno;
            $publicacao->setTitulo(filter_input(INPUT_POST, 'titulo'));
            $publicacao->setDestaque(filter_input(INPUT_POST, 'destaque'));
            $publicacao->setTexto(filter_input(INPUT_POST, 'texto'));
            $publicacao->setEstado(filter_input(INPUT_POST, 'estado'));
            $publicacao->setLocal(filter_input(INPUT_POST, 'local'));

            $publicacaoDAO->actualizar($publicacao);
            $redirector = new RedirectorHelper();
            $redirector->setUrlParameter('id', $publicacao->getId());
            $redirector->goToControllerAction('Publicacao', 'ver');

            unset($redirector);
            unset($publicacao);
            unset($retorno);
            unset($publicacaoDAO);
        } catch (Exception $exc) {
            $this->dados['mensagem'] = $exc->getMessage();
            $this->view('erro/index', $this->dados);
        }
    }

    /**
     * @Método: passwordAction
     * @Descrição: processa a actualização da informação dos utilizadores   
     * 
     */
    public function passwordAction() {
        try {
            $utilizadorDAO = new UtilizadorDAO();
            $retorno = $utilizadorDAO->buscarID(filter_input(INPUT_POST, 'id_utilizador'));

            $utilizador = $retorno;
            if ($utilizador->getPassword() != md5(filter_input(INPUT_POST, 'password_actual'))) {
                throw new \Exception("Palavra-passe actual que inseriu está incorrecta.");
                //$utilizador->setPassword(md5(filter_input(INPUT_POST, 'password_utilizador')));
            } else {
                $utilizador->setPassword(md5(filter_input(INPUT_POST, 'password_utilizador')));
            }

            $utilizadorDAO->password($utilizador);
            $redirector = new RedirectorHelper();
            $redirector->setUrlParameter('id', $utilizador->getId());
            $redirector->goToControllerAction('Publicacao', 'perfil');

            unset($redirector);
            unset($utilizador);
            unset($utilizadorDAO);
        } catch (Exception $exc) {
            //$this->dados['mensagem'] = ($exc->getCode() == "23000" ? "Dado(s) duplicado(s)" : "");
            $this->dados['mensagem'] = $exc->getMessage();
            $this->view('erro/index', $this->dados);
        }
    }

    /**
     * @Método: redifinirAction
     * @Descrição: Repor a palavra-passe (padrão) do utilizador
     * 
     */
    public function redifinirAction() {
        try {
            //$utilizadorDAO = new UtilizadorDAO();
            //$retorno = $utilizadorDAO->buscarID(filter_input(INPUT_POST, 'id_utilizador'));

            $utilizadorDAO = new UtilizadorDAO();
            $retorno = $utilizadorDAO->buscarID($this->getParams('id'));

            $utilizador = $retorno;
            
            /*
            if ($utilizador->getPassword() != md5(filter_input(INPUT_POST, 'password_actual')))
            {
                throw new \Exception("Palavra-passe actual que inseriu está incorrecta.");
                //$utilizador->setPassword(md5(filter_input(INPUT_POST, 'password_utilizador')));
            } else {
                $utilizador->setPassword(md5(filter_input(INPUT_POST, 'password_utilizador')));
            }
            */
            $utilizador->setPassword(md5("123"));

            $utilizadorDAO->password($utilizador);
            $redirector = new RedirectorHelper();
            $redirector->setUrlParameter('id', $utilizador->getId());
            $redirector->goToControllerAction('Publicacao', 'ver');

            unset($redirector);
            unset($utilizador);
            unset($utilizadorDAO);
        } catch (Exception $exc) {
            //$this->dados['mensagem'] = ($exc->getCode() == "23000" ? "Dado(s) duplicado(s)" : "");
            $this->dados['mensagem'] = $exc->getMessage();
            $this->view('erro/index', $this->dados);
        }
    }

    /**
     * @Método: eliminarAction
     * @Descrição: Processa a eliminação da informação do utilizador 
     * 
     */
    public function eliminarAction() {
        try {
            $utilizadorDAO = new UtilizadorDAO();
            $retorno = $utilizadorDAO->buscarID(filter_input(INPUT_POST, 'cod_utilizador'));
            if (!$retorno) {
                echo 'Não encontrou';
                die;
            }
            UploadImagem::eliminaImagem(Geral::DIR_IMG_UTIZADORES . $retorno->getFoto());
            $utilizadorDAO->eliminar($retorno);
            $redirector = new RedirectorHelper();
            $redirector->goToControllerAction('utilizador', 'index');
            unset($redirector);
            unset($utilizadorDAO);
        } catch (Exception $exc) {
            $this->dados['mensagem'] = $exc->getMessage();
            $this->view('erro/index', $this->dados);
        }
    }

    /**
     * @Método: imprimirAction
     * @Descrição: Processa a impressão (pdf) da informação do utilizador 
     * 
     */
    public function imprimirAction() {
        try {
            //Carrega as funções para a visão 
            $this->dados['funcoes'] = (new FuncaoDAO())->listarTodas();
            $this->view('publicacao/imprimirPDF', $this->dados, '.php');
        } catch (Exception $exc) {
            //$this->dados['mensagem'] = ($exc->getCode() == "23000" ? "Dado(s) duplicado(s)" : "");
            $this->dados['mensagem'] = $exc->getMessage();
            $this->view('erro/index', $this->dados);
        }
    }

    public function perfilAction() {
        try {
            $utilizadorDAO = new UtilizadorDAO();
            $retorno = $utilizadorDAO->buscarID($this->getParams('id'));

            $this->dados['entity'] = ($retorno != null ? $retorno : null);

            //Carrega as funções para a visão 
            $this->dados['funcoes'] = (new FuncaoDAO())->listarTodas();

            $this->view('publicacao/perfil', $this->dados);
        } catch (Exception $exc) {
            //$this->dados['mensagem'] = ($exc->getCode() == "23000" ? "Dado(s) duplicado(s)" : "");
            $this->dados['mensagem'] = $exc->getMessage();
            $this->view('erro/index', $this->dados);
        }
    }

    /**
     * @Método: imprimirPdfAction
     * @Descrição: Processa a impressão (pdf) da informação do utilizador 
     * 
     */
    public function imprimirPdfAction() {
        try {
            $this->dados['entities'] = (new UtilizadorDAO())->listarTodos();
            $this->view('publicacao/RelatorioGeralPDF', $this->dados, ".php");
        } catch (Exception $exc) {
            //$this->dados['mensagem'] = ($exc->getCode() == "23000" ? "Dado(s) duplicado(s)" : "");
            $this->dados['mensagem'] = $exc->getMessage();
            $this->view('erro/index', $this->dados);
        }
    }

}
