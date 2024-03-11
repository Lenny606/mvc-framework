<?php

namespace App\Controller;

use App\Model\Product;
use Framework\Controller;
use Framework\Exceptions\PageNotFoundException;
use Framework\Request;
use Framework\PHPTemplateViewer;
use Framework\Response;

class  ProductsController extends Controller
{


    public function __construct(
//        private PHPTemplateViewer  $viewer,
        private Product $newModel
    )
    {
    }

    public function index(): Response
    {

        $products = $this->newModel->findAll();

        //loads content before rendering with viewer
//        echo $this->viewer->render("shared/header.php", );
        return $this->view("Products/index.mvc.php", [
            "title" => "Products",
            "products" => $products,
            "total" => $this->newModel->getTotalCount()
        ]);
    }

    public function show(string $id): Response
    {
        $product = $this->getProduct($id);

        //  echo $this->viewer->render("shared/header.php", ["title" => "Product $id"]);
        return $this->view("Products/show.mvc.php", ["id" => $id, "product" => $product]);
    }

    public function showPage(string $title, string $id, string $page)
    {
        echo "$title, $id, $page";
    }


    public function new(): Response
    {
        // echo $this->viewer->render("shared/header.php", ["title" => "New Product"]);
        return $this->view("Products/new.mvc.php", ["title" => "New Product"]);
    }

    public function create(): Response
    {
        $data = [
            "name" => $this->request->post["name"],
            "description" => empty($this->request->post["description"]) ? null : $this->request->post["description"],
        ];

        if ($this->newModel->create($data)) {
            return $this->redirect("/products/{$this->newModel->getInsertId()}/show");
        } else {
            //  echo $this->viewer->render("shared/header.php", ["title" => "New Product"]);
            return $this->view("Products/new.mvc.php", [
                "title" => "New Product",
                'errors' => $this->newModel->getError(),
                'product' => $data
            ]);
        }
    }

    public function edit(string $id): Response
    {
        $product = $this->getProduct($id);

        //  echo $this->viewer->render("shared/header.php", ["title" => "Edit Product $id"]);
        return $this->view("Products/edit.mvc.php", ["id" => $id, "product" => $product]);
    }

    public function update($id): Response
    {
        $product = $this->getProduct($id);

        $product["name"] = $this->request->post["name"];
        $product["description"] = empty($this->request->post["description"]) ? null : $this->request->post["description"];

        if ($this->newModel->update($id, $product)) {
            return $this->redirect("/products/{$id}/show");

        } else {
//            echo $this->viewer->render("shared/header.php", ["title" => "Edit Product"]);
            return $this->view("Products/edit.mvc.php", [
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

    public function delete(string $id): Response
    {
        $product = $this->getProduct($id);

        // echo $this->viewer->render("shared/header.php", ["title" => "Delete Product"]);
        return $this->view("Products/delete.mvc.php", [
            'errors' => $this->newModel->getError(),
            'product' => $product
        ]);
    }

    public function destroy($id): Response
    {
        $product = $this->getProduct($id);

        $this->newModel->delete($id);

        return $this->redirect("/products/index");
    }
}