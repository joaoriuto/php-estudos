<?php

namespace App\Db;

use \PDO;
use \PDOException;

class Database {

    /**
     * Host de conexão com o banco de dados
     * @var string
     */
    const HOST = 'localhost';

    /**
     *  Nome do banco de dados
     * @var string
     */
    const NAME = 'wdev_feat_riuto_vagas';

    /**
     * Usuário do banco de dados
     * @var string
     */
    const USER = 'root';

    /**
     * Senha do banco de dados
     * @var string
     */
    const PASS = 'toor';

    /**
     * Nome da tabela a ser manipulada
     * @var string
     */
     private $table;

    /**
     * Instância do PDO
     * @var PDO
     */
    private $connection;

    /**
     *  Define a tabela e instância e conexão
     * @param string
     */
    public function __construct($table = null) {
        $this->table = $table;
        $this->setConnection();
    }

    /**
     *  Método responsável por criar uma conexão com o banco de dados
     */
    private function setConnection() {
        try {
            $this->connection = new PDO('mysql:host='.self::HOST.';dbname='.self::NAME, self::USER, self::PASS);
            $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        }catch(PDOException $e) {
            die('Erro: '.$e->getMessage()); //Não usar em produção (Salvar em log)
        }
    }

    /**
     * Método responsável por executar queries dentro do banco de dados
     * @param string $query
     * @param array $params
     * @return PDOStatement
     */
    public function execute($query, $params = []) {
        try{
            $statement = $this->connection->prepare($query);
            $statement->execute($params);
            return $statement;
        }catch(PDOException $e) {
            die('Erro: '.$e->getMessage()); //Não usar em produção (Salvar em log)
        }
    }



    /**
     * Método responsável por inserir os dados no banco
     * @param array $values [ field => value]
     * @return interger ID inserido
     * @return integer
     */
    public function insert($values) {
        // Dados da query
        $fields = array_keys($values);
        $binds = array_pad([], count($fields),'?');

        // Monta a query
        $query = 'INSERT INTO '.$this->table.' ('.implode(',',$fields).') VALUES ('.implode(',',$binds).')';
        
        //Executa a query
        $this->execute($query, array_values($values));

        //Retorna o ID inserido
        return $this->connection->lastInsertId();
    }

    /**
     *  Método responsável por executar uma consulta no banco de dados
     * @param string $where
     * @param string $order
     * @param string $limit
     * @return PDOStatement
     */
    public function select($where = null, $order = null, $limit = null, $fields = '*') {
        $where = strlen($where) ? 'WHERE '.$where : '';
        $order = strlen($order) ? 'ORDER BY '.$order : '';
        $limit = strlen($limit) ? 'LIMIT '.$limit : '';

        // Monta a query
        $query = 'SELECT '.$fields.' FROM '.$this->table.' '.$where.' '.$order.' '.$limit;

        //Executa a query
        return $this->execute($query);
    }
    
    /**
   * Método responsável por executar atualizações no banco de dados
   * @param  string $where
   * @param  array $values [ field => value ]
   * @return boolean
   */
  public function update($where,$values){
    //DADOS DA QUERY
    $fields = array_keys($values);

    //MONTA A QUERY
    $query = 'UPDATE '.$this->table.' SET '.implode('=?,',$fields).'=? WHERE '.$where;

    //EXECUTAR A QUERY
    $this->execute($query,array_values($values));

    //RETORNA SUCESSO
    return true;
  }

  /**
   * Método responsável por excluir dados do banco
   * @param  string $where
   * @return boolean
   */
  public function delete($where){
    //MONTA A QUERY
    $query = 'DELETE FROM '.$this->table.' WHERE '.$where;

    //EXECUTA A QUERY
    $this->execute($query);

    //RETORNA SUCESSO
    return true;
  }

}

?>