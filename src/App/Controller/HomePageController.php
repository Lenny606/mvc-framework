<?php

namespace App\Controller;

use Framework\Controller;
use Framework\PHPTemplateViewer;

class HomePageController extends Controller
{
    public function index()
    {
        //instead object set PHPTemplateViewer in front controller
//        $viewer = new PHPTemplateViewer();
      //  echo $this->viewer->render("shared/header.php", ["title" => "Home"]);
        return $this->view("Home/homepage.php");
    }
}