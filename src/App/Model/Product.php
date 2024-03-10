<?php

namespace App\Model;

use Framework\Model;
use PDO;

class Product extends Model
{
    //everything inherited from Model

    //overrides
    protected $tableName = "product";


    public function validate(array $data): void
    {
        if (empty($data["name"])) {
            $this->addError("name", "missing name");
        }

//        return empty($this->errors);
    }

    public function getTotalCount(): int
    {
        $sql = "SELECT COUNT(*) AS count FROM product";
        $pdo = $this->database->getConnection();
        $stmt = $pdo->query($sql);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return (int)$row['count'];
    }
}