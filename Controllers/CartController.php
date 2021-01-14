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
                $selectedItemQuantity = $this->cartModel->getItemQuantity($user["id"], $pid);
                $productAvailable = $this->productModel->getProductAvailable($pid, $item_quantity, $selectedItemQuantity);
                $addable = $this->cartModel->getAddable($user["id"], $pid);
            }

            if(isset($productAvailable) && isset( $addable) && $productAvailable && count($productAvailable) > 0 && $addable) {
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
                $selectedItemQuantity = $this->cartModel->getItemQuantity($user["id"], $pid);
                $productAvailable = $this->productModel->getProductAvailable($pid, $item_quantity, $selectedItemQuantity);
                $addable = $this->cartModel->getAddable($user["id"], $pid);
            }

            if(isset($productAvailable) && isset( $addable) && $productAvailable && count($productAvailable) > 0 && !$addable) {
                $addItemSuccess = $this->cartModel->updateCartItemQuantity($user["id"], $pid, $item_quantity);
            }
            else{
                $this->popup("/home", "Number of products requested is more than the number of available products");
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
    public function deleteItem()
    {
        try {
            $user = $this->checkLogin();
            if (!$user) {
                $this->popup("/user/login", "Please log in to be able to perform this action! 👎👎👎👎");
            }
            $pid = $_GET["pid"] ?? null;
            if($pid){
                $addable = $this->cartModel->getAddable($user["id"], $pid);
            }

            if(isset($addable) && !$addable) {
                $deleteItemSuccess = $this->cartModel->deleteItem($user["id"], $pid);
            }
            else{
                $this->popup("/home", "This product is not exist in your cart!");
            }
            // TODO: Redirect to current page;
            if(isset($deleteItemSuccess) && $deleteItemSuccess){
                header("Location:"."http://".HOST."/home");
            }
            else{
                header("Location:"."http://".HOST."/home");
            }
        } catch (Exception $e) {
            pd($e);
        }
    }
    public function confirmOrder(){
        try {
            $user = $this->checkLogin();
            if (!$user) {
                $this->popup("/user/login", "Please log in to be able to perform this action! 👎👎👎👎");
            }
            $data = [];
            $data["customer"] = $user;
            $data["cart"] = $this->cartModel->getCart($user["id"]);
            $this->set($data);
            $this->render("confirmOrder");
        } catch  (Exception $e) {
            pd($e);
        }
    }
    public function pushOrder()
    {
        try {
            $user = $this->checkLogin();
            if (!$user) {
                $this->popup("/user/login", "Please log in to be able to perform this action! 👎👎👎👎");
            }
            /**
             * TODO:
             *  1. generate order
             *  2. push Item into order_detail
             *  3. update totalPrice for order
             *  4. Clean up Cart
             *  5. redireact show order list
             */
            $name = $_POST["name"];
            $address = $_POST["address"];
            $phone = $_POST["phone"];
            $note = $_POST["note"] ?? '';
            $newOrder = $this->orderModel->generateOrder($user["id"], null, $name, $phone, $address, $note);
            $pushOrderDetail = $this->orderModel->pushOrderDetail($newOrder["id"], $user["id"]);
            if($pushOrderDetail){
                $orderDetail = $this->orderModel->getOrderDetail($newOrder["id"]);
                $totalPrice = 0;
                foreach ($orderDetail as $item) {
                    $totalPrice += intval($item["quantity"])* intval($item["unit_price"]);
                }
                $this->orderModel->updateTotalPrice($newOrder["id"], $totalPrice);
                $this->cartModel->cleanUpCart($user["id"]);
            }
            header("Location:"."http://".HOST."/user/order/show?oid=".$newOrder["id"]);
        } catch  (Exception $e) {
            pd($e);
        }
    }

}