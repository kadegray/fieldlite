<?php

class Database
{
    private $serverName = 'localhost';
    private $userName = 'root';
    private $password = 'root';

    public function __construct()
    {
        $connection = new mysqli(
            $this->serverName,
            $this->userName,
            $this->password
        );

        if ($connection->connect_error) {
            die('Database connection failed: ' . $connection->connect_error);
        }
    }
}
