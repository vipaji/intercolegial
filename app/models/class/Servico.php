<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

//descricao, area, iso, iso3, nome, nome_formal
/**
 * Description of Servico
 *
 * @author Administrator
 */
class Servico {

    /**
     * @var integer
     */
    private $id;

    /**
     * @var string
     */
    private $nome;

    /**
     * @var string
     */
    private $descricao;

    /**
     * @var integer
     */
    private $area;

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
     * Set area
     *
     * @param integer 
     */
    public function setArea($area) {
        $this->area = $area;
        return $this;
    }

    /**
     * Get area
     *
     * @return integer 
     */
    public function getArea() {
        return $this->area;
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
