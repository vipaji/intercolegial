<?php
/**
 * @version 1.105
 * @package entity
 */
class ClienteDAO {

    private $pdo;

    public function __construct() {
        $this->pdo = Model::conectar();
    }

    public function salvar(Cliente $cliente) {
        $this->pdo->beginTransaction();
        try {
            $stmt = $this->pdo->prepare(
                    'INSERT INTO cliente (numero, nome, email, telefone, data_registo) VALUES (:numero, :nome, :email, :telefone, :data_registo)'
            );

            $stmt->bindValue(':numero', $cliente->getNumero());
            $stmt->bindValue(':nome', $cliente->getNome());
            $stmt->bindValue(':email', $cliente->getEmail());
            $stmt->bindValue(':telefone', $cliente->getTelefone());
            $stmt->bindValue(':data_registo', $cliente->getDataRegisto());
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

    public function actualizar(Cliente $cliente) {
        $this->pdo->beginTransaction();
        try {
            $stmt = $this->pdo->prepare(
                    'UPDATE  cliente SET nome=:nome, email=:email, telefone=:telefone WHERE id=:id'
            );
            $stmt->bindValue(':id', $cliente->getId());
            $stmt->bindValue(':nome', $cliente->getNome());
            $stmt->bindValue(':email', $cliente->getEmail());
            $stmt->bindValue(':telefone', $cliente->getTelefone());
            $stmt->execute();

            $this->pdo->commit();
        } catch (Exception $e) {
                    if ($this->pdo->inTransaction()){
            $this->pdo->rollback();
        }
            throw $e;
        }
    }

    public function eliminar(Cliente $cliente) {
        $this->pdo->beginTransaction();
        try {
            $stmt = $this->pdo->prepare(
                    'DELETE  FROM cliente WHERE  id = :id'
            );
            $stmt->bindValue(':id', $cliente->getId());

            $stmt->execute();

            $this->pdo->commit();
        } catch (Exception $e) {
                    if ($this->pdo->inTransaction()){
            $this->pdo->rollback();
        }
            throw $e;
        }
    }

    public function ultimoCliente() {
        $statement = $this->pdo->query('SELECT * FROM cliente ORDER BY id DESC limit 1');
        $retorno = $this->processResults($statement);
        return (!empty($retorno) ? $retorno[0] : null);
    }

    public function buscarID($id) {
        $statement = $this->pdo->prepare('SELECT * FROM cliente WHERE id = :id ');
        $statement->bindValue(':id', $id);
        $statement->execute();

        $retorno = $this->processResults($statement);
        return (!empty($retorno) ? $retorno[0] : null);
    }
    
    public function listarTodos($orderby = 'nome') {
        $statement = $this->pdo->query('SELECT * FROM cliente ORDER BY ' . $orderby . '');

        return $this->processResults($statement);
    }

    private function processResults($statement) {
        $results = array();

        if ($statement) {
            while ($row = $statement->fetch(PDO::FETCH_OBJ)) {
                $cliente = new Cliente();

                $cliente->setId($row->id);
                $cliente->setNumero($row->numero);
                $cliente->setNome($row->nome);
                $cliente->setEmail($row->email);
                $cliente->setTelefone($row->telefone);
                $cliente->setDataRegisto($row->data_registo);

                $results[] = $cliente;
            }
        }

        return $results;
    }

}
