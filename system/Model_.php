<?php
class Model {
    private $host;
    private $server_db;
    private $name_db;
    private $user_db;
    private $password_db;
    private $options_conect = array();
    private static $conexao;

    public function __construct() {

        $this->server_db = "mysql";
        $this->host = "localhost"; // 127.0.0.1
        $this->name_db = "intercolegialtinatune";
        $this->user_db = "mr.vipaji";
        $this->password_db = "Angola@2020!";
        $this->options_conect = array(
            PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"
        );

        try {

            self::$conexao = new PDO("$this->server_db:host=$this->host;dbname=$this->name_db", "$this->user_db", "$this->password_db", $this->options_conect
            );

            self::$conexao->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            self::$conexao->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
           
        } catch (PDOException $exc) {

            throw $exc;
        }
    }

    public static function conectar() {
        if (!isset(self::$conexao) || empty(self::$conexao)) {
            new Model();
        }
        return self::$conexao;
    }

    // desconecta
    public static function close() {
        if (self::$conexao != null) {
            self::$conexao = null;
        }
    }

}
