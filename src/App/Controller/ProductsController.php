<?php

namespace App\Controller;

use App\Model\Product;

class  ProductsController
{
    public function index()
    {

        $newModel = new Product();
        $products = $newModel->getProducts();

        require "./views/products_index.php";
    }

    public function show()
    {
//        require "./src/Model/Product.php";

        $newModel = new Product();
        $products = $newModel->getProducts();

        require "./views/products_show.php";
    }

    public function showPage(string $title, string $id, string $page){
        echo "$title, $id, $page";
    }
}