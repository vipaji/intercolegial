<?php
/**
 * @version 1.105
 * @package entity
 */
class EscolaDAO {

    private $pdo;

    public function __construct() {
        $this->pdo = Model::conectar();
    }

    public function salvar(Escola $escola) {
        $this->pdo->beginTransaction();
        try {
            $stmt = $this->pdo->prepare(
                    'INSERT INTO escola (nome, tipo, descricao) VALUES (:nome, :tipo, :descricao)'
            );

            $stmt->bindValue(':nome', $escola->getNome());
            $stmt->bindValue(':tipo', $escola->getTipo());
            $stmt->bindValue(':descricao', $escola->getDescricao());
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

    public function actualizar(Escola $escola) {
        $this->pdo->beginTransaction();
        try {
            $stmt = $this->pdo->prepare(
                    'UPDATE  escola SET nome=:nome, tipo=:tipo, descricao=:descricao WHERE id = :id'
            );
            $stmt->bindValue(':id', $escola->getId());
            $stmt->bindValue(':nome', $escola->getNome());
            $stmt->bindValue(':tipo', $escola->getTipo());
            $stmt->bindValue(':descricao', $escola->getDescricao());
            $stmt->execute();

            $this->pdo->commit();
        } catch (Exception $e) {
                    if ($this->pdo->inTransaction()){
            $this->pdo->rollback();
        }
            throw $e;
        }
    }

    public function eliminar(Escola $escola) {
        $this->pdo->beginTransaction();
        try {
            $stmt = $this->pdo->prepare(
                    'DELETE  FROM escola WHERE  id = :id'
            );
            $stmt->bindValue(':id', $escola->getId());

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
        $statement = $this->pdo->prepare('SELECT * FROM escola WHERE id = :id ');
        $statement->bindValue(':id', $id);
        $statement->execute();

        $retorno = $this->processResults($statement);
        return (!empty($retorno) ? $retorno[0] : null);
    }
    
    public function listarTodas($orderby = 'nome') {
        $statement = $this->pdo->query('SELECT * FROM escola ORDER BY ' . $orderby . '');

        return $this->processResults($statement);
    }

    public function findByNome($nome) {
        $statement = $this->pdo->query("SELECT * FROM escola WHERE nome = '" . $nome . "'");

        return $this->processResults($statement);
    }

    private function processResults($statement) {
        $results = array();

        if ($statement) {
            while ($row = $statement->fetch(PDO::FETCH_OBJ)) {
                $escola = new Escola();

                $escola->setId($row->id);
                $escola->setNome($row->nome);

                #Tipo
                $escola->setTipo((new TipoEscolaDAO())->buscarID($row->tipo));
                $escola->setDescricao($row->descricao);

                $results[] = $escola;
            }
        }
        return $results;
    }
}
