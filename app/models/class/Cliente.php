<?php

/**
 * Description of Cliente
 *
 * @author mrvipaji
 */
class Cliente {

    /**
     * @var integer
     */
    private $id;

    /**
     * @var string
     */
    private $numero;

    /**
     * @var string
     */
    private $nome;

    /**
     * @var string
     */
    private $email;

    /**
     * @var string
     */
    private $telefone;

    /**
     * @var date
     */
    private $data_registo;

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
     * Set numero
     *
     * @param string 
     */
    public function setNumero($numero) {
        $this->numero = $numero;
          return $this;
    }

    /**
     * Get numero
     *
     * @return string 
     */
    public function getNumero() {
        return $this->numero;
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
     * Set email
     *
     * @param string 
     */
    public function setEmail($email) {
        $this->email = $email;
          return $this;
    }

    /**
     * Get email
     *
     * @return string 
     */
    public function getEmail() {
        return $this->email;
    }

    /**
     * Set telefone
     *
     * @param string 
     */
    public function setTelefone($telefone) {
        $this->telefone = $telefone;
          return $this;
    }

    /**
     * Get telefone
     *
     * @return string 
     */
    public function getTelefone() {
        return $this->telefone;
    }

    /**
     * Set data_registo
     *
     * @param string 
     */
    public function setDataRegisto($data_registo) {
        $this->data_registo = $data_registo;
          return $this;
    }

    /**
     * Get data_registo
     *
     * @return string 
     */
    public function getDataRegisto() {
        return $this->data_registo;
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