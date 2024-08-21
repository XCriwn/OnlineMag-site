<?php

namespace database;
use PDO;
class Database{
    public $connection;
    public $statement;
    public function __construct($config, $username = 'root', $password = '')
    {
        $dsn = "mysql:" . http_build_query($config, '', ';'); //127.0.0.1 = localhost host, 3306 port, we can also put user here
        $this->connection = new PDO($dsn, $username, $password, [
            PDO::ATTR_DEFAULT_FETCH_MODE=>PDO::FETCH_ASSOC
        ]);
    }

    public function query($query, $params=[]): static
    {

        $this->statement = $this->connection->prepare($query);

        $this->statement->execute($params);

        return $this; //fetch results as an associative array (no dupes)
    }

    public function find() {
        return $this->statement->fetch();
    }

    public function findAll() {
        return $this->statement->fetchAll();
    }

    public function findOrFail($code = 404)
    {
        $result = $this->find();
        if(!$result) {
            abort($code);
        }

        return $result;
    }
}