<?php
/**
 * Description of Documentos
 *
 * @author mr.vipaji
 */
class Documento {

    /**
     * @var integer
     */
    private $id;

    /**
     * @var string
     */
    private $ficheiro;

    /**
     * @var string
     */
    private $tipo;

    /**
     * @var string
     */
    private $descricao;

    /**
     * @var int
     */
    private $utilizador;

    /**
     * @var date
     */
    private $data;

    function getId() {
        return $this->id;
    }

    function getFicheiro() {
        return $this->ficheiro;
    }

    function getTipo() {
        return $this->tipo;
    }

    function getDescricao() {
        return $this->descricao;
    }

    function getUtilizador() {
        return $this->utilizador;
    }

    function getData() {
        return $this->data;
    }

    function setId($id) {
        $this->id = $id;
        return $this;
    }

    function setFicheiro($ficheiro) {
        $this->ficheiro = $ficheiro;
        return $this;
    }

    function setTipo($tipo) {
        $this->tipo = $tipo;
        return $this;
    }

    function setDescricao($descricao) {
        $this->descricao = $descricao;
        return $this;
    }

    function setUtilizador($utilizador) {
        $this->utilizador = $utilizador;
        return $this;
    }

    function setData($data) {
        $this->data = $data;
        return $this;
    }

    public function __toString() {
        return $this->id;
    }

}
