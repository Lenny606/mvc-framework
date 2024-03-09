<?php

namespace App;

use PDO;

class Database
{

    private ?PDO $pdo = null;

    public function __construct(
        private string $host,
        private string $dbName,
        private string $dbUser,
        private string $dbPassword = "",
    )
    {

    }

    public function getConnection(): PDO
    {

        if ($this->pdo === null) {
            $dsn = "mysql:host={$this->host};dbname={$this->dbName};charset=utf8;port=3306";

            $this->pdo = new PDO($dsn, $this->dbUser, $this->dbPassword, [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
            ]);
        }

        return $this->pdo;

    }
}