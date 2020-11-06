<?php
/**
 * Description of Actividade
 *
 * @author mrvipaji.ao
 */
class Log {

    /**
     * @var integer
     */
    private $id;

    /**
     * @var integer
     */
    private $utilizador;

    /**
     * @var string
     */
    private $operacao;

    /**
     * @var data
     */
    private $data_hora;

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
     * Get utilizador 
     *
     * @return integer 
     */
    public function getUtilizador() {
        return $this->utilizador;
    }

    /**
     * Set utilizador
     *
     * @param integer 
     */
    public function setUtilizador($utilizador) {
        $this->utilizador = $utilizador;
        return $this;
    }

    /**
     * Set operacao
     *
     * @param string 
     */
    public function setOperacao($operacao) {
        $this->operacao = $operacao;
        return $this;
    }

    /**
     * Get operacao
     *
     * @return string 
     */
    public function getOperacao() {
        return $this->operacao;
    }

    /**
     * Set data_hora
     *
     * @param date 
     */
    public function setDatahora($data_hora) {
        $this->data_hora = $data_hora;
        return $this;
    }

    /**
     * Get data_hora
     *
     * @return date 
     */
    public function getDatahora() {
        return $this->data_hora;
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
        return $this->getId();
    }

}
