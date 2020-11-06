<?php
/**
 * @version 1.105
 * @package entity
 */
class EventoDAO {

    private $pdo;

    public function __construct() {
        $this->pdo = Model::conectar();
    }

    public function salvar(Evento $evento) {
        $this->pdo->beginTransaction();
        try {
            $stmt = $this->pdo->prepare(
                    'INSERT INTO evento (nome, data, descricao) VALUES (:nome, :data, :descricao)'
            );

            $stmt->bindValue(':nome', $evento->getNome());
            $stmt->bindValue(':data', $evento->getData());
            $stmt->bindValue(':descricao', $evento->getDescricao());
            $stmt->execute();
            $lastId = $this->pdo->lastInsertId();

            $this->pdo->commit();
            return $this->buscarID($lastId);
        } catch (Exception $e) {
                    if ($this->pdo->inTransaction()){
            $this->pdo->rollback();
        }
            throw $e;
        }
    }

    public function actualizar(Evento $evento) {
        $this->pdo->beginTransaction();
        try {
            $stmt = $this->pdo->prepare(
                    'UPDATE  evento SET nome=:nome, data=:data, descricao=:descricao WHERE id = :id'
            );
            $stmt->bindValue(':id', $evento->getId());
            $stmt->bindValue(':nome', $evento->getNome());
            $stmt->bindValue(':data', $evento->getData());
            $stmt->bindValue(':descricao', $evento->getDescricao());
            $stmt->execute();

            $this->pdo->commit();
        } catch (Exception $e) {
                    if ($this->pdo->inTransaction()){
            $this->pdo->rollback();
        }
            throw $e;
        }
    }

    public function eliminar(Evento $evento) {
        $this->pdo->beginTransaction();
        try {
            $stmt = $this->pdo->prepare(
                    'DELETE  FROM evento WHERE  id = :id'
            );
            $stmt->bindValue(':id', $evento->getId());

            $stmt->execute();

            $this->pdo->commit();
        } catch (Exception $e) {
                    if ($this->pdo->inTransaction()){
            $this->pdo->rollback();
        }
            throw $e;
        }
    }

    public function buscarID($id) {
        $statement = $this->pdo->prepare('SELECT * FROM evento WHERE id = :id ');
        $statement->bindValue(':id', $id);
        $statement->execute();

        $retorno = $this->processResults($statement);
        return (!empty($retorno) ? $retorno[0] : null);
    }
    
    public function listarTodos($orderby = 'nome') {
        $statement = $this->pdo->query('SELECT * FROM evento ORDER BY ' . $orderby . '');

        return $this->processResults($statement);
    }

    public function findByNome($nome) {
        $statement = $this->pdo->query("SELECT * FROM evento WHERE nome = '" . $nome . "'");

        return $this->processResults($statement);
    }

    private function processResults($statement) {
        $results = array();

        if ($statement) {
            while ($row = $statement->fetch(PDO::FETCH_OBJ)) {
                $evento = new Evento();

                $evento->setId($row->id);
                $evento->setNome($row->nome);
                $evento->setData($row->data);
                $evento->setDescricao($row->descricao);

                $results[] = $evento;
            }
        }
        return $results;
    }
}
