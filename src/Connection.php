<?php

class Connection {
    public $connection;
    public $path;

    public function __construct()
    {
        $this->path = realpath(__ROOT__ . '/database/db.sqlite3');
        $this->connection = new PDO(sprintf('sqlite:%s',$this->path));
        $this->connection->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
    }
}