<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Permissao
 *
 * @author mrvipaji
 */
class Permissao {

    /**
     * @var integer
     */
    private $id;

    /**
     * @var string
     */
    private $nome;

    /*
     * @var string
     */
    private $descricao;

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
     * Set nome
     *
     * @param string 
     */
    public function setNome($nome) {
        $this->nome = $nome;
          return $this;
    }

    /**
     * Get nome
     *
     * @return string 
     */
    public function getNome() {
        return $this->nome;
    }

    /**
     * Set descricao
     *
     * @param string 
     */
    public function setDescricao($descricao) {
        $this->descricao = $descricao;
          return $this;
    }

    /**
     * Get descricao
     *
     * @return string 
     */
    public function getDescricao() {
        return $this->descricao;
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
