<?php

namespace App\Controller;

use App\Model\Product;
use Framework\Viewer;

class  ProductsController
{

    public function __construct(
        private Viewer $viewer,
        private Product $newModel
    )
    {
    }

    public function index()
    {

        $products = $this->newModel->getProducts();

        //loads content before rendering with viewer

        echo $this->viewer->render("shared/header.php", ["title" => "Products"]);
        echo $this->viewer->render("Products/index.php", ["products" => $products]);
    }

    public function show(string $id)
    {

        echo $this->viewer->render("shared/header.php", ["title" => "Product $id"]);
        echo $this->viewer->render("Products/show.php", ["id" => $id]);
    }

    public function showPage(string $title, string $id, string $page)
    {
        echo "$title, $id, $page";
    }
}