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
            // pd($data);
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
                    if ($next_status == 4) {
                        $order_detail = $this->orderModel->getOrderDetail($oid);
                        foreach ($order_detail as $item) {
                            $this->productModel->decreaseProductQuantity($item["product_id"], $item["quantity"]);
                        }
                    }
                    $this->popup("/dashboard/order-manager", "The order status has been updated! <br> Click ok then redirect Dashboard");
                }
            } else if ($order["status_id"] > 3) {
                // $data["message"] = "This order status is the lastest status. You cannot modify!";
                // $data["order"] = $order;
                $this->popup("/dashboard/order-manager", "This order status is the lastest status. You cannot modify!");
            } else {
                $this->popup("/dashboard/order-manager", "Can not change this order status");
                // $data["message"] = "Can not change this order status";
                // $data["order"] = $order;
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
    public function addItem()
    {
        try {
            $acount = $this->AdminController->checkLogin();
            if (!$acount) {
                $this->popup("/dashboard/login", "please login to access dashboard!!");
            }
            if ($acount["role_id"] < 2) {
                $this->popup("/dashboard", "You do not have enough promised, kindly contact administrator!!");
            } else {
                $_SESSION["tempCart"][$_POST["pid"]] = $_SESSION["tempCart"][$_POST["pid"]] ?? 1;
                header("Location:" . "http://" . HOST . $_SESSION["currentUrl"]);
            }
        } catch (Exception $e) {
            pd($e);
        }
    }
    public function getConfirmOrder()
    {
        try {
            $acount = $this->AdminController->checkLogin();
            if (!$acount) {
                $this->popup("/dashboard/login", "please login to access dashboard!!");
            }
            if ($acount["role_id"] < 2) {
                $this->popup("/dashboard", "You do not have enough promised, kindly contact administrator!!");
            } else {
                $tempOrder = $_SESSION["tempCart"] ?? [];
                // pd($_SESSION);
                $newOrder = [];
                $totalPrice = 0;
                foreach ($tempOrder as $pid => $itemQtt) {
                    $item = $this->productModel->getProductById($pid);
                    if ($item && count($item) > 0) {
                        $item["item_quantity"] = $itemQtt;
                        $item["unit_price"] = $item["price"];
                        $newOrder[$pid] = $item;
                        $totalPrice += intval($itemQtt) * intval($item["price"]);
                    }
                }
                $data["totalPrice"] = $totalPrice;
                $data['cart'] = $newOrder;
                // pd($data);
                $this->set($data);
                $this->render("getConfirmOrder");
            }
        } catch (Exception $e) {
            pd($e);
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
                $tempOrder = $_SESSION["tempCart"] ?? [];
                if ($tempOrder && count($tempOrder) === 0) {
                    $this->popup("/dashboard/product-manager/index", "The basket is empty!");
                }

                //TODO: define function createOrder, generateOrderDetail
                $name = $_POST["name"];
                $address = $_POST["address"];
                $phone = $_POST["phone"];
                $note = $_POST["note"] ?? '';
                $newOrder = $this->orderModel->generateOrder(null, $acount["id"], $name, $phone, $address, $note);
                foreach ($tempOrder as $pid => $itemQtt) {
                    $this->orderModel->pushNewOrderByStaff($newOrder["id"] - 1, $pid, $itemQtt);
                }
                $orderDetail = $this->orderModel->getOrderDetail($newOrder["id"] - 1);
                $totalPrice = 0;
                foreach ($orderDetail as $item) {
                    $totalPrice += intval($item["quantity"]) * intval($item["unit_price"]);
                }
                $this->orderModel->updateTotalPrice($newOrder["id"] - 1, $totalPrice);
                unset($_SESSION["tempCart"]);
                header("Location:" . "http://" . HOST . "/dashboard/order-manager");
            }
        } catch (Exception $e) {
            pd($e);
        }
    }
    public function updateTempItemQuantity()
    {
        try {
            $acount = $this->AdminController->checkLogin();
            if (!$acount) {
                $this->popup("/dashboard/login", "please login to access dashboard!!");
            }
            if ($acount["role_id"] < 2) {
                $this->popup("/dashboard", "You do not have enough promised, kindly contact administrator!!");
            }
            $_SESSION["tempCart"][$_POST["pid"]] = $_POST["qtt"] ?? $_SESSION["tempCart"][$_POST["pid"]];
            header("Location:" . "http://" . HOST . $_SESSION["currentUrl"]);
        } catch (Exception $e) {
            pd($e);
        }
    }
    public function deleteTempItem()
    {
        try {
            $acount = $this->AdminController->checkLogin();
            if (!$acount) {
                $this->popup("/dashboard/login", "please login to access dashboard!!");
            }
            if ($acount["role_id"] < 2) {
                $this->popup("/dashboard", "You do not have enough promised, kindly contact administrator!!");
            }
            // pd($_SESSION["tempCart"][$_POST["pid"]]);
            if (isset($_SESSION["tempCart"][$_POST["pid"]])) {
                unset($_SESSION["tempCart"][$_POST["pid"]]);
            }
            header("Location:" . "http://" . HOST . $_SESSION["currentUrl"]);
        } catch (Exception $e) {
            pd($e);
        }
    }
    public function cleanUpTempCart()
    {
        try {
            $acount = $this->AdminController->checkLogin();
            if (!$acount) {
                $this->popup("/dashboard/login", "please login to access dashboard!!");
            }
            if ($acount["role_id"] < 2) {
                $this->popup("/dashboard", "You do not have enough promised, kindly contact administrator!!");
            }
            // pd($_SESSION["tempCart"][$_POST["pid"]]);
            if (isset($_SESSION["tempCart"])) {
                unset($_SESSION["tempCart"]);
            }
            header("Location:" . "http://" . HOST . $_SESSION["currentUrl"]);
        } catch (Exception $e) {
            pd($e);
        }
    }

}
