<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Perfil
 *
 * @author mrvipaji
 */
class Perfil {

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

    /*
     * @var Array(Object)
     */
    private $permissoes;

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
     * Set permissoes
     *
     * @param Array(Object) 
     */
    public function setPermissoes($permissoes) {
        $this->permissoes = $permissoes;
          return $this;
    }

    /**
     * Get permissoes
     *
     * @return Array(Object) 
     */
    public function getPermissoes() {
        return $this->permissoes;
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
