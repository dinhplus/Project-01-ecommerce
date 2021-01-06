<?php
use Controller\BaseController as Controller;
require_once(ROOT . "Models/Cart.php");
require_once(ROOT . "Models/Product.php");
require_once(ROOT . "Models/Order.php");
require_once(ROOT . "Models/Customer.php");
require_once(ROOT . "Controllers/AdminController.php");
class CartController extends Controller {

    public function __construct() {
        $this->layout = "defaultLayout";
        $this->customerModel = new Customer();
        $this->productModel = new Product();
        $this->orderModel = new Order();
        $this->cartModel = new Cart();
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
    public function showCart(){
        try {
            $user = $this->checkLogin();
            if (!$user) {
                $this->popup("/user/login", "Please log in to be able to perform this action! 👎👎👎👎");
            }
            $data["cart"] = $this->cartModel->getCart($user["id"]);
            $this->set($data);
            pd($data);
            $this->render("showCart");
        } catch (Exception $e) {
            pd($e);
        }
    }
    public function addItem(){
        try {
            $user = $this->checkLogin();
            if (!$user) {
                $this->popup("/user/login", "Please log in to be able to perform this action! 👎👎👎👎");
            }
            $pid = $_GET["pid"] ?? null;
            $item_quantity = $_GET["qtt"] ?? 1;
            if($pid){
                $productAvailable = $this->productModel->getProductAvailable($pid, $item_quantity);
                $addable = $this->cartModel->getAddable($user["id"], $pid);
            }

            if(isset($productAvailable) && $productAvailable && count($productAvailable) > 0 && $addable) {
                $addItemSuccess = $this->cartModel->addItem($user["id"], $pid, $item_quantity);
            }
            else{
                $this->popup("/home", "This product is not available, exist in your cart or Out of stock! <br> Kindly choose another or decrease Item quantity");
            }
            // TODO: Redirect to current page;
            if(isset($addItemSuccess) && $addItemSuccess){
                header("Location:"."http://".HOST."/home");
            }
            else{
                header("Location:"."http://".HOST."/home");
            }
        } catch (Exception $e) {
            pd($e);
        }
    }
    public function updateItemQuantity()
    {
        try {
            $user = $this->checkLogin();
            if (!$user) {
                $this->popup("/user/login", "Please log in to be able to perform this action! 👎👎👎👎");
            }
            $pid = $_GET["pid"] ?? null;
            $item_quantity = $_GET["qtt"] ?? 1;
            if($pid){
                $productAvailable = $this->productModel->getProductAvailable($pid, $item_quantity);
                $addable = $this->cartModel->getAddable($user["id"], $pid);
            }

            if(isset($productAvailable) && $productAvailable && count($productAvailable) > 0 && $addable) {
                $addItemSuccess = $this->cartModel->addItem($user["id"], $pid, $item_quantity);
            }
            else{
                $this->popup("/home", "This product is not available, exist in your cart or Out of stock! <br> Kindly choose another or decrease Item quantity");
            }
            // TODO: Redirect to current page;
            if(isset($addItemSuccess) && $addItemSuccess){
                header("Location:"."http://".HOST."/home");
            }
            else{
                header("Location:"."http://".HOST."/home");
            }
        } catch (Exception $e) {
            pd($e);
        }
    }
}