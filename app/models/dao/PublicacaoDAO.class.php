<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of PublicacaoDAO
 *
 * @author Júlio Manuel
 */
class PublicacaoDAO {

    private $pdo;

    public function __construct() {
        $this->pdo = Model::conectar();
    }

    public function salvar(Publicacao $publicacao) {
        $this->pdo->beginTransaction();
        try {
            $stmt = $this->pdo->prepare(
                    'INSERT INTO publicacao (titulo, texto, destaque, imagem, data, local, estado, utilizador) VALUES (:titulo, :texto, :destaque, :imagem, :data, :local, :estado, :utilizador)'
            );

            $stmt->bindValue(':titulo', $publicacao->getTitulo());
            $stmt->bindValue(':texto', $publicacao->getTexto());
            $stmt->bindValue(':destaque', $publicacao->getDestaque());
            $stmt->bindValue(':imagem', $publicacao->getImagem());
            $stmt->bindValue(':data', $publicacao->getData());
            $stmt->bindValue(':local', $publicacao->getLocal());
            $stmt->bindValue(':estado', $publicacao->getEstado());
            $stmt->bindValue(':utilizador', $publicacao->getUtilizador());
            $stmt->execute();
            $lastId = $this->pdo->lastInsertId();

            $this->pdo->commit();
            return $this->buscarID($lastId);
        } catch (Exception $e) {
            if ($this->pdo->inTransaction()) {
                $this->pdo->rollback();
            }
            throw $e;
        }
    }

    public function actualizar(Publicacao $publicacao) {
        $this->pdo->beginTransaction();
        try {
            $stmt = $this->pdo->prepare(
                    'UPDATE publicacao SET titulo = :titulo, destaque=:destaque, texto = :texto, data = :data, local = :local, estado = :estado WHERE id = :id'
            );
            $stmt->bindValue(':id', $publicacao->getId());
            $stmt->bindValue(':titulo', $publicacao->getTitulo());
            $stmt->bindValue(':destaque', $publicacao->getDestaque());
            $stmt->bindValue(':texto', $publicacao->getTexto());
            $stmt->bindValue(':data', $publicacao->getData());
            $stmt->bindValue(':local', $publicacao->getLocal());
            $stmt->bindValue(':estado', $publicacao->getEstado());
            $stmt->execute();

            $this->pdo->commit();
        } catch (Exception $e) {
            if ($this->pdo->inTransaction()) {
                $this->pdo->rollback();
            }
            throw $e;
        }
    }

    public function eliminar(Publicacao $publicacao) {
        $this->pdo->beginTransaction();
        try {
            $stmt = $this->pdo->prepare(
                    'DELETE  FROM publicacao WHERE id = :id'
            );
            $stmt->bindValue(':id', $publicacao->getId());
            $stmt->execute();

            $this->pdo->commit();
        } catch (Exception $e) {
            if ($this->pdo->inTransaction()) {
                $this->pdo->rollback();
            }
            throw $e;
        }
    }

    public function buscarID($id) {
        $statement = $this->pdo->prepare('SELECT * FROM publicacao WHERE id = :id');
        $statement->bindValue(':id', $id);
        $statement->execute();

        $retorno = $this->processResults($statement);
        return (!empty($retorno) ? $retorno[0] : null);
    }

    /*
    public function findByArea($area) {
        $statement = $this->pdo->query("SELECT * FROM publicacao WHERE area = $area ORDER BY id ASC ");
        return $this->processResults($statement);
    }
    */

    public function listarTodas($orderby = 'data') {
        $statement = $this->pdo->query('SELECT * FROM publicacao ORDER BY ' . $orderby . '');

        return $this->processResults($statement);
    }

    public function listarTodasPublicadas($orderby = 'id') {
        $statement = $this->pdo->query('SELECT * FROM publicacao where estado=1 ORDER BY ' . $orderby . ' desc');

        return $this->processResults($statement);
    }

    public function findByTitulo($titulo) {
        $statement = $this->pdo->query("SELECT * FROM publicacao WHERE titulo = '" . $titulo . "'");

        return $this->processResults($statement);
    }

    public function findByPublicacao($titulo) {
        $statement = $this->pdo->query("SELECT * FROM publicacao WHERE titulo LIKE '%" . $titulo . "%'");

        return $this->processResults($statement);
    }

    private function processResults($statement) {
        $results = array();

        if ($statement) {
            while ($row = $statement->fetch(PDO::FETCH_OBJ)) {
                $publicacao = new Publicacao();

                $publicacao->setId($row->id);
                $publicacao->setTitulo($row->titulo);
                $publicacao->setDestaque($row->destaque);
                $publicacao->setTexto($row->texto);
                $publicacao->setImagem($row->imagem);
                $publicacao->setData($row->data);
                $publicacao->setLocal($row->local);
                $publicacao->setEstado($row->estado);

                #Utilizador
                $publicacao->setUtilizador((new UtilizadorDAO())->buscarID($row->utilizador));

                $results[] = $publicacao;
            }
        }

        return $results;
    }

}
