<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Publicao
 *
 * @author Júlio Manuel
 */
class Publicacao {

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
    private $destaque;

    /**
     * @var string
     */
    private $texto;

    /**
     * @var string
     */
    private $imagem;

    /**
     * @var date
     */
    private $data;

    /**
     * @var string
     */
    private $local;

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
     * Set destaque
     *
     * @param string 
     */
    public function setDestaque($destaque) {
        $this->destaque = $destaque;
        return $this;
    }

    /**
     * Get destaque
     *
     * @return string 
     */
    public function getDestaque() {
        return $this->destaque;
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
     * Set imagem
     *
     * @param string 
     */
    public function setImagem($imagem) {
        $this->imagem = $imagem;
        return $this;
    }

    /**
     * Get imagem
     *
     * @return string 
     */
    public function getImagem() {
        return $this->imagem;
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
     * Set local
     *
     * @param string 
     */
    public function setLocal($local) {
        $this->local = $local;
        return $this;
    }

    /**
     * Get local
     *
     * @return string 
     */
    public function getLocal() {
        return $this->local;
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
