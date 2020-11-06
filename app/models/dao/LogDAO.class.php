<?php
/**
 * Description of LogDAO
 *
 * @author mrvipaji.ao
 */
class LogDAO {

    private $pdo;

    public function __construct() {
        $this->pdo = Model::conectar();
    }

    public function salvar(Log $log) {
        $this->pdo->beginTransaction();
        try {
            $stmt = $this->pdo->prepare(
                    'INSERT INTO log (utilizador, operacao, data_hora, descricao)'
                    . 'VALUES (:utilizador, :operacao, :data_hora, :descricao)'
            );

            $stmt->bindValue(':utilizador', $log->getUtilizador());
            $stmt->bindValue(':operacao', $log->getOperacao());
            $stmt->bindValue(':data_hora', $log->getDataHora());
            $stmt->bindValue(':descricao', $log->getDescricao());
           
            $stmt->execute();
            $lastId = $this->pdo->lastInsertId();

            $this->pdo->commit();
            return $this->buscarID($lastId);
        } catch (Exception $e) {
                    if ($this->pdo->inTransaction()){
            $this->pdo->rollback();
        }
        }
    }

    public function actualizar(Log $log) {
        $this->pdo->beginTransaction();
        try {
            $stmt = $this->pdo->prepare(
                    'UPDATE  log SET utilizador = :utilizador, operacao = :operacao, data_hora = :data_hora, descricao = :descricao '
                    . ' WHERE id = :id'
            );
            $stmt->bindValue(':id', $log->getId());
            $stmt->bindValue(':utilizador', $log->getUtilizador());
            $stmt->bindValue(':operacao', $log->getOperacao());
            $stmt->bindValue(':data_hora', $log->getDataHora());
            $stmt->bindValue(':descricao', $log->getDescricao());
           
            $stmt->execute();

            $this->pdo->commit();
        } catch (Exception $e) {
                    if ($this->pdo->inTransaction()){
            $this->pdo->rollback();
        }
        }
    }

    public function eliminar(Log $log) {
        $this->pdo->beginTransaction();
        try {
            $stmt = $this->pdo->prepare('DELETE FROM log WHERE id = :id ');
            $stmt->bindValue(':id', $log->getId());

            $stmt->execute();

            $this->pdo->commit();
        } catch (Exception $e) {
                    if ($this->pdo->inTransaction()){
            $this->pdo->rollback();
        }
        }
    }

    public function buscarID($id) {
        $statement = $this->pdo->prepare('SELECT * FROM log WHERE id = :id ');
        $statement->bindValue(':id', $id);
        $statement->execute();

        $retorno = $this->processResults($statement);
        return (!empty($retorno) ? $retorno[0] : null);
    }

    public function listarTodas($orderby = 'id') {
        $statement = $this->pdo->query('SELECT * FROM log ORDER BY ' . $orderby . ' DESC');

        return $this->processResults($statement);
    }

    public function logUtilizador($id) {

        //print_r($id); die;
        $statement = $this->pdo->prepare('SELECT * FROM log WHERE utilizador = :id order by id DESC');
        $statement->bindValue(':id', $id);
        $statement->execute();

        $retorno = $this->processResults($statement);
        return $retorno;
    }

    private function processResults($statement) {
        $results = array();

        if ($statement) {
            while ($row = $statement->fetch(PDO::FETCH_OBJ)) {
                $log = new Log();

                $log->setId($row->id);
                
                #Utilizador
                $utilizadorDAO = new UtilizadorDAO();
                $retorno = $utilizadorDAO->buscarID($row->utilizador);
                $log->setUtilizador(($retorno != null ? $retorno : null));

                $log->setOperacao($row->operacao);
                $log->setDatahora($row->data_hora);
                $log->setDescricao($row->descricao);
               
                $results[] = $log;
            }
        }

        return $results;
    }

}
