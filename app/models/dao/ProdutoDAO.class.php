<?php

/**
 * 
 *
 * @version 1.105
 * @package entity
 */
class ProdutoDAO {

    private $pdo;

    public function __construct() {
        $this->pdo = Model::conectar();
    }

    public function salvar(Produto $produto) {
        $this->pdo->beginTransaction();
        try {
            $stmt = $this->pdo->prepare(
                    'INSERT INTO produto (codigo, nome, descricao, preco, origem, marca, categoria, tipo, estado) VALUES (:codigo, :nome, :descricao, :preco, :origem, :marca, :categoria, :tipo, :estado)'
            );

            $stmt->bindValue(':codigo', $produto->getCodigo());
            $stmt->bindValue(':nome', $produto->getNome());
            $stmt->bindValue(':descricao', $produto->getDescricao());
            $stmt->bindValue(':preco', $produto->getPreco());
            $stmt->bindValue(':origem', $produto->getOrigem());
            $stmt->bindValue(':marca', $produto->getMarca());
            $stmt->bindValue(':categoria', $produto->getCategoria());
            $stmt->bindValue(':tipo', $produto->getTipo());
            $stmt->bindValue(':estado', $produto->getEstado());
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

    public function actualizar(Produto $produto) {
        $this->pdo->beginTransaction();
        try {
            $stmt = $this->pdo->prepare(
                    'UPDATE  produto SET codigo=:codigo, nome=:nome, descricao=:descricao, preco=:preco, origem=:origem, marca=:marca, categoria=:categoria, tipo=:tipo, estado=:estado WHERE id = :id'
            );
            $stmt->bindValue(':id', $produto->getId());
            $stmt->bindValue(':codigo', $produto->getCodigo());
            $stmt->bindValue(':nome', $produto->getNome());
            $stmt->bindValue(':descricao', $produto->getDescricao());
            $stmt->bindValue(':preco', $produto->getPreco());
            $stmt->bindValue(':origem', $produto->getOrigem());
            $stmt->bindValue(':marca', $produto->getMarca());
            $stmt->bindValue(':categoria', $produto->getCategoria());
            $stmt->bindValue(':tipo', $produto->getTipo());
            $stmt->bindValue(':estado', $produto->getEstado());
            $stmt->execute();

            $this->pdo->commit();
        } catch (Exception $e) {
                    if ($this->pdo->inTransaction()){
            $this->pdo->rollback();
        }
            throw $e;
        }
    }

    public function eliminar(Produto $produto) {
        $this->pdo->beginTransaction();
        try {
            $stmt = $this->pdo->prepare(
                    'DELETE  FROM produto WHERE  id = :id'
            );
            
            $stmt->bindValue(':id', $produto->getId());
            $stmt->execute();

            $this->pdo->commit();
        } catch (Exception $e) {
                    if ($this->pdo->inTransaction()){
            $this->pdo->rollback();
        }
            throw $e;
        }
    }

    public function novafoto(Produto $produto) {
        $this->pdo->beginTransaction();
        try {
            $stmt = $this->pdo->prepare(
                    'UPDATE  produto SET foto =:foto WHERE id = :id'
            );
            $stmt->bindValue(':id', $produto->getId());
            $stmt->bindValue(':foto', $produto->getFoto());
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
        $statement = $this->pdo->prepare('SELECT * FROM produto WHERE id = :id ');
        $statement->bindValue(':id', $id);
        $statement->execute();

        $retorno = $this->processResults($statement);
        return (!empty($retorno) ? $retorno[0] : null);
    }

    public function listarTodos($orderby = 'nome') {
        $statement = $this->pdo->query('SELECT * FROM produto ORDER BY ' . $orderby . '');

        return $this->processResults($statement);
    }

    public function listarUltimos($orderby = 'nome') {
        $statement = $this->pdo->query('SELECT * FROM produto ORDER BY ' . $orderby . ' limit 5');

        return $this->processResults($statement);
    }

    private function processResults($statement) {
        $results = array();

        if ($statement) {
            while ($row = $statement->fetch(PDO::FETCH_OBJ)) {
                $permissoes = array();
                $produto = new Produto();

                $produto->setId($row->id);
                $produto->setCodigo($row->codigo);
                $produto->setNome($row->nome);
                $produto->setFoto($row->foto);
                $produto->setDescricao($row->descricao);
                $produto->setPreco($row->preco);
                $produto->setOrigem($row->origem);
                #Marca
                $produto->setMarca((new MarcaDAO())->buscarID($row->marca));
                #Categoria
                $produto->setCategoria((new CategoriaDAO())->buscarID($row->categoria));
                #Tipo
                $produto->setTipo((new TipoDAO())->buscarID($row->tipo));
                $produto->setEstado($row->estado);

                $results[] = $produto;
            }
        }

        return $results;
    }

}
