<?php

Class ProdutoController extends Controller {

    public function init() {
        
        $this->auth = new AuthHelper();
        $this->auth->setLoginControllerAction('Login', 'index')->checkLogin('redirect');

        $this->session = new SessionHelper();
        $this->dados['userInfo'] = $this->session->selectSession('userData');
        
        $this->dados['title_page'] = 'Produto &bull; Oliva de Angola &#8482;';
        $this->dados['page_context'] = "Produto";
        $this->dados['page_icon'] = "fa fa-dashboard";
        $this->dados['page_url'] = 'https://www.intercolegialtinatune.co.ao/Produto/';
        $this->dados['home_url'] = 'https://www.intercolegialtinatune.co.ao/Dashboard/';
    }

    public function indexAction() {
        try {
            $this->dados['entities'] = (new ProdutoDAO())->listarTodos();
            $this->view('produto/index', $this->dados);
        } catch (Exception $exc) {
            $this->dados['mensagem'] = $exc->getMessage();
            $this->view('erro/in', $this->dados);
        }
    }

    public function novoAction() {
        try
        {
            $this->dados['marcas'] = (new MarcaDAO())->listarTodas();
            $this->dados['categorias'] = (new CategoriaDAO())->listarTodas();
            $this->dados['tipos'] = (new TipoDAO())->listarTodos();
            $this->view('produto/novo', $this->dados);
        } 
        catch (Exception $exc)
        {
            $this->dados['mensagem'] = $exc->getMessage();
            $this->view('erro/in', $this->dados);
        }
    }

    public function registarAction() {
        try {
            $produto = new Produto();

            $produto->setCodigo(filter_input(INPUT_POST, 'codigo'));
            $produto->setNome(filter_input(INPUT_POST, 'nome'));
            $produto->setDescricao(filter_input(INPUT_POST, 'descricao'));
            $produto->setPreco(filter_input(INPUT_POST, 'preco'));
            $produto->setOrigem(filter_input(INPUT_POST, 'origem'));
            $produto->setMarca(filter_input(INPUT_POST, 'marca'));
            $produto->setCategoria(filter_input(INPUT_POST, 'categoria'));
            $produto->setTipo(filter_input(INPUT_POST, 'tipo'));
            $produto->setEstado(Geral::CONS_PRODUTO_ESTADO_INACTIVO);

            $produtoDAO = new ProdutoDAO();
            $produtoDAO->salvar($produto);
            $redirector = new RedirectorHelper();
            $redirector->goToControllerAction('Produto', 'index');
            unset($redirector);
        } catch (Exception $exc) {
            $this->dados['mensagem'] = $exc->getMessage();
            $this->view('erro/in', $this->dados);
        }
    }

    public function verAction() {
        try {
            if (!$this->auth->HasPermission("verProduto")) {
                throw new \Exception("Não tem permissão para <b>ver</b> Produto.");
            }

            //Tem Permissão
            $produtoDAO = new ProdutoDAO();
            $this->dados['entity'] = $produtoDAO->buscarID($this->getParams('id'));
            if ($this->getParams('id') == null ||  $this->dados['entity'] == null ) {
                throw new \Exception("Recurso não encontrado.");
            }

            $this->dados['marcas'] = (new MarcaDAO())->listarTodas();
            $this->dados['categorias'] = (new CategoriaDAO())->listarTodas();
            $this->dados['tipos'] = (new TipoDAO())->listarTodos();
            $this->dados['multimedias'] = (new MultimediaDAO())->FindByTabelaChave(Geral::CONS_ENTIDADE_PRODUTO, $this->getParams('id'));

            $this->view('produto/ver', $this->dados);
        } catch (Exception $exc) {
            $this->dados['mensagem'] = $exc->getMessage();
            $this->view('erro/in', $this->dados);
        }
    }

    public function editarAction() {
        try {
            if (!$this->auth->HasPermission("verProduto")) {
                throw new \Exception("Não tem permissão para <b>editar</b> o Produto.");
            }

            //Tem Permissão
            $produtoDAO = new ProdutoDAO();
            $this->dados['entity'] = $produtoDAO->buscarID($this->getParams('id'));
            if ($this->getParams('id') == null ||  $this->dados['entity'] == null ) {
                throw new \Exception("Recurso não encontrado.");
            }

            $this->dados['marcas'] = (new MarcaDAO())->listarTodas();
            $this->dados['categorias'] = (new CategoriaDAO())->listarTodas();
            $this->dados['tipos'] = (new TipoDAO())->listarTodos();
            $this->dados['multimedias'] = (new MultimediaDAO())->FindByTabelaChave(Geral::CONS_ENTIDADE_PRODUTO, $this->getParams('id'));

            $this->view('produto/editar', $this->dados);
        } catch (Exception $exc) {
            $this->dados['mensagem'] = $exc->getMessage();
            $this->view('erro/in', $this->dados);
        }
    }

    public function actualizarAction() {

        try {
            if (!$this->auth->HasPermission("editarProduto")) {
                throw new \Exception("<b>Não autorizado</b> a editar produto.");
            }

            $produtoDAO = new ProdutoDAO();
            $produto = $produtoDAO->buscarID(filter_input(INPUT_POST, 'id_produto'));
            
            $produto->setCodigo(filter_input(INPUT_POST, 'codigo'))
                    ->setNome(filter_input(INPUT_POST, 'nome'))
                    ->setDescricao(filter_input(INPUT_POST, 'descricao'))
                    ->setPreco(filter_input(INPUT_POST, 'preco'))
                    ->setOrigem(filter_input(INPUT_POST, 'origem'))
                    ->setMarca(filter_input(INPUT_POST, 'marca'))
                    ->setCategoria(filter_input(INPUT_POST, 'categoria'))
                    ->setTipo(filter_input(INPUT_POST, 'tipo'))
                    ->setEstado(filter_input(INPUT_POST, 'estado'));
            
            $produtoDAO->actualizar($produto);
            $redirector = new RedirectorHelper();
            $redirector->setUrlParameter('id', $produto->getId());
            $redirector->goToControllerAction('Produto', 'ver');

            unset($redirector);
        } catch (Exception $exc) {
            $this->dados['mensagem'] = $exc->getMessage();
            $this->view('erro/in', $this->dados);
        }
    }

    public function eliminarAction() {
        try {

            if (!$this->auth->HasPermission("eliminarProduto")) {
                throw new \Exception("<b>Não estás autorizado</b> a efectuar esta operação.");
            }
            $funcaoDAO = new FuncaoDAO();

            $retorno = $funcaoDAO->buscarID($this->getParams('id'));
            if (!$retorno) {
                throw new \Exception("Produto não encontrado.");
            }
            $funcaoDAO->eliminar($retorno);
            $redirector = new RedirectorHelper();
            $redirector->goToControllerAction('Produto', 'index');
            unset($redirector);
        } catch (Exception $exc) {
            $this->dados['mensagem'] = $exc->getMessage();
            $this->view('erro/in', $this->dados);
        }
    }

    /**
     * @Método: uploadMultimediaAction
     * @Descrição: faz upload de imagem para o produto
     * 
     */
    public function uploadMultimediaAction() {

        try {
            if (!$this->auth->HasPermission("uploadImagemProduto")) {
                throw new \Exception(Geral::CONS_MESSAGE_ERRO_PERFIL_SEM_PERMISSOES);
            }


            $produtoDAO = new ProdutoDAO();
            $produto = $produtoDAO->buscarID(base64_decode(filter_input(INPUT_POST, 'id_produto')));
            //print_r($produto->getNome()); die;

            if ($produto == null) {
                throw new \Exception(sprintf(Geral::CONS_MESSAGE_ERRO_ENTIDADE_NAO_ENCONTRADO, "Produto"));
            }

            $erro = null;

            if (!empty($_FILES['file'])) {
                $files = Upload::reArrayFiles($_FILES['file']);

                foreach ($files as $file) {
                    try {
                        $upload = new Upload($file, '..https://www.intercolegialtinatune.co.ao/web-files/uploads/produtos/');
                        if ($upload->upload() == TRUE) {

                            $multimedia = new Multimedia();
                            $multimedia->setDescricao($upload->getFicheiroDescricao())
                                    ->setFicheiro($upload->getFicheiroNome())
                                    ->setData((new Data())->getDataMySQL())
                                    ->setTipo(Method::devolveConstanteTipoMultimediaByTipo($upload->getFicheiroType()))
                                    ->setTabela(Geral::CONS_ENTIDADE_PRODUTO)
                                    ->setChave($produto->getId())
                                    ->setProduto((new ProdutoDAO())->buscarID($this->session->selectSession('userData')->getId()));

                            $multimediaDAO = new MultimediaDAO();
                            $multimediaDAO->salvar($multimedia);
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
            $redirector->setUrlParameter('id', $produto->getId());
            $redirector->goToControllerAction('Produto', 'ver');
        } catch (Exception $exc) {
            $this->dados['mensagem'] = $exc->getMessage();
            $this->view('erro/in', $this->dados);
        }
    }
    
    public function novafotoAction() {
        try {
            /*if (!$this->auth->HasPermission("FotoRostoProduto")) {
                throw new \Exception("Produto não autorizado.");
            }*/

            $produtoDAO = new ProdutoDAO();
            $produto = $produtoDAO->buscarID(filter_input(INPUT_POST, 'id_produto'));

            //$produto = new Produto();

            if (isset($_FILES)) {
                $uploadImagem = new UploadImagem($_FILES['foto_produto'], '..https://www.intercolegialtinatune.co.ao/web-files/uploads/produtos/');

                $up = $uploadImagem->upload();
                if ($up == TRUE) {
                    $produto->setFoto($uploadImagem->getImagemNome());
                    $produtoDAO->novafoto($produto);
                    Method::registaLog("Actualização", "Carregou foto de rosto do Produto: <b>".$produto->getNome()."</b>", $this->session->selectSession('userData')->getId());
                } else {
                    $produto->setFoto('indisponivel');
                    print_r($uploadImagem->getErrors());
                    die;
                    //Apresentar erros
                }
            }

            $redirector = new RedirectorHelper();
            $redirector->setUrlParameter('id', $produto->getId());
            $redirector->goToControllerAction('Produto', 'ver');
        } catch (Exception $exc) {
            $this->dados['mensagem'] = $exc->getMessage();
            $this->view('erro/in', $this->dados);
        }
    }

    /**
     * @Método: eliminarMultimediaAction
     * @Descrição: Eliminar último registo da evolução da obra do produto  
     * 
     */
    public function eliminarMultimediaAction() {
        try {
            if (!$this->auth->HasPermission("eliminarMultimedia")) {
                throw new \Exception(Geral::CONS_MESSAGE_ERRO_PERFIL_SEM_PERMISSOES);
            }
            $multimediaDAO = new MultimediaDAO();
            $retorno = $multimediaDAO->buscarID($this->getParams('id'));
            if ($retorno == null) {
                throw new Exception("Geral");
            }
            $multimediaDAO->eliminar($retorno);

            $redirector = new RedirectorHelper();

            $redirector->setUrlParameter('id', $this->getParams('id_produto'));
            $redirector->goToControllerAction('Produto', 'ver');

            unset($redirector);
            unset($multimediaDAO);
        } catch (Exception $exc) {
            //$this->dados['mensagem'] = ($exc->getCode() == "23000" ? "Dado(s) duplicado(s)" : "");
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
            if (!$this->auth->HasPermission("imprimirPDFProduto")) {
                throw new \Exception("Não estás autorizado a efectuar esta operação.");
            }
            $this->dados['entities'] = (new ProdutoDAO())->listarTodos();
            $this->view('produto/RelatorioGeralPDF', $this->dados, ".php");
        } catch (Exception $exc) {
            $this->dados['mensagem'] = $exc->getMessage();
            $this->view('erro/in', $this->dados);
        }
    }
}

