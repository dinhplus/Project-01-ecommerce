<?php

use Controller\BaseController as Controller;

require_once(ROOT . "Models/Product.php");
require_once(ROOT . "Models/Order.php");
require_once(ROOT . "Models/Customer.php");
require_once(ROOT . "Controllers/AdminController.php");

class OrderController extends Controller
{
    public function __construct()
    {
        $this->layout = "dashboardLayout";
        $this->adminModel = new Admin();
        $this->productModel = new Product();
        $this->orderModel = new Order();

        $this->AdminController = new AdminController();
    }
    public function index()
    {
        $acount = $this->AdminController->checkLogin();
        if (!$acount) {
            $this->popup("/dashboard/login", "please login to access dashboard!!");
        }
        $pageNumber = $_GET["page"] ?? 1;
        $recordPerPage = 20;
        $oid = $_GET["oid"] ?? null;
        $cid = $_GET["cid"] ?? null;
        $descTotalPrice = $_GET["descTotalPrice"] ?? null;
        $getLastOrder = $_GET["getLastOrder"] ?? null;

        $allOrders = $this->orderModel->getAllOrder($pageNumber, $recordPerPage, $descTotalPrice, $getLastOrder, $cid, $oid);
    }
}
