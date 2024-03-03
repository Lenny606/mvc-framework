<?php

namespace App\Controller;

use App\Model\Product;
use Framework\Viewer;

class  ProductsController
{
    public function index()
    {

        $newModel = new Product();
        $products = $newModel->getProducts();

        //loads content before rendering with viewer
        $viewer = new Viewer();
        echo $viewer->render("shared/header.php", ["title" => "Products"]);
       echo $viewer->render("Products/index.php", ["products" => $products]);
    }

    public function show(string $id)
    {
        $viewer = new Viewer();
        echo $viewer->render("shared/header.php", ["title" => "Product $id"]);
        echo $viewer->render("Products/show.php", ["id" => $id]);
    }

    public function showPage(string $title, string $id, string $page){
        echo "$title, $id, $page";
    }
}