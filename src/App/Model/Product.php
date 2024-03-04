<?php

namespace App\Model;

use App\Database;
use PDO;

class Product
{

    public function __construct(private Database $database)
    {
    }

    public function getProducts(): array
    {

        $pdo = $this->database->getConnection();

        $stmt = $pdo->query("select * from product");

        return $products = $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}