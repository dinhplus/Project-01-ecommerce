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
        try {
            $acount = $this->AdminController->checkLogin();
            if (!$acount) {
                $this->popup("/dashboard/login", "please login to access dashboard!!");
            }
            $pageNumber = $_GET["page"] ?? 1;
            $recordPerPage = PAGINATE;
            $status_id = $_GET["status_id"] ?? null;
            $oid = $_GET["oid"] ?? null;
            $cid = $_GET["cid"] ?? null;
            $descTotalPrice = $_GET["descTotalPrice"] ?? null;
            $getLastOrder = $_GET["getLastOrder"] ?? null;

            $allOrders = $this->orderModel->getAllOrder(
                $pageNumber,
                $recordPerPage,
                $descTotalPrice,
                $status_id,
                $getLastOrder,
                $cid,
                $oid
            );
            $data = [];
            $data["orders"] = array_slice($allOrders, ($pageNumber - 1) * $recordPerPage, $recordPerPage) ?? [];
            foreach ($data["orders"] as &$order) {
                $order["products"] = $this->orderModel->getOrderDetail($order["id"]);
            }
            unset($order);

            $data["pageQtt"] = $allOrders ? ceil(count($allOrders) / $recordPerPage) : 1;
            $this->set($data);
            $this->render("index");
        } catch (Exception $e) {
            dd($e);
        }
    }
    public function showOrderDetail()
    {
        try {
            $acount = $this->AdminController->checkLogin();
            if (!$acount) {
                $this->popup("/dashboard/login", "please login to access dashboard!!");
            }
            $oid = $_GET["oid"] ?? 1;
            $order = $this->orderModel->getOrderById($oid) ?? null;
            if ($order) {
                $order["products"] = $this->orderModel->getOrderDetail($oid);
                $data["order"] = $order;
                $data["enableSearch"] = false;
                $this->set($data);
                $this->render("orderDetail");
            } else {
                $this->popup("/dashboard/order-manager", "This order do not exist");
            }
            // pd($data);
        } catch (Exception $e) {
            dd($e);
        }
    }
    public function changeOrderStatus()
    {
        try {
            $acount = $this->AdminController->checkLogin();
            if (!$acount) {
                $this->popup("/dashboard/login", "please login to access dashboard!!");
            }
            $next_status = $_POST["status_id"];
            $oid = $_POST["oid"];       
            $note = $_POST["change_status_note"] ?? null;
            $order = $this->orderModel->getOrderById($oid);
            if ($next_status > $order["status_id"] && $order["status_id"] <= 3) {
                $onUpdate = $this->orderModel->updateOrderStatus($oid, $next_status, $acount["id"], $note);
                if ($onUpdate) {
                    $this->popup("/dashboard/order-manager", "The order status has been updated! <br> Click ok then redirect Dashboard");
                }
            } else if ($order["status_id"] > 3) {
                $data["message"] = "This order status is the lastest status. You cannot modify!";
                $data["order"] = $order;
                dd($data);
            } else {
                $data["message"] = "Can not change this order status";
                $data["order"] = $order;
                dd($data);
            }
        } catch (Exception $e) {
            dd($e);
        }
    }
    public function getPendingOrder()
    {
        try {
            $acount = $this->AdminController->checkLogin();
            if (!$acount) {
                $this->popup("/dashboard/login", "please login to access dashboard!!");
            }
            $pageNumber = $_GET["page"] ?? 1;
            $recordPerPage = PAGINATE;
            $status_id = 1;
            $oid = $_GET["oid"] ?? null;
            $cid = $_GET["cid"] ?? null;
            $descTotalPrice = $_GET["descTotalPrice"] ?? null;
            $getLastOrder = $_GET["getLastOrder"] ?? null;

            $allOrders = $this->orderModel->getAllOrder(
                $pageNumber,
                $recordPerPage,
                $descTotalPrice,
                $status_id,
                $getLastOrder,
                $cid,
                $oid
            );
            $data = [];
            $data["orders"] = array_slice($allOrders, ($pageNumber - 1) * $recordPerPage, $recordPerPage) ?? [];
            foreach ($data["orders"] as &$order) {
                $order["products"] = $this->orderModel->getOrderDetail($order["id"]);
            }
            unset($order);

            $data["pageQtt"] = $allOrders ? ceil(count($allOrders) / $recordPerPage) : 1;
            $this->set($data);
            $this->render("index");
        } catch (Exception $e) {
            dd($e);
        }
    }

    public function getCancelledOrder()
    {
        try {
            $acount = $this->AdminController->checkLogin();
            if (!$acount) {
                $this->popup("/dashboard/login", "please login to access dashboard!!");
            }
            $pageNumber = $_GET["page"] ?? 1;
            $recordPerPage = PAGINATE;
            $status_id = '6,5';
            $oid = $_GET["oid"] ?? null;
            $cid = $_GET["cid"] ?? null;
            $descTotalPrice = $_GET["descTotalPrice"] ?? null;
            $getLastOrder = $_GET["getLastOrder"] ?? null;

            $allOrders = $this->orderModel->getAllOrder(
                $pageNumber,
                $recordPerPage,
                $descTotalPrice,
                $status_id,
                $getLastOrder,
                $cid,
                $oid
            );
            $data = [];
            $data["orders"] = array_slice($allOrders, ($pageNumber - 1) * $recordPerPage, $recordPerPage) ?? [];
            foreach ($data["orders"] as &$order) {
                $order["products"] = $this->orderModel->getOrderDetail($order["id"]);
            }
            unset($order);

            $data["pageQtt"] = $allOrders ? ceil(count($allOrders) / $recordPerPage) : 1;
            $this->set($data);
            $this->render("index");
        } catch (Exception $e) {
            dd($e);
        }
    }
    public function getCompletedOrder()
    {
        try {
            $acount = $this->AdminController->checkLogin();
            if (!$acount) {
                $this->popup("/dashboard/login", "please login to access dashboard!!");
            }
            $pageNumber = $_GET["page"] ?? 1;
            $recordPerPage = PAGINATE;
            $status_id = '4';
            $oid = $_GET["oid"] ?? null;
            $cid = $_GET["cid"] ?? null;
            $descTotalPrice = $_GET["descTotalPrice"] ?? null;
            $getLastOrder = $_GET["getLastOrder"] ?? null;

            $allOrders = $this->orderModel->getAllOrder(
                $pageNumber,
                $recordPerPage,
                $descTotalPrice,
                $status_id,
                $getLastOrder,
                $cid,
                $oid
            );
            $data = [];
            $data["orders"] = array_slice($allOrders, ($pageNumber - 1) * $recordPerPage, $recordPerPage) ?? [];
            foreach ($data["orders"] as &$order) {
                $order["products"] = $this->orderModel->getOrderDetail($order["id"]);
            }
            unset($order);

            $data["pageQtt"] = $allOrders ? ceil(count($allOrders) / $recordPerPage) : 1;
            $this->set($data);
            $this->render("index");
        } catch (Exception $e) {
            dd($e);
        }
    }
    public function getProcessingOrder()
    {
        try {
            $acount = $this->AdminController->checkLogin();
            if (!$acount) {
                $this->popup("/dashboard/login", "please login to access dashboard!!");
            }
            $pageNumber = $_GET["page"] ?? 1;
            $recordPerPage = PAGINATE;
            $status_id = '2,3';
            $oid = $_GET["oid"] ?? null;
            $cid = $_GET["cid"] ?? null;
            $descTotalPrice = $_GET["descTotalPrice"] ?? null;
            $getLastOrder = $_GET["getLastOrder"] ?? null;

            $allOrders = $this->orderModel->getAllOrder(
                $pageNumber,
                $recordPerPage,
                $descTotalPrice,
                $status_id,
                $getLastOrder,
                $cid,
                $oid
            );
            $data = [];
            $data["orders"] = array_slice($allOrders, ($pageNumber - 1) * $recordPerPage, $recordPerPage) ?? [];
            foreach ($data["orders"] as &$order) {
                $order["products"] = $this->orderModel->getOrderDetail($order["id"]);
            }
            unset($order);

            $data["pageQtt"] = $allOrders ? ceil(count($allOrders) / $recordPerPage) : 1;
            $this->set($data);
            $this->render("index");
        } catch (Exception $e) {
            dd($e);
        }
    }
    public function getCreateOrder()
    {
        try {
            $acount = $this->AdminController->checkLogin();
            if (!$acount) {
                $this->popup("/dashboard/login", "please login to access dashboard!!");
            }
            if ($acount["role_id"] < 2) {
                $this->popup("/dashboard", "You do not have enough promised, kindly contact administrator!!");
            } else {
                $pageNumber = $_GET["page"] ?? 1;
                $recordPerPage = PAGINATE;
                $productName = $_GET["q"] ?? null;
                $category = isset($_GET["category"]) ? "(" . $_GET["category"] . ")" : null;
                $brand = isset($_GET["brand"]) ? "(" . $_GET["brand"] . ")" : null;
                $allProduct = $this->productModel->getAllProduct($productName, $category, $brand);
                $data["enableSearch"] = true;
                $data["products"] = array_slice($allProduct, ($pageNumber - 1) * $recordPerPage, $recordPerPage) ?? [];
                $data["pageQtt"] = $allProduct ? ceil(count($allProduct) / $recordPerPage) : 1;
                $this->set($data);
                $this->render("getCreateOrder");
            }
        } catch (Exception $e) {
            die($e);
        }
    }
    //TODO: define action for generateOrder()
    public function generateOrder()
    {
        try {
            $acount = $this->AdminController->checkLogin();
            if (!$acount) {
                $this->popup("/dashboard/login", "please login to access dashboard!!");
            }
            if ($acount["role_id"] < 2) {
                $this->popup("/dashboard", "You do not have enough promised, kindly contact administrator!!");
            } else {
                $cart = $_POST["cart"] ?? null;
                if($cart){
                    //TODO: define function createOrder, generateOrderDetail
                    $oid = $this->orderModel->createOrder($acount["id"], $cart);
                    $this->ordeModel->generateOrderDetail($oid, $cart);
                }
            }
        } catch (Exception $e) {
            die($e);
        }
    }
}
