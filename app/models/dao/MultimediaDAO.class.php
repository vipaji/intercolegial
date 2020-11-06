<?php

/**
 * 
 *
 * @version 1.105
 * @package entity
 */
class MultimediaDAO {

    private $pdo;

    public function __construct() {
        $this->pdo = Model::conectar();
    }

    public function salvar(Multimedia $multimedia) {
        $this->pdo->beginTransaction();
        try {
            $stmt = $this->pdo->prepare(
                    'INSERT INTO multimedia (ficheiro, tipo, descricao, tabela, chave, data, utilizador) VALUES (:ficheiro, :tipo, :descricao, :tabela, :chave, :data, :utilizador)'
            );

            $stmt->bindValue(':ficheiro', $multimedia->getFicheiro());
            $stmt->bindValue(':tipo', $multimedia->getTipo());
            $stmt->bindValue(':descricao', $multimedia->getDescricao());
            $stmt->bindValue(':tabela', $multimedia->getTabela());
            $stmt->bindValue(':chave', $multimedia->getChave());
            $stmt->bindValue(':data', $multimedia->getData());
            $stmt->bindValue(':utilizador', $multimedia->getUtilizador());

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

    public function actualizar(Multimedia $multimedia) {
        $this->pdo->beginTransaction();
        try {
            $stmt = $this->pdo->prepare(
                    'UPDATE  multimedia SET ficheiro = :ficheiro,   tipo =:tipo, descricao=:descricao, tabela=:tabela, chave=:chave, data=:data WHERE id = :id'
            );
            $stmt->bindValue(':id', $multimedia->getId());
            $stmt->bindValue(':ficheiro', $multimedia->getFicheiro());
            $stmt->bindValue(':tipo', $multimedia->getTipo());
            $stmt->bindValue(':descricao', $multimedia->getDescricao());
            $stmt->bindValue(':tabela', $multimedia->getTabela());
            $stmt->bindValue(':chave', $multimedia->getChave());
            $stmt->bindValue(':data', $multimedia->getData());

            $stmt->execute();

            $this->pdo->commit();
        } catch (Exception $e) {
            if ($this->pdo->inTransaction()) {
                $this->pdo->rollback();
            }
        }
    }

    public function eliminar(Multimedia $multimedia) {
        $this->pdo->beginTransaction();
        try {
            $stmt = $this->pdo->prepare(
                    'DELETE  FROM multimedia WHERE  id = :id'
            );
            $stmt->bindValue(':id', $multimedia->getId());
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
     *  @description consulta na base de dados o registo multimedia através do ID 
     *  @param integer $id
     *  @return multimedia
     */
    public function buscarID($id) {
        $statement = $this->pdo->prepare('SELECT * FROM multimedia WHERE id = :id ');
        $statement->bindValue(':id', $id);
        $statement->execute();

        $retorno = $this->processResults($statement);
        return (!empty($retorno) ? $retorno[0] : null);
    }

    /**
     *  @name: FindByTabelaChave
     *  @description consulta na base de dados o registo multimedia através do ID 
     *  @param integer $id
     *  @return array(): multimedia
     */
    public function FindByTabelaChave($tabela, $chave) {
        $statement = $this->pdo->prepare('SELECT * FROM multimedia WHERE chave = :chave  AND tabela = :tabela ORDER BY data DESC');
        $statement->bindValue(':chave', $chave);
        $statement->bindValue(':tabela', $tabela);
        $statement->execute();

        return $this->processResults($statement);
    }

    /**
     *  @name: FindByChave
     *  @description consulta na base de dados o registo multimedia através do ID 
     *  @param integer tabela
     *  @return array(): multimedia
     */
    public function FindByModelos($tabela) {
        $statement = $this->pdo->prepare('SELECT * FROM multimedia WHERE tabela = :tabela ORDER BY data DESC');
        $statement->bindValue(':tabela', $tabela);
        $statement->execute();

        return $this->processResults($statement);
    }

    public function findCasasModeloPorProjecto($tabela, $projecto = null) {

        if ($projecto != null) {
            $sqlProjecto = 'SELECT * FROM multimedia INNER JOIN casa_modelo cm ON multimedia.chave = cm.id AND cm.projecto = ' . $projecto . ' WHERE tabela = ' . $tabela;
        } else {
            $sqlProjecto = 'SELECT * FROM multimedia INNER JOIN casa_modelo cm ON multimedia.chave = cm.id  WHERE tabela = ' . $tabela . ' LIMIT 12';
        }
        $sql = $sqlProjecto;
        $statement = $this->pdo->query($sql);
        return $this->processResults($statement);
    }

    public function findCasasByModeloPorProjecto($tabela, $projecto, $modelo) {
        $sql = 'SELECT * FROM multimedia INNER JOIN casa_modelo cm ON multimedia.chave = cm.id AND cm.projecto = ' . $projecto . ' WHERE tabela = ' . $tabela.' AND cm.id = '.$modelo;
        $statement = $this->pdo->query($sql);
        return $this->processResults($statement);
    }

    public function FindBy($params) {
        $statement = $this->pdo->prepare('SELECT * FROM multimedia WHERE chave = :chave  AND tabela = :tabela');

        foreach ($params as $key => $value) {
            $statement->bindValue(':' . $key, $value);
        }
        $statement->execute();

        return $this->processResults($statement);
    }

    public function mostrarFotos($orderby = 'entidade') {
        $statement = $this->pdo->query('SELECT * FROM multimedia ORDER BY ' . $orderby . '');

        return $this->processResults($statement);
    }

    private function processResults($statement) {
        $results = array();

        if ($statement) {
            while ($row = $statement->fetch(PDO::FETCH_OBJ)) {
                $multimedia = new Multimedia();

                $multimedia->setId($row->id);
                $multimedia->setFicheiro($row->ficheiro);
                $multimedia->setTipo($row->tipo);
                $multimedia->setDescricao($row->descricao);
                $multimedia->setTabela($row->tabela);
                $multimedia->setChave($row->chave);
                $multimedia->setData($row->data);

                #Utilizador
                $utilizadorDAO = new UtilizadorDAO();
                $multimedia->setUtilizador($utilizadorDAO->buscarID($row->utilizador));

                $results[] = $multimedia;
            }
        }

        return $results;
    }

}
