<?php
/**
 * @version 1.105
 * @package entity
 */
class MarcaDAO {

    private $pdo;

    public function __construct() {
        $this->pdo = Model::conectar();
    }

    public function salvar(Marca $marca) {
        $this->pdo->beginTransaction();
        try {
            $stmt = $this->pdo->prepare(
                    'INSERT INTO marca (nome, descricao) VALUES (:nome, :descricao)'
            );

            $stmt->bindValue(':nome', $marca->getNome());
            $stmt->bindValue(':descricao', $marca->getDescricao());
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

    public function actualizar(Marca $marca) {
        $this->pdo->beginTransaction();
        try {
            $stmt = $this->pdo->prepare(
                    'UPDATE  marca SET nome=:nome, descricao=:descricao WHERE id = :id'
            );
            $stmt->bindValue(':id', $marca->getId());
            $stmt->bindValue(':nome', $marca->getNome());
            $stmt->bindValue(':descricao', $marca->getDescricao());
            $stmt->execute();

            $this->pdo->commit();
        } catch (Exception $e) {
                    if ($this->pdo->inTransaction()){
            $this->pdo->rollback();
        }
            throw $e;
        }
    }

    public function eliminar(Marca $marca) {
        $this->pdo->beginTransaction();
        try {
            $stmt = $this->pdo->prepare(
                    'DELETE  FROM marca WHERE  id = :id'
            );
            $stmt->bindValue(':id', $marca->getId());

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
        $statement = $this->pdo->prepare('SELECT * FROM marca WHERE id = :id ');
        $statement->bindValue(':id', $id);
        $statement->execute();

        $retorno = $this->processResults($statement);
        return (!empty($retorno) ? $retorno[0] : null);
    }
    
    public function listarTodas($orderby = 'nome') {
        $statement = $this->pdo->query('SELECT * FROM marca ORDER BY ' . $orderby . '');

        return $this->processResults($statement);
    }

    private function processResults($statement) {
        $results = array();

        if ($statement) {
            while ($row = $statement->fetch(PDO::FETCH_OBJ)) {
                $marca = new Marca();

                $marca->setId($row->id);
                $marca->setNome($row->nome);
                $marca->setDescricao($row->descricao);

                $results[] = $marca;
            }
        }
        return $results;
    }
}
