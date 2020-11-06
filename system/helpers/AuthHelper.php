<?php

class AuthHelper {

    protected $sessionHelper;
    protected $redirectorHelper;
    protected $user;
    protected $pass;
    protected $loginController = "Login";
    protected $loginAction = "index";
    protected $logoutController = "Login";
    protected $logoutAction = "index";

    public function __construct() {
        $this->sessionHelper = new SessionHelper();
        $this->redirectorHelper = new RedirectorHelper();
        return $this;
    }

    public function setUser($user) {
        $this->user = $user;
        return $this;
    }

    public function setPass($pass) {
        $this->pass = $pass;
        return $this;
    }

    public function setLoginControllerAction($controller, $action) {
        $this->loginController = $controller;
        $this->loginAction = $action;
        return $this;
    }

    public function setLogoutControllerAction($controller, $action) {
        $this->logoutController = $controller;
        $this->logoutAction = $action;
        return $this;
    }

    public function login() {
        
        $utilizador = new Utilizador();
        $utilizador->setEmail($this->user)
                ->setPassword($this->pass);

        $utilizadorDAO = new UtilizadorDAO();
        $utilizador = $utilizadorDAO->autentica($utilizador);

        if (!($utilizador == null)) {
            $this->sessionHelper->createSession('userAuth', true)->createSession('userData', $utilizador);
            
        } else {
            throw new Exception("<strong> Falha na Autenticação.</strong><br/><strong>E-mail</strong> e/ou <strong>Palavra-passe</strong> incorrectos.");
        }

        $this->redirectorHelper->goToControllerAction($this->loginController, $this->loginAction);
        return $this;
    }

    public function logout() {
        $this->sessionHelper->deleteAllSession();
        $this->redirectorHelper->goToControllerAction($this->logoutController, $this->logoutAction);
        return $this;
    }

    public function checkLogin($action) {
        switch ($action) {
            case 'boolean' :
                if (!$this->sessionHelper->checkSession('userAuth')) {
                    return false;
                } else {
                    return true;
                }break;
            case 'redirect' :
                if ($this->checkControllerAction() == true) {
                    $this->redirectorHelper->goToControllerAction($this->loginController, $this->loginAction);
                }break;
            case 'stop' :
                if (!$this->sessionHelper->checkSession('userAuth')) {
                    exit;
                } break;
        }
    }

    private function checkControllerAction() {
        if (!$this->sessionHelper->checkSession('userAuth')) {
            if (($this->redirectorHelper->getCurrentController() != $this->loginController) || ($this->redirectorHelper->getCurrentAction() != $this->loginAction)) {
                return true;
            }
        }
        return false;
    }

    public function getUserData() {
        return $this->sessionHelper->selectSession('userData');
    }

    public function HasPermission($permission) {
        $utilizador = $this->sessionHelper->selectSession('userData');
  
        
        foreach ($utilizador->getPerfil()->getPermissoes() as $permissao) {
            if (Method::upperGeneral($permissao->getNome()) == Method::upperGeneral($permission)){
                return 1; 
            }
        }
        return 0; 
    }

}
