<?php

namespace App\Controller;

use Framework\Viewer;

class HomePageController
{
    public function index()
    {
        $viewer = new Viewer();
        echo $viewer->render("shared/header.php", ["title" => "Home"]);
        echo $viewer->render("Home/homepage.php");
    }
}