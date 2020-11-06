<?php

Class BlogController extends Controller {

    public function init() {
        $this->auth = new AuthHelper();
        $this->auth->setLoginControllerAction('Login', 'index')->checkLogin('redirect');

        $this->session = new SessionHelper();
        $this->dados['userInfo'] = $this->session->selectSession('userData');

        $this->dados['title_page'] = "Blogs &bull; Intercolegial Tina Tune &#8482;";
        $this->dados['page_context'] = "Blog";
        $this->dados['page_icon'] = "fa fa-start";
        $this->dados['page_url'] = 'https://www.intercolegialtinatune.co.ao/Blog/';
        $this->dados['home_url'] = 'https://www.intercolegialtinatune.co.ao/Dashboard/';
        $this->dados['id'] = 'blog';
    }

    public function indexAction() {
        try
        {
            $blogDAO = new BlogDAO();
            $this->dados['entities'] = $blogDAO->listarTodos();
            $this->view('blog/index', $this->dados);
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
            $this->view('blog/novo', $this->dados);
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
            $blogs = (new BlogDAO())->findByTitulo(filter_input(INPUT_POST, 'titulo'));
            if (count($blogs) > 0) {
                throw new \Exception("Já existe um blog com este título.");
            }

            $blog = new Blog();
            $blog->setTitulo(filter_input(INPUT_POST, 'titulo'))
                ->setTexto(filter_input(INPUT_POST, 'texto'))
                ->setData(date('Y-m-d'))
                ->setFoto(filter_input(INPUT_POST, 'foto'))
                ->setEstado(Geral::CONS_N_PUBLICADO)
                ->setUtilizador($this->session->selectSession('userData')->getId());

            $blogDAO = new BlogDAO();
            $blogDAO->salvar($blog);

            Method::registaLog("Adição", "Adicionou novo artigo no Blog: <b>".filter_input(INPUT_POST, 'titulo')."</b>", $this->session->selectSession('userData')->getId());
            $redirector = new RedirectorHelper();
            $redirector->goToControllerAction('Blog', 'index');
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
            $blogDAO = new BlogDAO();
            $retorno = $blogDAO->buscarID($this->getParams('id'));
            //echo "<pre>";
            //print_r($retorno); die;
            $this->dados['entity'] = ($retorno != null ? $retorno : null);

            $this->view('blog/ver', $this->dados);
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
            $blogDAO = new BlogDAO();
            $retorno = $blogDAO->buscarID($this->getParams('id'));
            $this->dados['entity'] = ($retorno != null ? $retorno : null);

            $this->view('blog/editar', $this->dados);
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
            $blogDAO = new BlogDAO();
            $retorno = $blogDAO->buscarID(filter_input(INPUT_POST, 'id_blog'));

            $blog = $retorno;
            $blog->setTitulo(filter_input(INPUT_POST, 'titulo'))
                    ->setTexto(filter_input(INPUT_POST, 'texto'))
                    ->setEstado(filter_input(INPUT_POST, 'estado'));

            $blogDAO->actualizar($blog);
            $redirector = new RedirectorHelper();
            $redirector->setUrlParameter('id', $blog->getId());
            $redirector->goToControllerAction('Blog', 'ver');

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
            /*if (!$this->auth->HasPermission("eliminarBlog")) {
                throw new \Exception("Não estás autorizado a efectuar esta operação.");
            }*/
            $blogDAO = new BlogDAO();

            $retorno = $blogDAO->buscarID($this->getParams('id'));
            if (!$retorno) {
                echo 'Permissão não encontrada.';
            }
            $blogDAO->eliminar($retorno);
            $redirector = new RedirectorHelper();
            $redirector->goToControllerAction('Blog', 'index');
            unset($redirector);
        }
        catch (Exception $exc)
        {
            $this->dados['mensagem'] = $exc->getMessage();
            $this->view('erro/in', $this->dados);
        }
    }

    /**
     * @Método: registarAction
     * @Descrição: Processa o atribuição de imagem ao artigo do BLOG
     * 
     */
    public function novafotoAction() {
        try {
            /*if (!$this->auth->HasPermission("fotoArtigo")) {
                throw new \Exception("Utilizador não autorizado.");
            }*/

            $blogDAO = new BlogDAO();
            $blog = $blogDAO->buscarID(filter_input(INPUT_POST, 'id_blog'));

            //$blog = new Utilizador();

            if (isset($_FILES)) {
                $uploadImagem = new UploadImagem($_FILES['foto_blog'], '..https://www.intercolegialtinatune.co.ao/web-files/uploads/blog/');

                $up = $uploadImagem->upload();
                if ($up == TRUE) {
                    $blog->setFoto($uploadImagem->getImagemNome());
                    $blogDAO->novafoto($blog);
                    Method::registaLog("Actualização", "Adicionou foto ao artigo <b>".$blog->getTitulo()."</b>", $this->session->selectSession('userData')->getId());
                } else {
                    $blog->setFoto('indisponivel');
                    print_r($uploadImagem->getErrors());
                    die;
                    //Apresentar erros
                }
            }

            $redirector = new RedirectorHelper();
            $redirector->setUrlParameter('id', $blog->getId());
            $redirector->goToControllerAction('Blog', 'ver');
        } catch (Exception $exc) {
            $this->dados['mensagem'] = $exc->getMessage();
            $this->view('erro/in', $this->dados);
        }
    }
}