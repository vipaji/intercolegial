<?php

class Controller extends App {

    protected $auth;
    protected $session;
    protected $dados = array();

    protected function view($nome, $vars = null, $ext = ".phtml") {
        if (is_array($vars) && count($vars) > 0) {
            extract($vars, EXTR_PREFIX_ALL, 'v');
        }

        $file = VIEWS . $nome . $ext;
        if (!file_exists($file)) {
            throw new Exception("Falha ao carregar a página. Página: ". $nome.$ext);
        }
        return require_once $file;
        exit();
    }

    public function init() {
        
    }

}
