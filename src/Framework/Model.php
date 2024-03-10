<?php

namespace Framework;

use App\Database;
use PDO;

abstract class Model
{
    protected $tableName;

    protected array $errors = [];

    protected function validate(array $data): void
    {
    }

    public function getInsertId(): string
    {
        $pdo = $this->database->getConnection();
        return $pdo->lastInsertId();
    }

    public function __construct(protected Database $database)
    {
    }

    protected function addError(string $name, string $message)
    {
        $this->errors[$name] = $message;
    }

    public function getError(): array
    {
        return $this->errors;
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

    public function create(array $data): bool
    {
        $this->validate($data);

        if (!empty($this->errors)) {
            return false;
        };

        $columns = implode(',', array_keys($data));
        $placeholders = implode(',', array_fill(0, count($data), "?"));

        $pdo = $this->database->getConnection();
        $sql = "INSERT INTO {$this->getTableName()}
                ($columns)
                VALUES ( $placeholders )";
        $stmt = $pdo->prepare($sql);

        $i = 1;
        foreach ($data as $value) {

            $type = match (gettype($value)) {
                "boolean" => PDO::PARAM_BOOL,
                "integer" => PDO::PARAM_INT,
                'NULL' => PDO::PARAM_NULL,
                default => PDO::PARAM_STR
            };

            $stmt->bindValue($i++, $value, $type);
        }

//        $stmt->bindValue(1, $data['name'], PDO::PARAM_STR);
//        $stmt->bindValue(2, $data['description'], PDO::PARAM_STR);

        return $stmt->execute();
    }

    public function update(string $id, array $data): bool

    {
        $this->validate($data);
        if (!empty($this->errors)) {
            return false;
        };

        unset($data['id']);

        $pdo = $this->database->getConnection();
        $sql = "UPDATE {$this->getTableName()}";
        $assignments = array_keys($data);

        array_walk($assignments, function (&$value) {
            $value = "$value = ?";
        });

        $sql .= " SET " . implode(',', $assignments);
        $sql .= " WHERE id = ?";

        $stmt = $pdo->prepare($sql);

        $i = 1;
        foreach ($data as $value) {

            $type = match (gettype($value)) {
                "boolean" => PDO::PARAM_BOOL,
                "integer" => PDO::PARAM_INT,
                'NULL' => PDO::PARAM_NULL,
                default => PDO::PARAM_STR
            };

            $stmt->bindValue($i++, $value, $type);
        }

        $stmt->bindValue($i, $id, PDO::PARAM_INT);

        return $stmt->execute();
    }

    public function delete(string $id): bool
    {
        $sql = "DELETE FROM {$this->getTableName()} WHERE id = :id";
        $pdo = $this->database->getConnection();
        $stmt = $pdo->prepare($sql);
        $stmt->bindValue(":id", $id, PDO::PARAM_INT);

        return $stmt->execute();
    }
}