<?php

namespace App\Controller;

use App\Model\Product;

class  ProductController
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
}