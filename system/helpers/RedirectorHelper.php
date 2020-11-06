<?php

class RedirectorHelper {

    protected $parameters = array();

    protected function go($data) {
        header("Location: ". DS . APP_NAME. DS . $data);
    }

    public function setUrlParameter($name, $value) {
        
        $this->parameters[base64_encode($name)] = base64_encode($value);
    }

    protected function getUrlParameters() {
        $param = "";
        foreach ($this->parameters as $name => $value) {
            $param .=$name . DS. $value . DS;
        }
        return $param;
    }

    public function goToController($controller) {
        $this->go($controller . DS. 'index'. DS . $this->getUrlParameters());
    }

    public function goToAction($action) {
        $this->go($this->getCurrentController() . DS . $action . DS . $this->getUrlParameters());
    }

    public function getCurrentController() {
        global $app;
        return substr($app->getController(), 0, -10);
    }

    public function getCurrentAction() {
        global $app;
        return substr($app->getAction(), 0, -6);
    }

    public function goToControllerAction($controller, $action) {
        $this->go($controller . DS . $action .DS. $this->getUrlParameters());
    }
    
    public function goToControllerValuesAction($controller, $action,$values) {
        $this->go($controller . DS . $action .DS. $values);
    }

    public function goToIndex() {
        $this->goToController('index');
    }

    public function goToUrl($url) {
        header("Location: " . $url);
    }

}
