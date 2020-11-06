<?php
/**
 * @version 1.105
 * @package entity
 */
class CategoriaDAO {

    private $pdo;

    public function __construct() {
        $this->pdo = Model::conectar();
    }

    public function salvar(Categoria $categoria) {
        $this->pdo->beginTransaction();
        try {
            $stmt = $this->pdo->prepare(
                    'INSERT INTO categoria (nome, descricao) VALUES (:nome, :descricao)'
            );

            $stmt->bindValue(':nome', $categoria->getNome());
            $stmt->bindValue(':descricao', $categoria->getDescricao());
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

    public function actualizar(Categoria $categoria) {
        $this->pdo->beginTransaction();
        try {
            $stmt = $this->pdo->prepare(
                    'UPDATE  categoria SET nome=:nome, descricao=:descricao WHERE id = :id'
            );
            $stmt->bindValue(':id', $categoria->getId());
            $stmt->bindValue(':nome', $categoria->getNome());
            $stmt->bindValue(':descricao', $categoria->getDescricao());
            $stmt->execute();

            $this->pdo->commit();
        } catch (Exception $e) {
                    if ($this->pdo->inTransaction()){
            $this->pdo->rollback();
        }
            throw $e;
        }
    }

    public function eliminar(Categoria $categoria) {
        $this->pdo->beginTransaction();
        try {
            $stmt = $this->pdo->prepare(
                    'DELETE  FROM categoria WHERE  id = :id'
            );
            $stmt->bindValue(':id', $categoria->getId());

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
        $statement = $this->pdo->prepare('SELECT * FROM categoria WHERE id = :id ');
        $statement->bindValue(':id', $id);
        $statement->execute();

        $retorno = $this->processResults($statement);
        return (!empty($retorno) ? $retorno[0] : null);
    }
    
    public function listarTodas($orderby = 'nome') {
        $statement = $this->pdo->query('SELECT * FROM categoria ORDER BY ' . $orderby . '');

        return $this->processResults($statement);
    }

    private function processResults($statement) {
        $results = array();

        if ($statement) {
            while ($row = $statement->fetch(PDO::FETCH_OBJ)) {
                $categoria = new Categoria();

                $categoria->setId($row->id);
                $categoria->setNome($row->nome);
                $categoria->setDescricao($row->descricao);

                $results[] = $categoria;
            }
        }
        return $results;
    }
}
