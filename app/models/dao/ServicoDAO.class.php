<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ServicoDAO
 *
 * @author Administrator
 */
class ServicoDAO {

    private $pdo;

    public function __construct() {
        $this->pdo = Model::conectar();
    }

    public function salvar(Servico $servico) {
        $this->pdo->beginTransaction();
        try {
            $stmt = $this->pdo->prepare(
                    'INSERT INTO servico (area, nome, descricao) VALUES (:area, :nome,  :descricao)'
            );

            $stmt->bindValue(':area', $servico->getArea());
            $stmt->bindValue(':nome', $servico->getNome());
            $stmt->bindValue(':descricao', $servico->getDescricao());
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

    public function actualizar(Servico $servico) {
        $this->pdo->beginTransaction();
        try {
            $stmt = $this->pdo->prepare(
                    'UPDATE servico SET area = :area, nome = :nome,  descricao = :descricao WHERE id = :id'
            );
            $stmt->bindValue(':id', $servico->getId());
            $stmt->bindValue(':area', $servico->getArea());
            $stmt->bindValue(':nome', $servico->getNome());
            $stmt->bindValue(':descricao', $servico->getDescricao());
            $stmt->execute();

            $this->pdo->commit();
        } catch (Exception $e) {
            if ($this->pdo->inTransaction()) {
                $this->pdo->rollback();
            }
            throw $e;
        }
    }

    public function eliminar(Servico $servico) {
        $this->pdo->beginTransaction();
        try {
            $stmt = $this->pdo->prepare(
                    'DELETE  FROM servico WHERE id = :id'
            );
            $stmt->bindValue(':id', $servico->getId());
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
        $statement = $this->pdo->prepare('SELECT * FROM servico WHERE id = :id ');
        $statement->bindValue(':id', $id);
        $statement->execute();

        $retorno = $this->processResults($statement);
        return (!empty($retorno) ? $retorno[0] : null);
    }

    public function findByArea($area) {
        $statement = $this->pdo->query("SELECT * FROM servico WHERE area = $area ORDER BY id ASC ");
        return $this->processResults($statement);
    }

    public function listarTodos($orderby = 'nome') {
        $statement = $this->pdo->query('SELECT * FROM servico ORDER BY ' . $orderby . '');

        return $this->processResults($statement);
    }

    private function processResults($statement) {
        $results = array();

        if ($statement) {
            while ($row = $statement->fetch(PDO::FETCH_OBJ)) {
                $servico = new Servico();

                $servico->setId($row->id);
                $servico->setNome($row->nome);
                $servico->setDescricao($row->descricao);

                #Area
                $servico->setArea((new AreaDAO())->buscarID($row->area));

                $results[] = $servico;
            }
        }

        return $results;
    }

}
