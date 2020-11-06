<?php

/**
 * 
 *
 * @version 1.105
 * @package entity
 */
class PerfilDAO {

    private $pdo;

    public function __construct() {
        $this->pdo = Model::conectar();
    }

    public function salvar(Perfil $perfil) {
        $this->pdo->beginTransaction();
        try {
            $stmt = $this->pdo->prepare(
                    'INSERT INTO perfil (nome, descricao) VALUES (:nome,  :descricao)'
            );

            $stmt->bindValue(':nome', $perfil->getNome());
            $stmt->bindValue(':descricao', $perfil->getDescricao());
            $stmt->execute();
            $lastId = $this->pdo->lastInsertId();

            //#-Inserção das Permissões 
            /*
            if (!empty($perfil->getPermissoes())) {
                foreach ($perfil->getPermissoes() as $permissao) {
                    $stmt = $this->pdo->prepare(
                            'INSERT INTO perfil_permissao (perfil, permissao) VALUES (:perfil, :permissao)'
                    );
                    $stmt->bindValue(':perfil', $lastId);
                    $stmt->bindValue(':permissao', $permissao->getId());
                    $stmt->execute();
                }
            }*/

            $this->pdo->commit();
            return $this->buscarID($lastId);
        } catch (Exception $e) {
                    if ($this->pdo->inTransaction()){
            $this->pdo->rollback();
        }
            throw $e;
        }
    }

    public function actualizar(Perfil $perfil) {
        $this->pdo->beginTransaction();
        try {
            $stmt = $this->pdo->prepare(
                    'UPDATE  perfil SET nome = :nome,   descricao =:descricao WHERE id = :id'
            );
            $stmt->bindValue(':id', $perfil->getId());
            $stmt->bindValue(':nome', $perfil->getNome());
            $stmt->bindValue(':descricao', $perfil->getDescricao());
            $stmt->execute();

            //Limpa
            $stmt = $this->pdo->prepare(
                    'DELETE  FROM perfil_permissao WHERE  perfil = :perfil'
            );
            $stmt->bindValue(':perfil', $perfil->getId());

            $stmt->execute();

            //#-Inserção das Permissões 
            if (!empty($perfil->getPermissoes())) {
                foreach ($perfil->getPermissoes() as $permissao) {
                    $stmt = $this->pdo->prepare(
                            'INSERT INTO perfil_permissao (perfil, permissao) VALUES (:perfil, :permissao)'
                    );
                    $stmt->bindValue(':perfil', $perfil->getId());
                    $stmt->bindValue(':permissao', $permissao->getId());
                    $stmt->execute();
                }
            }


            $this->pdo->commit();
        } catch (Exception $e) {
                    if ($this->pdo->inTransaction()){
            $this->pdo->rollback();
        }
            throw $e;
        }
    }

    public function eliminar(Perfil $perfil) {
        $this->pdo->beginTransaction();
        try {

            //Limpa
            $stmt = $this->pdo->prepare(
                    'DELETE  FROM perfil_permissao WHERE  perfil = :perfil'
            );
            $stmt->bindValue(':perfil', $perfil->getId());
            $stmt->execute();

            $stmt = $this->pdo->prepare(
                    'DELETE  FROM perfil WHERE  id = :id'
            );
            
            $stmt->bindValue(':id', $perfil->getId());
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
        $statement = $this->pdo->prepare('SELECT * FROM perfil WHERE id = :id ');
        $statement->bindValue(':id', $id);
        $statement->execute();

        $retorno = $this->processResults($statement);
        return (!empty($retorno) ? $retorno[0] : null);
    }

    public function buscarPerfil($perfil = "CLIENTE") {
        $statement = $this->pdo->prepare("SELECT * FROM perfil WHERE nome = :nome ");
        $statement->bindValue(':nome', $perfil);
        $statement->execute();

        $retorno = $this->processResults($statement);
        return (!empty($retorno) ? $retorno[0] : null);
    }

    public function listarTodos($orderby = 'nome') {
        $statement = $this->pdo->query('SELECT * FROM perfil ORDER BY ' . $orderby . '');

        return $this->processResults($statement);
    }

    public function listarPerfilInscricao($orderby = 'nome') {
        $statement = $this->pdo->query('SELECT * FROM perfil WHERE nome LIKE "ADMINISTRADOR" OR nome LIKE "GESTOR" ORDER BY ' . $orderby . '');

        return $this->processResults($statement);
    }

    private function processResults($statement) {
        $results = array();


        if ($statement) {
            while ($row = $statement->fetch(PDO::FETCH_OBJ)) {
                $permissoes = array();
                $perfil = new Perfil();

                $perfil->setId($row->id);
                $perfil->setNome($row->nome);
                $perfil->setDescricao($row->descricao);

                //pesquisa de permissões 
                $st = $this->pdo->prepare("SELECT permissao FROM perfil_permissao WHERE perfil = :perfil ");
                $st->bindValue(':perfil', $perfil->getId());
                $st->execute();
                while ($r = $st->fetch(PDO::FETCH_OBJ)) {
                    $permissao = (new PermissaoDAO())->buscarID($r->permissao);
                    if ($permissao != null) {
                        $permissoes[] = $permissao;
                    }
                }
                $perfil->setPermissoes($permissoes);
                $results[] = $perfil;
            }
        }

        return $results;
    }

}
