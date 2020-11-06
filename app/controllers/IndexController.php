<?php

Class IndexController extends Controller {

    public function init() {
        
    }

    public function indexAction() {
        $re = new RedirectorHelper();
        $re->goToController('Home');
    }

}
