<?php
/**
 * @version 1.105
 * @package entity
 */
class TipoEscolaDAO {

    private $pdo;

    public function __construct() {
        $this->pdo = Model::conectar();
    }

    public function salvar(TipoEscola $tipoescola) {
        $this->pdo->beginTransaction();
        try {
            $stmt = $this->pdo->prepare(
                    'INSERT INTO tipo_escola (nome, descricao) VALUES (:nome, :descricao)'
            );

            $stmt->bindValue(':nome', $tipoescola->getNome());
            $stmt->bindValue(':descricao', $tipoescola->getDescricao());
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

    public function actualizar(TipoEscola $tipoescola) {
        $this->pdo->beginTransaction();
        try {
            $stmt = $this->pdo->prepare(
                    'UPDATE  tipo_escola SET nome=:nome, descricao=:descricao WHERE id = :id'
            );
            $stmt->bindValue(':id', $tipoescola->getId());
            $stmt->bindValue(':nome', $tipoescola->getNome());
            $stmt->bindValue(':descricao', $tipoescola->getDescricao());
            $stmt->execute();

            $this->pdo->commit();
        } catch (Exception $e) {
                    if ($this->pdo->inTransaction()){
            $this->pdo->rollback();
        }
            throw $e;
        }
    }

    public function eliminar(TipoEscola $tipoescola) {
        $this->pdo->beginTransaction();
        try {
            $stmt = $this->pdo->prepare(
                    'DELETE  FROM tipo_escola WHERE  id = :id'
            );
            $stmt->bindValue(':id', $tipoescola->getId());

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
        $statement = $this->pdo->prepare('SELECT * FROM tipo_escola WHERE id = :id ');
        $statement->bindValue(':id', $id);
        $statement->execute();

        $retorno = $this->processResults($statement);
        return (!empty($retorno) ? $retorno[0] : null);
    }
    
    public function listarTodos($orderby = 'nome') {
        $statement = $this->pdo->query('SELECT * FROM tipo_escola ORDER BY ' . $orderby . '');

        return $this->processResults($statement);
    }

    private function processResults($statement) {
        $results = array();

        if ($statement) {
            while ($row = $statement->fetch(PDO::FETCH_OBJ)) {
                $tipoescola = new TipoEscola();

                $tipoescola->setId($row->id);
                $tipoescola->setNome($row->nome);
                $tipoescola->setDescricao($row->descricao);

                $results[] = $tipoescola;
            }
        }
        return $results;
    }
}
