<?php

use Controller\BaseController as Controller;

require_once(ROOT . "Models/Cart.php");
require_once(ROOT . "Models/Product.php");
require_once(ROOT . "Models/Order.php");
require_once(ROOT . "Models/Customer.php");
require_once(ROOT . "Controllers/AdminController.php");
class ClientController extends Controller
{
    public function __construct()
    {
        $_POST = $this->secure_form($_POST);
        $_GET = $this->secure_form($_GET);
        $_REQUEST = $this->secure_form($_REQUEST);
        $this->layout = "defaultLayout";
        $this->customerModel = new Customer();
        $this->productModel = new Product();
        $this->orderModel = new Order();
        $this->cartModel = new Cart();
    }
    public function index()
    {
        $this->render("index");
    }
    protected function clientLoadInfor($customerId)
    {
        $data["cart"] = $this->cartModel->getCart($customerId);
        // pd($data["cart"]);
        $totalPrice = 0;
        foreach ($data["cart"] as $item) {
            $totalPrice += intval($item["item_quantity"]) * intval($item["unit_price"]);
        }
        $data["totalItem"] = array_reduce(
            $data["cart"],
            function ($currentValue, $accumulator) {
                return $currentValue + $accumulator["item_quantity"];
            },
            0
        );
        $data["totalPrice"] = $totalPrice;
        $this->set($data);
    }
    public function listProduct()
    {
        try {
            $data = [];
            $pageNumber = $_GET["page"] ?? 1;
            $recordPerPage = PAGINATE;
            $productName = $_GET["q"] ?? '';
            $productStatus = 2;
            $category = isset($_GET["category"]) ?  $_GET["category"]  : null;
            $brand = isset($_GET["brand"]) ? $_GET["brand"]  : null;
            $customer = $this->checkLogin();
            $allProduct = $this->productModel->getAllProduct($productName, $category, $brand, $productStatus);
            if ($customer) {
                $data["customer"] = $customer;
                $this->clientLoadInfor($customer["id"]);
            }
            $data["products"] = array_slice($allProduct, ($pageNumber - 1) * $recordPerPage, $recordPerPage) ?? [];
            $data["pageQtt"] = $allProduct ? ceil(count($allProduct) / $recordPerPage) : 1;
            $this->set($data);
            // dd($data);
            $this->render("index");
        } catch (Exception $e) {
            pd($e);
        }
    }
    public function productDetail()
    {
        try {
            $pid = $_GET["pid"] ?? null;
            if ($pid) {
                $product = $this->productModel->getProductById($pid);
            }
            if ($product && count($product) > 0) {
                if ($product["status_id"] > 1) {
                    $customer = $this->checkLogin();
                    if ($customer) {
                        $data["customer"] = $customer;
                        $this->clientLoadInfor($customer["id"]);
                    }
                    $data["product"] = $product;
                    $this->set($data);
                    $this->render("showProductDetail");
                } else {
                    $this->popup("/", "Can not show detail for this product. <br> product_id: " . $product['id']);
                }
            } else {
                $this->popup("/", "This product is not exist! 👆👆👆👆👆👆");
            }
        } catch (Exception $e) {
            // pd($e);
        }
    }
    public function checkLogin()
    {

        if (
            isset($_SESSION["customerUsername"])
            && isset($_SESSION["customer-token"])
        ) {

            $account = $this->customerModel->checkLogin($_SESSION["customerUsername"], $_SESSION["customer-token"]);

            if ($account !== false && count($account) > 0) {
                $checkLogin = $account;
            } else {
                $checkLogin = false;
            }
        } else {
            $checkLogin = false;
        }
        return $checkLogin;
    }
    public function getLogin()
    {
        $account = $this->checkLogin();
        if (!$account) {
            $this->layout = 'blankLayout';
            $this->render("getLogin");
        } else {
            $this->layout = "defaultLayout";
            header("Location:" . "http://" . HOST . "");
        }
    }
    public function postLogin()
    {
        try {
            $user = $this->checkLogin();
            if ($user) {
                $this->popup("/", "Please logout before Login");
            }
            $username = $_POST["username"] ?? null;
            $password = $_POST["password"] ?? null;

            $_SESSION["username"] = $_POST["username"] ?? null;
            $_SESSION["password"] = $_POST["password"] ?? null;
            $_SESSION["location"] = $_POST["location"] ?? null;
            if (!(regexUsename($username) && regexPassword($password))) {
                $data["message"] = "Please enter correctly according to the specified form";
                $data["loginFailed"] = true;
                $this->set($data);
                $this->listProduct();
                die();
            }
            $account = $this->customerModel->fetchAccount($username, $password);
            // dd($account);
            if (!$account || $account === []) {

                $data["message"] = "Username or password are invalid!";
                $data["loginFailed"] = true;
                $this->set($data);
                $this->listProduct();
            } else {
                $_SESSION["customerId"] = $account["id"];
                $_SESSION["customerUsername"] = $account["username"];
                $_SESSION["customer-token"] = $account["password"];
                unset($_SESSION["username"]);
                unset($_SESSION["password"]);
                setcookie("c-access-token", 'u=' . $account["username"] . '&token=' . $account["password"], time() + (86400 * 30), "/");
                $this->layout = "defaultLayout";
                header("Location:" . "http://" . HOST . $_SESSION["location"]);
            }
        } catch (Exception $e) {
            // pd($e);
        }
    }
    public function storeUser()
    {
        try {
            $customerId = $_SESSION["customerId"] ?? null;
            if ($customerId) {
                $this->popup("/", "Please logout before Login");
            }
            unset($_SESSION["message"]);
            unset($_SESSION["loginFailed"]);
            unset($_SESSION["registerFailed"]);
            // dd($_POST);
            if (
                !(regexUsename($_POST["username"]) && isValidName($_POST["name"])
                    && regexPassword($_POST["password"]) && regexPhoneNumber($_POST["phone"])
                    && regexEmail($_POST["email"]) && isValidAddress($_POST["address"]))
            ) {
                $_SESSION["name"] = $_POST["name"];
                $_SESSION["username"] = $_POST["username"];
                $_SESSION["password"] = $_POST["password"];
                $_SESSION["phone"] = $_POST["phone"];
                $_SESSION["email"] = $_POST["email"];
                $_SESSION["address"] = $_POST["address"];
                $_SESSION["birth_date"] = $_POST["birth_date"];

                $data["message"] = "Register failed. Please enter correctly according to the specified form ";
                $data["registerFailed"] = true;
                $this->set($data);
                $this->listProduct();
                die();
            }
            $existAcount = $this->customerModel->getCustomerByUsername($_POST["username"]);
            $phoneExisted = $this->customerModel->getExistedPhone($_POST["phone"]);
            if (($phoneExisted && count($phoneExisted)) || ($existAcount && count($existAcount) > 0)) {
                $data["message"] = '';
                $_SESSION["name"] = $_POST["name"];
                $_SESSION["username"] = $_POST["username"];
                $_SESSION["password"] = $_POST["password"];
                $_SESSION["phone"] = $_POST["phone"];
                $_SESSION["email"] = $_POST["email"];
                $_SESSION["address"] = $_POST["address"];
                $_SESSION["birth_date"] = $_POST["birth_date"];
                if ($phoneExisted && count($phoneExisted)) {
                    $data["message"] .= "This phone number have been used";
                }
                if ($existAcount && count($existAcount) > 0) {
                    $data["message"] .= "This username have been existed";
                }
                $data["registerFailed"] = true;
                $this->set($data);
                $this->listProduct();
                die();
            } else {
                $onRegister = $this->customerModel->storeUser(
                    $_POST["name"],
                    $_POST["username"],
                    $_POST["password"],
                    $_POST["phone"],
                    $_POST["email"],
                    $_POST["address"],
                    $_POST["birth_date"]
                );
                if ($onRegister) {
                    unset($_SESSION["name"]);
                    unset($_SESSION["username"]);
                    unset($_SESSION["password"]);
                    unset($_SESSION["phone"]);
                    unset($_SESSION["email"]);
                    unset($_SESSION["address"]);
                    unset($_SESSION["birth_date"]);
                    unset($_SESSION["registerFailed"]);
                    unset($_SESSION["loginFailed"]);
                    $retrieveAccount =  $this->customerModel->getCustomerByUsername($_POST["username"]);
                    $_SESSION["customerId"] = $retrieveAccount["id"];
                    $_SESSION["customerUsername"] = $retrieveAccount["username"];
                    $_SESSION["customer-token"] = $retrieveAccount["password"];
                    header("Location:" . "http://" . HOST . '/home');
                }
            }
        } catch (Exception $e) {
            pd($e);
        }
    }
    public function getRegister()
    {
        try {
            $customerId = $_SESSION["customerId"] ?? null;
            if ($customerId) {
                $this->popup("/", "Please logout before Register");
            }
            $this->layout = "blankLayout";
            $this->render("getRegister");
        } catch (Exception $e) {
            // pd($e);
        }
    }
    public function getLogout()
    {
        unset($_SESSION["customerId"]);
        unset($_SESSION["customerUsername"]);
        unset($_SESSION["customer-token"]);
        unset($_SESSION["location"]);
        unset($_SESSION["cart"]);
        header("Location:" . "http://" . HOST . '/home');
    }
    public function showProfile()
    {
        try {
            $user = $this->checkLogin();
            if (!$user) {
                $this->popup("/user/login", "Please log in to be able to perform this action! 👎👎👎👎");
            }
            $data["user"] = $user;
            // $data["categories"] = $this->productModel->getCategories();
            // $data["brands"] = $this->productModel->getBrands();
            $this->set($data);
            $this->render("showUser");
        } catch (Exception $e) {
            // pd($e);
        }
    }
    public function editUserProfile()
    {
        try {
            $user = $this->checkLogin();
            if (!$user) {
                $this->popup("/user/login", "Please log in to be able to perform this action! 👎👎👎👎");
            }
            // $data["categories"] = $this->productModel->getCategories();
            // $data["brands"] = $this->productModel->getBrands();
            $data["user"] = $user;
            $this->set($data);
            $this->render("editUser");
        } catch (Exception $e) {
            // pd($e);
        }
    }
    public function updateUserProfile()
    {
        try {
            $user = $this->checkLogin();
            if (!$user) {
                $this->popup("/user/login", "Please log in to be able to perform this action! 👎👎👎👎");
            }
            if (
                !(isValidName($_POST["name"])
                    && regexPassword($_POST["password"]) && regexPhoneNumber($_POST["phone"])
                    && regexEmail($_POST["email"]) && isValidAddress($_POST["address"]))
            ) {
                $data["message"] = "Update failed. Please enter correctly according to the specified form ";
                $this->set($data);
            }
            $confirmUser = $this->customerModel->fetchAccount($user["username"], $_POST["password"]);
            $uInfo["name"] = $_POST["name"];
            $uInfo["phone"] = $_POST["phone"];
            $uInfo["email"] = $_POST["email"];
            $uInfo["address"] = $_POST["address"];
            $uInfo["birth_date"] = $_POST["birth_date"];
            if ($confirmUser) {
                $uInfo["username"] = $confirmUser["username"];
                $updateUser = $this->customerModel->updateUserProfile($uInfo);
                if ($updateUser) {
                    $this->popup("/", "Updated successfully!");
                } else {
                    $this->popup("/", "Updated failed!");
                }
            } else {
                $data["message"] = ($data["message"]??"")."The password is invalid. Please try again";
                $this->set($data);
                $this->editUserProfile();
            }
        } catch (Exception $e) {
            // pd($e);
        }
    }
    public function getChangePassword()
    {
        try {
            $user = $this->checkLogin();
            if (!$user) {
                $this->popup("/user/login", " <br> Please log in to be able to perform this action! 👎👎👎👎");
            }
            // $data["categories"] = $this->productModel->getCategories();
            // $data["brands"] = $this->productModel->getBrands();
            // $this->set($data);
            $this->render("changePassword");
        } catch (Exception $e) {
            // pd($e);
        }
    }
    public function updatePassword()
    {
        try {
            $user = $this->checkLogin();
            if (!$user) {
                $this->popup("/user/login", "Please log in to be able to perform this action! 👎👎👎👎");
            }
            $confirmUser = $this->customerModel->fetchAccount($user["username"], $_POST["password"]);
            if (!regexPassword($_POST["new-password"])) {
                $data["message"] = "Please enter correctly according to the specified form";
                $this->set($data);
            }
            if ($confirmUser) {
                $uInfo["password"] = $_POST["new-password"];
                $uInfo["username"] = $confirmUser["username"];
                $updateUser = $this->customerModel->updateUserPassword($uInfo);
                if ($updateUser) {
                    $retrieveUser = $this->customerModel->getCustomerByUsername($user["username"]);
                    $_SESSION["customer-token"] = $retrieveUser["password"];
                    $this->popup("/", " <h2>Updated successfully! </h2> <hr> Please remember new password: " . $uInfo['password']);
                } else {
                    $this->popup("/", "Updated failed!");
                }
            } else {
                $data["message"] = ($data["message"] ?? '') . " <br> The current password is invalid. Please try again";
                $this->set($data);
                $this->getChangePassword();
                die();
            }
        } catch (Exception $e) {
            // pd($e);
        }
    }
    public function showOrders()
    {
        try {
            $user = $this->checkLogin();
            if (!$user) {
                $this->popup("/user/login", "Please log in to be able to perform this action! 👎👎👎👎");
            }
            $pageNumber = $_GET["page"] ?? 1;
            $recordPerPage = PAGINATE;
            $status_id = $_GET["status_id"] ?? null;
            $oid = $_GET["oid"] ?? null;
            $cid = $user["id"];
            $timeRange = $_GET["timeRange"] ?? null;
            $cheapest = $_GET["cheapest"] ?? null;
            $newest = $_GET["newest"] ?? null;
            $allOrders = $this->orderModel->getAllOrder(
                $pageNumber,
                $recordPerPage,
                $cheapest,
                $status_id,
                $timeRange,
                $cid,
                $oid,
                $newest,
            );
            $data = [];
            $data["orders"] = $allOrders; // array_slice($allOrders, ($pageNumber - 1) * $recordPerPage, $recordPerPage) ?? [];
            foreach ($data["orders"] as &$order) {
                $order["products"] = $this->orderModel->getOrderDetail($order["id"]);
            }
            unset($order);
            // $data["categories"] = $this->productModel->getCategories();
            // $data["brands"] = $this->productModel->getBrands();
            $data["pageQtt"] = $allOrders ? ceil(count($allOrders) / $recordPerPage) : 1;
            $this->set($data);
            $this->render("showOrderList");
        } catch (Exception $e) {
            // pd($e);
        }
    }
    public function showOrderDetail()
    {
        try {
            $user = $this->checkLogin();
            if (!$user) {
                $this->popup("/user/login", "Please log in to be able to perform this action! 👎👎👎👎");
            }
            $oid = $_GET["oid"] ?? 1;
            $order = $this->orderModel->getOrderById($oid) ?? null;
            if ($order && $order["customer_id"] === $user["id"]) {
                $order["products"] = $this->orderModel->getOrderDetail($oid);
                $data["order"] = $order;
                // $data["enableSearch"] = false;
                // $data["categories"] = $this->productModel->getCategories();
                // $data["brands"] = $this->productModel->getBrands();
                $this->set($data);
                // $this->render("orderDetail");
                $this->render("showOrderDetail");
            } else {
                $this->popup("/user/order/list", "This order do not exist");
            }
        } catch (Exception $e) {
            // pd($e);
        }
    }
    public function cancelOrder()
    {
        try {
            $user = $this->checkLogin();
            if (!$user) {
                $this->popup("/user/login", "Please log in to be able to perform this action! 👎👎👎👎");
            }
            $oid = $_POST["oid"] ?? null;
            $note = $_POST["change_status_note"] ?? null;
            if ($oid) {
                $order = $this->orderModel->getOrderById($oid) ?? null;
            }
            if (isset($order) && $order["customer_id"] === $user["id"]) {
                if ($order["status_id"] < 4) {
                    $onCancelOrder = $this->orderModel->updateOrderStatus($oid, 6, $order["staff_ref"], $note);
                    if ($onCancelOrder) {
                        $this->popup("/user/order/list", "Cancelled Success!");
                    } else {
                        $this->popup("/user/order/list", "Cancellation failed! Kindly try again");
                    }
                } else {
                    $this->popup("/user/order/list", "This order cannot be cancelled! <br> Please waiting for recieving the payload");
                }
            } else {
                $this->popup("/user/order/list", "This order do not exist");
            }
        } catch (Exception $e) {
            // pd($e);
        }
    }
}
