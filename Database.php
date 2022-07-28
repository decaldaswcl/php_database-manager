<?php

namespace decaldaswcl\DatabaseManager;

use PDO;
use PDOException;

class Database
{
  /**
   * Database connection host
   * @var string
   */
    private static $host;

  /**
   * Database name
   * @var string
   */
    private static $name;

  /**
   * Database user
   * @var string
   */
    private static $user;

  /**
   * Database password
   * @var string
   */
    private static $pass;

  /**
   * Database port
   * @var integer
   */
    private static $port;

  /**
   * Table name
   * @var string
   */
    private $table;

  /**
   * Database connection instance
   * @var PDO
   */
    private $connection;

  /**
   * Define table and instance and connection
   * @param string $table
   */
    public function __construct($table = null)
    {
        $this->table = $table;
        $this->setConnection();
    }

  /**
   * Method responsible for configuring the class
   * @param  string  $host
   * @param  string  $name
   * @param  string  $user
   * @param  string  $pass
   * @param  integer $port
   */
    public static function config($host, $name, $user, $pass, $port = 3306)
    {
        self::$host = $host;
        self::$name = $name;
        self::$user = $user;
        self::$pass = $pass;
        self::$port = $port;
    }

  /**
   * Method responsible for creating a connection to the database
   */
    private function setConnection()
    {
        try {
            $this->connection = new PDO('mysql:host=' . self::$host . ';dbname=' . self::$name . ';port=' . self::$port, self::$user, self::$pass);
            $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            die('ERROR: ' . $e->getMessage());
        }
    }

  /**
   * Method responsible for executing queries inside the database
   * @param  string $query
   * @param  array  $params
   * @return PDOStatement
   */
    public function execute($query, $params = [])
    {
        try {
            $statement = $this->connection->prepare($query);
            $statement->execute($params);
            return $statement;
        } catch (PDOException $e) {
            die('ERROR: ' . $e->getMessage());
        }
    }

  /**
   * Method responsible for insert data into the database
   * @param  array $values [ field => value ]
   * @return integer ID inserido
   */
    public function insert($values)
    {

        $fields = array_keys($values);
        $binds  = array_pad([], count($fields), '?');

        $query = 'INSERT INTO ' . $this->table . ' (' . implode(',', $fields) . ') VALUES (' . implode(',', $binds) . ')';

        $this->execute($query, array_values($values));

        return $this->connection->lastInsertId();
    }

  /**
   * Method responsible for executing a query in the database
   * @param  string $where
   * @param  string $order
   * @param  string $limit
   * @param  string $fields
   * @return PDOStatement
   */
    public function select($where = null, $order = null, $limit = null, $fields = '*')
    {

        $where = strlen($where) ? 'WHERE ' . $where : '';
        $order = strlen($order) ? 'ORDER BY ' . $order : '';
        $limit = strlen($limit) ? 'LIMIT ' . $limit : '';

        $query = 'SELECT ' . $fields . ' FROM ' . $this->table . ' ' . $where . ' ' . $order . ' ' . $limit;

        return $this->execute($query);
    }

  /**
   * Method responsible for performing updates on the database
   * @param  string $where
   * @param  array $values [ field => value ]
   * @return boolean
   */
    public function update($where, $values)
    {

        $fields = array_keys($values);

        $query = 'UPDATE ' . $this->table . ' SET ' . implode('=?,', $fields) . '=? WHERE ' . $where;

        $this->execute($query, array_values($values));

        return true;
    }

  /**
   * Method responsible for deleting database data
   * @param  string $where
   * @return boolean
   */
    public function delete($where)
    {

        $query = 'DELETE FROM ' . $this->table . ' WHERE ' . $where;

        $this->execute($query);

        return true;
    }
}
