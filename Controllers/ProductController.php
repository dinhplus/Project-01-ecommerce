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
        // var_dump($_GET["category"]);;

        $pageNumber = $_GET["page"] ?? 1;
        $recordPerPage = 20;
        $productName = $_GET["q"] ?? null;
        $category = isset($_GET["category"])? "(".$_GET["category"].")" : null;
        $brand = isset($_GET["brand"])? "(".$_GET["brand"].")" : null;
        $allProduct = $this->productModel->getAllProduct($pageNumber, $recordPerPage,$productName, $category, $brand );
        $data["products"] = $allProduct;
        $data["pageQtt"] = $allProduct? count($allProduct) : 1;
        $this->set($data);
        $this->render("index");
    }
    public function createProduct()
    {
        $acount = $this->AdminController->checkLogin();
        if(!$acount){
            $this->popup("/dashboard/login","please login to access dashboard!!");
        }
        $categories = $this->productModel->getCategories();
        $brands = $this->productModel->getBrands();
        // var_dump($brands); die();
        $data["categories"] = $categories;
        $data["brands"] = $brands;
        $this->set($data);
        $this->layout = "dashboardLayout";
        $this->render("getCreateProduct");

    }


}