<?php
/**
 * Description of Utilizador
 *
 * @author mrvipaji
 */
class Utilizador {

    /**
     * @var integer
     */
    private $id;

    /**
     * @var string
     */
    private $email;

    /**
     * @var string
     */
    private $nome;

    /**
     * @var string
     */
    private $password;

    /**
     * @var string
     */
    private $password_actual;

    /**
     * @var integer
     */
    private $estado = Geral::CONS_UTILIZADOR_DESACTIVADO;

    /**
     * @var perfil
     */
    private $perfil;

    /**
     * @var string
     */
    private $telefone;

    /**
     * @var int
     */
    private $escola;

    /**
     * @var string
     */
    private $foto;

    /**
     * @var date
     */
    private $data_inscricao;

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
     * Set password
     *
     * @param string 
     */
    public function setPassword($password) {
        $this->password = $password;
        return $this;
    }

    /**
     * Get password
     *
     * @return string 
     */
    public function getPassword() {
        return $this->password;
    }

    /**
     * Set password_actual
     *
     * @param string 
     */
    public function setPasswordActual($password_actual) {
        $this->password_actual = $password_actual;
        return $this;
    }

    /**
     * Get password_actual
     *
     * @return string 
     */
    public function getPasswordActual() {
        return $this->password_actual;
    }

    /**
     * Set estado
     *
     * @param string 
     */
    public function setEstado($estado) {
        $this->estado = intval(rtrim((ltrim($estado))));
        return $this;
    }

    /**
     * Get estado
     *
     * @return string 
     */
    public function getEstado() {
        return intval(rtrim((ltrim($this->estado))));
    }

    /**
     * Set perfil
     *
     * @param perfil 
     */
    public function setPerfil($perfil) {
        $this->perfil = $perfil;
        return $this;
    }

    /**
     * Get perfil
     *
     * @return perfil 
     */
    public function getPerfil() {
        return $this->perfil;
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
     * Set escola
     *
     * @param int 
     */
    public function setEscola($escola) {
        $this->escola = $escola;
        return $this;
    }

    /**
     * Get escola
     *
     * @return int 
     */
    public function getEscola() {
        return $this->escola;
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
     * Set data_inscricao
     *
     * @param date 
     */
    public function setDataInscricao($data_inscricao) {
        $this->data_inscricao = $data_inscricao;
        return $this;
    }

    /**
     * Get data_inscricao
     *
     * @return date 
     */
    public function getDataInscricao() {
        return $this->data_inscricao;
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
