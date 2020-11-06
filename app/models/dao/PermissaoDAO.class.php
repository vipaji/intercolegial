<?php
/**
 * @version 1.105
 * @package entity
 */
class PermissaoDAO {

    private $pdo;

    public function __construct() {
        $this->pdo = Model::conectar();
    }

    public function salvar(Permissao $permissao) {
        $this->pdo->beginTransaction();
        try {
            $stmt = $this->pdo->prepare(
                    'INSERT INTO permissao (nome, descricao) VALUES (:nome,  :descricao)'
            );

            $stmt->bindValue(':nome', $permissao->getNome());
            $stmt->bindValue(':descricao', $permissao->getDescricao());
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

    public function actualizar(Permissao $permissao) {
        $this->pdo->beginTransaction();
        try {
            $stmt = $this->pdo->prepare(
                    'UPDATE  permissao SET nome = :nome,   descricao =:descricao WHERE id = :id'
            );
            $stmt->bindValue(':id', $permissao->getId());
            $stmt->bindValue(':nome', $permissao->getNome());
            $stmt->bindValue(':descricao', $permissao->getDescricao());
            $stmt->execute();

            $this->pdo->commit();
        } catch (Exception $e) {
                    if ($this->pdo->inTransaction()){
            $this->pdo->rollback();
        }
            throw $e;
        }
    }

    public function eliminar(Permissao $permissao) {
        $this->pdo->beginTransaction();
        try {
            $stmt = $this->pdo->prepare(
                    'DELETE  FROM permissao WHERE  id = :id'
            );
            $stmt->bindValue(':id', $permissao->getId());

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
        $statement = $this->pdo->prepare('SELECT * FROM permissao WHERE id = :id ');
        $statement->bindValue(':id', $id);
        $statement->execute();

        $retorno = $this->processResults($statement);
        return (!empty($retorno) ? $retorno[0] : null);
    }

    public function buscarPermissao($permissao="CLIENTE") {
        $statement = $this->pdo->prepare("SELECT * FROM permissao WHERE nome = :nome ");
        $statement->bindValue(':nome', $permissao);
        $statement->execute();

        $retorno = $this->processResults($statement);
        return (!empty($retorno) ? $retorno[0] : null);
    }
    
    public function listarTodasIn($in_array) {
        $in  = str_repeat('?,', count($in_array) - 1) . '?';
        $statement = $this->pdo->prepare("SELECT * FROM permissao WHERE id in($in) ");
        $statement->execute($in_array);

        return $this->processResults($statement);
    }
    
    public function listarTodas($orderby = 'nome') {
        $statement = $this->pdo->query('SELECT * FROM permissao ORDER BY ' . $orderby . '');

        return $this->processResults($statement);
    }

    private function processResults($statement) {
        $results = array();

        if ($statement) {
            while ($row = $statement->fetch(PDO::FETCH_OBJ)) {
                $permissao = new Permissao();

                $permissao->setId($row->id);
                $permissao->setNome($row->nome);
                $permissao->setDescricao($row->descricao);

                $results[] = $permissao;
            }
        }

        return $results;
    }

}
