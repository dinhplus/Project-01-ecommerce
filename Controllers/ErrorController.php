<?php

use Controller\BaseController as Controller;
require_once(ROOT . "Models/Product.php");
class ErrorController extends  Controller
{
    public function __construct()
    {
        $this->layout = "Error";
        $this->productModel = new Product();
    }
    public function notFound()
    {
        $this->render("404");
    }
}
