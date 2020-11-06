<?php

class SessionHelper {

    public function createSession($name, $value) {
        $_SESSION[$name] = serialize($value);
            //    $_SESSION[$name] = $value;
        return $this;
    }

    public function selectSession($name) {
        return unserialize($_SESSION[$name]);
    }

    public function deleteSession($name) {
        unset($_SESSION[$name]);
        return $this;
    }

    public function deleteAllSession() {
        session_unset(); 
        session_destroy();
    }

    public function checkSession($name) {
        return isset($_SESSION[$name]);
    }

}
