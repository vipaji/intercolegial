<?php

Class UtilizadorController extends Controller {

    public function init() {
        $this->auth = new AuthHelper();
        $this->auth->setLoginControllerAction('Login', 'index')->checkLogin('redirect');

        $this->session = new SessionHelper();
        $this->dados['userInfo'] = $this->session->selectSession('userData');

        $this->dados['title_page'] = "Utilizadores &bull; Oliva de Angola &#8482;";
        $this->dados['page_context'] = "Utilizadores";
        $this->dados['page_icon'] = "fa fa-users";
        $this->dados['page_url'] = 'https://www.intercolegialtinatune.co.ao/Utilizador/';
        $this->dados['page_home'] = 'https://www.intercolegialtinatune.co.ao/Dashboard/';
        $this->dados['home_url'] = 'https://www.intercolegialtinatune.co.ao/Dashboard/';
    }

    /**
     * @Método: indexAction
     * @Descrição: Apresenta a lista de utilizadores  
     * 
     */
    public function indexAction() {
        try {
            if (!$this->auth->HasPermission("verUtilizador")) {
                throw new \Exception("Utilizador não autorizado a visualizar lista de utilizadores.");
            }
            $this->dados['entities'] = (new UtilizadorDAO())->listarTodos();
            $this->dados['perfil'] = (new PerfilDAO())->listarTodos();

            $this->view('utilizador/index', $this->dados);
        } catch (Exception $exc) {
            $this->dados['mensagem'] = $exc->getMessage();
            $this->view('erro/in', $this->dados);
        }
    }

    /**
     * @Método: novoAction
     * @Descrição: Apresenta o formulário para cadastro do utilizador 
     * 
     */
    public function novoAction() {
        try {
            if (!$this->auth->HasPermission("criarUtilizador")) {
                throw new \Exception("Utilizador não autorizado a criar outro utilizador.");
            }
            
            //Carrega as perfis para a visão 
            $this->dados['perfis'] = (new PerfilDAO())->listarTodos();

            $this->view('utilizador/novo', $this->dados);
        } catch (Exception $exc) {
            $this->dados['mensagem'] = $exc->getMessage();
            $this->view('erro/in', $this->dados);
        }
    }

    /**
     * @Método: registarAction
     * @Descrição: Processa o registo do utilizador 
     * 
     */
    public function registarAction() {
        try {
            if (!$this->auth->HasPermission("criarUtilizador")) {
                throw new \Exception("Sem autorização para esta operação.");
            }

            $utilizadores = (new UtilizadorDAO())->findByEmail(filter_input(INPUT_POST, 'email'));

            if (count($utilizadores) > 0) {
                throw new \Exception("Já existe um utilizador com este e-mail.");
            }

            $utilizadorDAO = new UtilizadorDAO();

            $utilizador = new Utilizador();

            $utilizador->setNome(filter_input(INPUT_POST, 'nome'));
            $utilizador->setEmail(filter_input(INPUT_POST, 'email'));
            $utilizador->setPassword(md5(filter_input(INPUT_POST, 'passe')));

            $utilizador->setEstado(Geral::CONS_UTILIZADOR_DESACTIVADO);
            $utilizador->setPerfil((new PerfilDAO())->buscarID(filter_input(INPUT_POST, 'perfil')));

            $utilizadorDAO->salvar($utilizador);
            Method::registaLog("Adição", "Adicionou novo utilizador: <b>" . filter_input(INPUT_POST, 'nome') ."</b>", $this->session->selectSession('userData')->getId());

            $redirector = new RedirectorHelper();
            $redirector->goToControllerAction('Utilizador', 'index');

            unset($redirector);
            unset($utilizador);
            unset($utilizadorDAO);
        } catch (Exception $exc) {
            $this->dados['mensagem'] = $exc->getMessage();
            $this->view('erro/in', $this->dados);
        }
    }

    /**
     * @Método: registarAction
     * @Descrição: Processa o registo do utilizador 
     * 
     */
    public function novafotoAction() {
        try {
            if (!$this->auth->HasPermission("NovaFotoutilizador")) {
                throw new \Exception("Utilizador não autorizado.");
            }

            $utilizadorDAO = new UtilizadorDAO();
            $utilizador = $utilizadorDAO->buscarID(filter_input(INPUT_POST, 'id_utilizador'));

            //$utilizador = new Utilizador();

            if (isset($_FILES)) {
                $uploadImagem = new UploadImagem($_FILES['foto_utilizador'], '..https://www.intercolegialtinatune.co.ao/web-files/uploads/utilizadores/');

                $up = $uploadImagem->upload();
                if ($up == TRUE) {
                    $utilizador->setFoto($uploadImagem->getImagemNome());
                    $utilizadorDAO->novafoto($utilizador);
                    Method::registaLog("Actualização", "Actualizou a sua foto de perfil", $this->session->selectSession('userData')->getId());
                } else {
                    $utilizador->setFoto('indisponivel');
                    print_r($uploadImagem->getErrors());
                    die;
                    //Apresentar erros
                }
            }

            $redirector = new RedirectorHelper();
            $redirector->setUrlParameter('id', $utilizador->getId());
            $redirector->goToControllerAction('Utilizador', 'perfil');
        } catch (Exception $exc) {
            $this->dados['mensagem'] = $exc->getMessage();
            $this->view('erro/in', $this->dados);
        }
    }

    /**
     * @Método: verAction
     * @Descrição: Apresenta a tela de visualização da informação dos utilizadores  
     * 
     */
    public function verAction() {
        try {
            if(!$this->auth->HasPermission("verDetalhesUtilizador")) {
                throw new \Exception("Utilizador não autorizado a visualizar detalhes de utilizadores.");
            }
            $utilizadorDAO = new UtilizadorDAO();
            $retorno = $utilizadorDAO->buscarID($this->getParams('id'));

            $this->dados['entity'] = ($retorno != null ? $retorno : null);

            //Carrega as Perfis para a visão 
            $this->dados['perfis'] = (new PerfilDAO())->listarTodos();

            Method::registaLog("Visualizar", "Visualizou informações do utilizador: <b>" . $retorno->getNome() ."</b>", $this->session->selectSession('userData')->getId());

            $this->view('utilizador/ver', $this->dados);
        } catch (Exception $exc) {
            
            $this->dados['mensagem'] = $exc->getMessage();
            $this->view('erro/in', $this->dados);
        }
    }

    /**
     * @Método: editarAction
     * @Descrição: Apresenta a tela de edição da informação dos utilizadores  
     * 
     */
    public function editarAction() {
        try {
            if (!$this->auth->HasPermission("editarUtilizador")) {
                throw new \Exception("Utilizador não autorizado a efectuar esta operação.");
            }
            $utilizadorDAO = new UtilizadorDAO();
            $retorno = $utilizadorDAO->buscarID($this->getParams('id'));

            $this->dados['entity'] = ($retorno != null ? $retorno : null);

            //Carrega as perfis para a visão 
            $this->dados['perfis'] = (new PerfilDAO())->listarTodos();

            $this->view('utilizador/editar', $this->dados);
        } catch (Exception $exc) {
            
            $this->dados['mensagem'] = $exc->getMessage();
            $this->view('erro/in', $this->dados);
        }
    }

    /**
     * @Método: actualizarAction
     * @Descrição: processa a actualização da informação dos utilizadores   
     * 
     */
    public function actualizarAction() {
        try {

            $utilizadorDAO = new UtilizadorDAO();
            $retorno = $utilizadorDAO->buscarID(filter_input(INPUT_POST, 'id_utilizador'));

            $utilizadores = (new UtilizadorDAO())->findByEmail(filter_input(INPUT_POST, 'email'));


            if (count($utilizadores) > 1) {
                throw new \Exception("Já existe um utilizador com este e-mail.");
            }

            $utilizador = $retorno;
            $utilizador->setNome(filter_input(INPUT_POST, 'nome'));
            $utilizador->setEmail(filter_input(INPUT_POST, 'email'));
            $utilizador->setEstado(filter_input(INPUT_POST, 'estado'));
            $utilizador->setPerfil((new PerfilDAO())->buscarID(filter_input(INPUT_POST, 'perfil')));

            Method::registaLog("Actualizar", "Actualizou                                                                                                                                                                                                                                                                                                                                                                                         informações do utilizador: <b>" . $retorno->getNome() ."</b>", $this->session->selectSession('userData')->getId());

            $utilizadorDAO->actualizar($utilizador);
            $redirector = new RedirectorHelper();
            $redirector->setUrlParameter('id', $utilizador->getId());
            $redirector->goToControllerAction('Utilizador', 'ver');

            unset($redirector);
            unset($utilizador);
            unset($retorno);
            unset($utilizadorDAO);
        } catch (Exception $exc) {
            $this->dados['mensagem'] = $exc->getMessage();
            $this->view('erro/in', $this->dados);
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
                throw new \Exception("<b>Palavra-passe actual</b> que inseriu está incorrecta.");
                //$utilizador->setPassword(md5(filter_input(INPUT_POST, 'password_utilizador')));
            } else {
                $utilizador->setPassword(md5(filter_input(INPUT_POST, 'password_utilizador')));
            }

            $utilizadorDAO->password($utilizador);
            $redirector = new RedirectorHelper();
            $redirector->setUrlParameter('id', $utilizador->getId());
            $redirector->goToControllerAction('Utilizador', 'perfil');

            unset($redirector);
            unset($utilizador);
            unset($utilizadorDAO);
        } catch (Exception $exc) {
            
            $this->dados['mensagem'] = $exc->getMessage();
            $this->view('erro/in', $this->dados);
        }
    }

    /**
     * @Método: redifinirAction
     * @Descrição: Repor a palavra-passe (padrão) do utilizador
     * 
     */
    public function redifinirAction() {
        try {
            $utilizadorDAO = new UtilizadorDAO();
            $retorno = $utilizadorDAO->buscarID($this->getParams('id'));

            $utilizador = $retorno;
            
           
            $utilizador->setPassword(md5("123"));

            $utilizadorDAO->password($utilizador);
            $redirector = new RedirectorHelper();
            $redirector->setUrlParameter('id', $utilizador->getId());
            $redirector->goToControllerAction('Utilizador', 'ver');

            unset($redirector);
            unset($utilizador);
            unset($utilizadorDAO);
        } catch (Exception $exc) {
            $this->dados['mensagem'] = $exc->getMessage();
            $this->view('erro/in', $this->dados);
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
            
            $retorno = $utilizadorDAO->buscarID($this->getParams('id_utilizador'));
            if (!$retorno) {
                echo 'Permissão não encontrada.';
            }
            UploadImagem::eliminaImagem(Geral::DIR_IMG_UTILIZADORES . $retorno->getFoto());
            $utilizadorDAO->eliminar($retorno);
            $redirector = new RedirectorHelper();
            $redirector->goToControllerAction('Utilizador', 'index');
            unset($redirector);
            unset($utilizadorDAO);
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
            if (!$this->auth->HasPermission("uploadMultimediaDocumento")) {
                throw new \Exception(Geral::CONS_MESSAGE_ERRO_PERFIL_SEM_PERMISSOES);
            }


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
            //$redirector->setUrlParameter('id', $utilizador->getId());
            $redirector->goToControllerAction('Utilizador', 'perfil');
        } catch (Exception $exc) {
            $this->dados['mensagem'] = $exc->getMessage();
            $this->view('erro/in', $this->dados);
        }
    }

    /**
     * @Método: imprimirAction
     * @Descrição: Processa a impressão (pdf) da informação do utilizador 
     * 
     */
    public function imprimirAction() {
        try {
            //Carrega as perfis para a visão 
            $this->dados['funcoes'] = (new PerfilDAO())->listarTodos();
            $this->view('utilizador/imprimirPDF', $this->dados, '.php');
        } catch (Exception $exc) {
            
            $this->dados['mensagem'] = $exc->getMessage();
            $this->view('erro/in', $this->dados);
        }
    }

    public function perfilAction() {
        try {
            $utilizadorDAO = new UtilizadorDAO();
            $retorno = $utilizadorDAO->buscarID($this->getParams('id'));

            $this->dados['entity'] = ($retorno != null ? $retorno : null);
            $this->dados['logs'] = (new LogDAO())->logUtilizador($this->session->selectSession('userData')->getId());
            $this->dados['documentos'] = (new DocumentoDAO())->mostrarDocs($this->session->selectSession('userData')->getId());
            $this->dados['perfis'] = (new PerfilDAO())->listarTodos();

            $this->view('utilizador/perfil', $this->dados);
        } catch (Exception $exc) {
            $this->dados['mensagem'] = $exc->getMessage();
            $this->view('erro/in', $this->dados);
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
            $this->view('utilizador/RelatorioGeralPDF', $this->dados, ".php");
        } catch (Exception $exc) {
            $this->dados['mensagem'] = $exc->getMessage();
            $this->view('erro/in', $this->dados);
        }
    }

}
