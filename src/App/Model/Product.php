<?php

namespace App\Model;

use PDO;

class Product
{
    private string $dsn = "mysql:host=localhost;dbname=product_db;charset=utf8;port=3306";

    public function getProducts(): array
    {


        $pdo = new PDO($this->dsn, "root", "", [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
        ]);

        $stmt = $pdo->query("select * from product");

        return $products = $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}