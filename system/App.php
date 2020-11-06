<?php

class App {

    private $url;
    private $explode;
    private $controller;
    private $action;
    protected $params = array();

    public function __construct() {
        $this->setUrl();
        $this->setExplode();
        $this->setController();
        $this->setAction();
        $this->setParams();
    }

    private function setUrl() {
        $this->url = filter_input(INPUT_GET, 'url');
    }

    private function setExplode() {
        if (isset($this->url)) {
            $this->explode = explode('/', filter_var(rtrim($this->url, '/'), FILTER_SANITIZE_URL));
        } else {
            $this->explode[0] = "Index";
        }
    }

    private function setController() {
        $this->controller = $this->explode[0] . 'Controller';
        unset($this->explode[0]);
    }

    public function getController() {
        return $this->controller;
    }

    public function getAction() {
        return $this->action;
    }

    private function setAction() {
        if (!isset($this->explode[1]) || $this->explode[1] == null || $this->explode[1] == "index") {
            $this->action = "indexAction";
        } else {
            $this->action = $this->explode[1] . "Action";
        }
        unset($this->explode[1]);
    }

    private function setParams() {
        $i = 0;
        $ind = array();
        $values = array();
        if (!empty($this->explode)) {
            foreach ($this->explode as $val) {
                if ($i % 2 == 0) {
                    $ind[] = base64_decode($val);
                } else {
                    $values[] = base64_decode($val);
                }
                $i++;
            }
        }

        if (count($ind) == count($values) && !empty($ind) && !empty($values)) {
            $this->params = array_combine($ind, $values);
        } else {
            $this->params = array();
        }

        // $this->params = ($this->explode ? array_values($this->explode) : array());
    }

    public function getParams($param = null) {
        if ($param == null) {
            return $this->params;
        } else {
            if (array_key_exists($param, $this->params)) {
                return $this->params[$param];
            } else {
                return false;
            }
        }
    }

    public function run() {
        $controller_path = CONTROLLERS . $this->controller . '.php';
        if (!file_exists($controller_path)) { 
            throw new Exception("Falha ao executar a operação. Controller: ". $this->controller);
        }
        require_once ($controller_path);
        $app = new $this->controller();

        if (!method_exists($app, $this->action)) {
            throw new Exception("Falha ao executar a operação. Action: ". $this->action);
        }
        $action = $this->action;
        $app->init();
        $app->$action();
    }

}
