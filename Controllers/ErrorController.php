<?php

use Controller\BaseController as Controller;
require_once(ROOT . "Models/Product.php");
class ErrorController extends  Controller
{
    public function __construct()
    {
        $_POST = $this->secure_form($_POST);
        $_GET = $this->secure_form($_GET);
        $_REQUEST = $this->secure_form($_REQUEST);
        $this->layout = "Error";
        $this->productModel = new Product();
    }
    public function notFound()
    {
        $this->render("404");
    }
}
