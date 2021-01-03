<?php

use Controller\BaseController as Controller;

require_once(ROOT . "Models/Product.php");
require_once(ROOT . "Models/Order.php");
require_once(ROOT . "Models/Customer.php");
require_once(ROOT . "Controllers/AdminController.php");
class ClientController extends Controller
{
    public function __construct()
    {
        $this->layout = "defaultLayout";
        $this->customerModel = new Customer();
        $this->productModel = new Product();
        $this->orderModel = new Order();
    }
    public function index()
    {
        $this->render("index");
    }
    public function listProduct()
    {
        try {
            $data = [];
            $pageNumber = $_GET["page"] ?? 1;
            $recordPerPage = PAGINATE;
            $productName = $_GET["q"] ?? null;
            $productStatus = 2;
            $category = isset($_GET["category"]) ? "(" . $_GET["category"] . ")" : null;
            $brand = isset($_GET["brand"]) ? "(" . $_GET["brand"] . ")" : null;
            $customerUsername = $_SESSION["customerUsername"] ?? null;
            if ($customerUsername) {
                $customer = $this->customerModel->getCustomerByUsername($customerUsername);
                $data["customer"] = $customer;
            }
            $allProduct = $this->productModel->getAllProduct($productName, $category, $brand, $productStatus);
            $data["categories"] = $this->productModel->getCategories();
            $data["brands"] = $this->productModel->getBrands();
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
                    $data["categories"] = $this->productModel->getCategories();
                    $data["brands"] = $this->productModel->getBrands();
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
            pd($e);
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
            $customerId = $_SESSION["customerId"] ?? null;
            if ($customerId) {
                $this->popup("/", "Please logout before Login");
            }
            $username = $_POST["username"] ?? null;
            $password = $_POST["password"] ?? null;
            $_SESSION["username"] = $_POST["username"] ?? null;
            $_SESSION["password"] = $_POST["password"] ?? null;
            $_SESSION["location"] = $_POST["location"] ?? null;
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
            pd($e);
        }
    }
    public function storeUser()
    {
        try {
            $customerId = $_SESSION["customerId"] ?? null;
            if ($customerId) {
                $this->popup("/", "Please logout before Login");
            }
            $existAcount = $this->customerModel->getCustomerByUsername($_POST["username"]);
            if ($existAcount && count($existAcount) > 0) {
                $_SESSION["name"] = $_POST["name"];
                $_SESSION["username"] = $_POST["username"];
                $_SESSION["password"] = $_POST["password"];
                $_SESSION["phone"] = $_POST["phone"];
                $_SESSION["email"] = $_POST["email"];
                $_SESSION["address"] = $_POST["address"];
                $_SESSION["birth_date"] = $_POST["birth_date"];
                $_SESSION["location"] = $_POST["location"];
                $data["message"] = "This username have been existed";
                $data["loginFailed"] = true;
                $this->set($data);
                $this->listProduct();
            } else {
                $onRegister = $this->customerModel->storeUser(
                    $_POST["name"],
                    $_POST["username"],
                    $_POST["password"],
                    $_POST["phone"],
                    $_POST["email"],
                    $_POST["address"],
                    $_POST["birth_date"],
                    $_POST["location"]
                );
                if ($onRegister) {
                    unset($_SESSION["name"]);
                    unset($_SESSION["username"]);
                    unset($_SESSION["password"]);
                    unset($_SESSION["phone"]);
                    unset($_SESSION["email"]);
                    unset($_SESSION["address"]);
                    unset($_SESSION["birth_date"]);
                    $retrieveAccount =  $this->customerModel->getCustomerByUsername($_POST["username"]);
                    $_SESSION["customerId"] = $retrieveAccount["id"];
                    $_SESSION["customerUsername"] = $retrieveAccount["username"];
                    $_SESSION["customer-token"] = $retrieveAccount["password"];
                    header("Location:" . "http://" . HOST . $_SESSION["location"]);
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
            pd($e);
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
            $this->set($data);
            $this->render("showUser");
        } catch (Exception $e) {
            pd($e);
        }
    }
    public function editUserProfile()
    {
        try {
            $user = $this->checkLogin();
            if (!$user) {
                $this->popup("/user/login", "Please log in to be able to perform this action! 👎👎👎👎");
            }
            $data["user"] = $user;
            $this->set($data);
            $this->render("editUser");
        } catch (Exception $e) {
            pd($e);
        }
    }
    public function updateUserProfile()
    {
        try {
            $user = $this->checkLogin();
            if (!$user) {
                $this->popup("/user/login", "Please log in to be able to perform this action! 👎👎👎👎");
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
                $data["message"] = "The password is invalid. Please try again";
                $this->set($data);
                $this->editUserProfile();
            }
        } catch (Exception $e) {
            pd($e);
        }
    }
    public function getChangePassword()
    {
        try {
            $user = $this->checkLogin();
            if (!$user) {
                $this->popup("/user/login", "Please log in to be able to perform this action! 👎👎👎👎");
            }
            $this->render("changePassword");
        } catch (Exception $e) {
            pd($e);
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
            if ($confirmUser) {
                $uInfo["password"] = $_POST["new-password"];
                $uInfo["username"] = $confirmUser["username"];
                $updateUser = $this->customerModel->updateUserPassword($uInfo);
                if ($updateUser) {
                    $retrieveUser = $this->customerModel->getCustomerByUsername($user["username"]);
                    $_SESSION["customer-token"] = $retrieveUser["password"];
                    $this->popup("/", " <h2>Updated successfully! </h2> <hr> Please remember new password: ".$uInfo['password']);
                } else {
                    $this->popup("/", "Updated failed!");
                }
            } else {
                $data["message"] = "The current password is invalid. Please try again";
                $this->set($data);
                $this->getChangePassword();
            }
        } catch (Exception $e) {
            pd($e);
        }
    }
}
