<?php
use Controller\BaseController as Controller;
require_once(ROOT."Models/Product.php");
require_once(ROOT."Controllers/AdminController.php");

class ProductController extends Controller{
    public function __construct(){
        $this->layout = "dashboardLayout";
        $this->adminModel = new Admin();
        $this->productModel = new Product();
        $this->AdminController = new AdminController();
    }
    public function index(){
        $acount = $this->AdminController->checkLogin();
        // var_dump($acount);
        if(!$acount){
            $this->popup("/dashboard/login","please login to access dashboard!!");
        }
        $allProduct = $this->Product->getAllProduct();
        $data = [];
        $this->set($data);
        $this->render("index");
    }



}