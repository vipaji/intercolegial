<?php

/**
 * 
 *
 * @version 1.105
 * @package entity
 */
class DocumentoDAO {

    private $pdo;

    public function __construct() {
        $this->pdo = Model::conectar();
    }

    public function salvar(Documento $documento) {
        $this->pdo->beginTransaction();
        try {
            $stmt = $this->pdo->prepare(
                    'INSERT INTO documento (ficheiro, tipo, descricao, data, utilizador) VALUES (:ficheiro, :tipo, :descricao, :data, :utilizador)'
            );

            $stmt->bindValue(':ficheiro', $documento->getFicheiro());
            $stmt->bindValue(':tipo', $documento->getTipo());
            $stmt->bindValue(':descricao', $documento->getDescricao());
            $stmt->bindValue(':data', $documento->getData());
            $stmt->bindValue(':utilizador', $documento->getUtilizador());

            $stmt->execute();
            $lastId = $this->pdo->lastInsertId();

            $this->pdo->commit();
            return $this->buscarID($lastId);
        } catch (Exception $e) {
            if ($this->pdo->inTransaction()) {
                $this->pdo->rollback();
            }
        }
    }

    public function actualizar(Documento $documento) {
        $this->pdo->beginTransaction();
        try {
            $stmt = $this->pdo->prepare(
                    'UPDATE  documento SET ficheiro = :ficheiro,  tipo =:tipo, descricao=:descricao, data=:data WHERE id = :id'
            );
            $stmt->bindValue(':id', $documento->getId());
            $stmt->bindValue(':ficheiro', $documento->getFicheiro());
            $stmt->bindValue(':tipo', $documento->getTipo());
            $stmt->bindValue(':descricao', $documento->getDescricao());
            $stmt->bindValue(':data', $documento->getData());

            $stmt->execute();

            $this->pdo->commit();
        } catch (Exception $e) {
            if ($this->pdo->inTransaction()) {
                $this->pdo->rollback();
            }
        }
    }

    public function eliminar(Documento $documento) {
        $this->pdo->beginTransaction();
        try {
            $stmt = $this->pdo->prepare(
                    'DELETE  FROM documento WHERE  id = :id'
            );
            $stmt->bindValue(':id', $documento->getId());
            $stmt->execute();

            $this->pdo->commit();
        } catch (Exception $e) {
            if ($this->pdo->inTransaction()) {
                $this->pdo->rollback();
            }
        }
    }

    /**
     *  @name: buscarID
     *  @description consulta na base de dados o registo documento através do ID 
     *  @param integer $id
     *  @return documento
     */
    public function buscarID($id) {
        $statement = $this->pdo->prepare('SELECT * FROM documento WHERE id = :id ');
        $statement->bindValue(':id', $id);
        $statement->execute();

        $retorno = $this->processResults($statement);
        return (!empty($retorno) ? $retorno[0] : null);
    }

    public function mostrarFotos($orderby = 'entidade') {
        $statement = $this->pdo->query('SELECT * FROM documento ORDER BY ' . $orderby . '');

        return $this->processResults($statement);
    }

    public function mostrarDocs($utilizador) {
        $statement = $this->pdo->query('SELECT * FROM documento WHERE utilizador ="'.$utilizador.'"');

        return $this->processResults($statement);
    }

    private function processResults($statement) {
        $results = array();

        if ($statement) {
            while ($row = $statement->fetch(PDO::FETCH_OBJ)) {
                $documento = new Documento();

                $documento->setId($row->id);
                $documento->setFicheiro($row->ficheiro);
                $documento->setTipo($row->tipo);
                $documento->setDescricao($row->descricao);
                $documento->setData($row->data);

                #Utilizador
                $utilizadorDAO = new UtilizadorDAO();
                $documento->setUtilizador($utilizadorDAO->buscarID($row->utilizador));

                $results[] = $documento;
            }
        }

        return $results;
    }

}
