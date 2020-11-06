<?php

/**
 * Description of Produto
 *
 * @author mrvipaji
 */
class Produto {

    /**
     * @var integer
     */
    private $id;

    /**
     * @var string
     */
    private $codigo;

    /**
     * @var string
     */
    private $nome;

    /**
     * @var string
     */
    private $foto;

    /**
     * @var string
     */
    private $descricao;

    /**
     * @var string
     */
    private $preco;

    /**
     * @var string
     */
    private $origem;

    /**
     * @var integer
     */
    private $marca;

    /**
     * @var integer
     */
    private $categoria;

    /**
     * @var integer
     */
    private $tipo;

    /**
     * @var integer
     */
    private $estado;

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
     * Set codigo
     *
     * @param string 
     */
    public function setCodigo($codigo) {
        $this->codigo = $codigo;
          return $this;
    }

    /**
     * Get codigo
     *
     * @return string 
     */
    public function getCodigo() {
        return $this->codigo;
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
     * Set preco
     *
     * @param string 
     */
    public function setPreco($preco) {
        $this->preco = $preco;
          return $this;
    }

    /**
     * Get preco
     *
     * @return string 
     */
    public function getPreco() {
        return $this->preco;
    }

    /**
     * Set origem
     *
     * @param string 
     */
    public function setOrigem($origem) {
        $this->origem = $origem;
          return $this;
    }

    /**
     * Get origem
     *
     * @return string 
     */
    public function getOrigem() {
        return $this->origem;
    }

    /**
     * Set marca
     *
     * @param integer 
     */
    public function setMarca($marca) {
        $this->marca = $marca;
          return $this;
    }

    /**
     * Get marca
     *
     * @return integer 
     */
    public function getMarca() {
        return $this->marca;
    }

    /**
     * Set categoria
     *
     * @param integer 
     */
    public function setCategoria($categoria) {
        $this->categoria = $categoria;
          return $this;
    }

    /**
     * Get categoria
     *
     * @return integer 
     */
    public function getCategoria() {
        return $this->categoria;
    }

    /**
     * Set tipo
     *
     * @param integer 
     */
    public function setTipo($tipo) {
        $this->tipo = $tipo;
          return $this;
    }

    /**
     * Get tipo
     *
     * @return integer 
     */
    public function getTipo() {
        return $this->tipo;
    }

    /**
     * Set estado
     *
     * @param integer 
     */
    public function setEstado($estado) {
        $this->estado = $estado;
          return $this;
    }

    /**
     * Get estado
     *
     * @return integer 
     */
    public function getEstado() {
        return $this->estado;
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
