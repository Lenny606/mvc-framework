<?php

namespace App\Controller;

use App\Model\Product;
use Framework\Controller;
use Framework\Exceptions\PageNotFoundException;
use Framework\Request;
use Framework\PHPTemplateViewer;

class  ProductsController extends Controller
{


    public function __construct(
//        private PHPTemplateViewer  $viewer,
        private Product $newModel
    )
    {
    }

    public function index()
    {

        $products = $this->newModel->findAll();

        //loads content before rendering with viewer

//        echo $this->viewer->render("shared/header.php", );
        echo $this->viewer->render("Products/index.mvc.php", [
            "title" => "Products",
            "products" => $products,
            "total" => $this->newModel->getTotalCount()
        ]);
    }

    public function show(string $id)
    {
        $product = $this->getProduct($id);

        echo $this->viewer->render("shared/header.php", ["title" => "Product $id"]);
        echo $this->viewer->render("Products/show.php", ["id" => $id, "product" => $product]);
    }

    public function showPage(string $title, string $id, string $page)
    {
        echo "$title, $id, $page";
    }


    public function new()
    {
        echo $this->viewer->render("shared/header.php", ["title" => "New Product"]);
        echo $this->viewer->render("Products/new.php", []);
    }

    public function create()
    {
        $data = [
            "name" => $this->request->post["name"],
            "description" => empty($this->request->post["description"]) ? null : $this->request->post["description"],
        ];

        if ($this->newModel->create($data)) {
            header("Location: /products/{$this->newModel->getInsertId()}/show");
            exit;
        } else {
            echo $this->viewer->render("shared/header.php", ["title" => "New Product"]);
            echo $this->viewer->render("Products/new.php", [
                'errors' => $this->newModel->getError(),
                'product' => $data
            ]);
        }
    }

    public function edit(string $id)
    {
        $product = $this->getProduct($id);

        echo $this->viewer->render("shared/header.php", ["title" => "Edit Product $id"]);
        echo $this->viewer->render("Products/edit.php", ["id" => $id, "product" => $product]);
    }

    public function update($id)
    {
        $product = $this->getProduct($id);

        $product["name"] = $this->request->post["name"];
        $product["description"] = empty($this->request->post["description"]) ? null : $this->request->post["description"];

        if ($this->newModel->update($id, $product)) {
            header("Location: /products/{$id}/show");
            exit;
        } else {
            echo $this->viewer->render("shared/header.php", ["title" => "Edit Product"]);
            echo $this->viewer->render("Products/edit.php", [
                'errors' => $this->newModel->getError(),
                'product' => $product
            ]);
        }
    }

    private function getProduct(string $id): array
    {
        $product = $this->newModel->findById($id);
        !$product ? throw new PageNotFoundException("Product not found") : null;
        return $product;
    }

    public function delete(string $id)
    {
        $product = $this->getProduct($id);

        echo $this->viewer->render("shared/header.php", ["title" => "Delete Product"]);
        echo $this->viewer->render("Products/delete.php", [
            'errors' => $this->newModel->getError(),
            'product' => $product
        ]);
    }

    public function destroy($id) {
        $product = $this->getProduct($id);


            $this->newModel->delete($id);

            header("Location: /products/index");
            exit;

    }
}