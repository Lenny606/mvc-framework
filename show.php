<?php
//NOT A MVC PRINCIPLES
require "./src/Controller/ProductController.php";

$indexController = new \Framework\App\controller\ProductController();

$indexController->show();