<?php

/**
 * Description of Evento
 *
 * @author mrvipaji
 */
class Evento {

    /**
     * @var integer
     */
    private $id;

    /**
     * @var string
     */
    private $nome;

    /**
     * @var date
     */
    private $data;

    /**
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