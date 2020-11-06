<?php

/**
 * Description of Blog
 *
 * @author mrvipaji
 */
class Blog {

    /**
     * @var integer
     */
    private $id;

    /**
     * @var string
     */
    private $titulo;

    /**
     * @var string
     */
    private $texto;

    /**
     * @var date
     */
    private $data;

    /**
     * @var string
     */
    private $foto;

    /**
     * @var int
     */
    private $estado;

    /**
     * @var int
     */
    private $utilizador;

    /**
     * Get id 
     *
     * @return integer 
     */
    public function getId() {
        return $this->id;
    }

    /**
     * Set id
     *
     * @param integer 
     */
    public function setId($id) {
        $this->id = $id;
          return $this;
    }

    /**
     * Set titulo
     *
     * @param string 
     */
    public function setTitulo($titulo) {
        $this->titulo = $titulo;
          return $this;
    }
    /**
     * Get titulo
     *
     * @return string 
     */
    public function getTitulo() {
        return $this->titulo;
    }

    /**
     * Set texto
     *
     * @param string 
     */
    public function setTexto($texto) {
        $this->texto = $texto;
          return $this;
    }
    /**
     * Get texto
     *
     * @return string 
     */
    public function getTexto() {
        return $this->texto;
    }

    /**
     * Set data
     *
     * @param date
     */
    public function setData($data) {
        $this->data = $data;
          return $this;
    }
    /**
     * Get data
     *
     * @return date
     */
    public function getData() {
        return $this->data;
    }

    /**
     * Set foto
     *
     * @param string 
     */
    public function setFoto($foto) {
        $this->foto = $foto;
          return $this;
    }
    /**
     * Get foto
     *
     * @return string 
     */
    public function getFoto() {
        return $this->foto;
    }

    /**
     * Set estado
     *
     * @param int 
     */
    public function setEstado($estado) {
        $this->estado = $estado;
          return $this;
    }
    /**
     * Get estado
     *
     * @return int 
     */
    public function getEstado() {
        return $this->estado;
    }

    /**
     * Set utilizador
     *
     * @param int
     */
    public function setUtilizador($utilizador) {
        $this->utilizador = $utilizador;
          return $this;
    }
    /**
     * Get utilizador
     *
     * @return int 
     */
    public function getUtilizador() {
        return $this->utilizador;
    }

    /**
     * toString
     *
     * @return string 
     */
    public function __toString() {
        return $this->id;
    }
}