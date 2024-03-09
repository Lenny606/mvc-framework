<?php

namespace Framework;

use App\Database;
use PDO;

abstract class Model
{
    protected $tableName;

    public function __construct(private Database $database)
    {
    }

    private function getTableName(): string
    {
        if ($this->tableName !== null) {
            return $this->tableName;
        }

        $parts = explode("\\", $this::class);
        return strtolower(array_pop($parts));
    }

    public function findAll(): array|bool
    {

        $pdo = $this->database->getConnection();

        $sql = "select * from {$this->getTableName()}";

        $stmt = $pdo->query($sql);

        return $products = $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function findById(string $id): array|bool
    {

        $pdo = $this->database->getConnection();

        $sql = "SELECT * FROM {$this->getTableName()} WHERE id = :id";
        $stmt = $pdo->prepare($sql);
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);

    }
}