<?php

namespace App\Controller;

use App\Model\Product;
use Framework\Exceptions\PageNotFoundException;
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

        $products = $this->newModel->findAll();

        //loads content before rendering with viewer

        echo $this->viewer->render("shared/header.php", ["title" => "Products"]);
        echo $this->viewer->render("Products/index.php", ["products" => $products]);
    }

    public function show(string $id)
    {
        $product = $this->newModel->findById($id);

        !$product ? throw new PageNotFoundException("Product not found") : null;

        echo $this->viewer->render("shared/header.php", ["title" => "Product $id"]);
        echo $this->viewer->render("Products/show.php", ["id" => $id, "product" => $product]);
    }

    public function showPage(string $title, string $id, string $page)
    {
        echo "$title, $id, $page";
    }
}