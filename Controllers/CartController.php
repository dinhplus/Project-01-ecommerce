<?php
use Controller\BaseController as Controller;
require_once(ROOT."Models/Product.php");
class ManagerController extends Controller {

    public function __construct() {
        $this->layout = "defaultLayout";
        if(!(isset($_COOKIE["username"]) && isset($_COOKIE["user_level"]) && $_COOKIE["user_level"]>1)){
            header("Location:"."http://".HOST."/acount/login");
        }
        $this->productModel = new Product();
    }

    public function index(){
        $page = isset($_GET["page"]) ? $_GET["page"] : 1;
        $products = $this->productModel->getProducts(1);
        $products->execute(["condition" => 1]);
        $temp = $products->rowCount();

        // var_dump($temp);
        // $productQuantity = $this->productModel->getProductQuantity();
        $this->render("manageProduct");
    }

    public function createProduct(){
        $this->render("createProduct");
    }
    public function storeProduct(){
        $name = $_POST["name"];
        $description = $_POST["description"];
        $price = $_POST["price"];
        $quantity = $_POST["quantity"];


        $img_store_target = ROOT.'WEBROOT\\public\\upload\\images\\';
        $img_ref_target = WEBROOT.'public/upload/images/';

        $img_base_name = basename($_FILES["img_ref"]["name"]);
        $img_store_name = explode(".",$img_base_name)[0].microtime(true).".".explode(".",$img_base_name)[1];

        $img_store_path =  $img_store_target.$img_store_name;
        $img_ref =  $img_ref_target.$img_store_name;

        $imageFileType = strtolower(pathinfo($img_store_path,PATHINFO_EXTENSION));
        $uploadOK = true;

        if(isset($_POST["submit"])){
            $check = getimagesize($_FILES["img_ref"]["tmp_name"]);
            $data["message"]["image"] = '';
            if(!$check) {
                //TODO: return alert "File is not an image";
                $data["message"]["image"] = $data["message"]["image"]."<br>File is not an image.";
                $uploadOk = false;
            }

            if(
                $imageFileType != "jpg"
                && $imageFileType != "png"
                && $imageFileType != "jpeg"
                && $imageFileType != "gif"
            ) {
                //TODO
                $data["message"]["image"] = $data["message"]["image"]."<br> Only JPG, JPEG, PNG & GIF files are allowed.";
                $uploadOk = false;
            }

            if(!$uploadOK){
                //TODO Alert smthg
                $data["message"]["image"] = "File uploaded is invalid <br>".$data["message"]["image"];
            }else{
                if (move_uploaded_file($_FILES["img_ref"]["tmp_name"], $img_store_path)) {
                    $data["onSuccess"]["image"] =  "The file ". htmlspecialchars( basename( $_FILES["img_ref"]["name"])). " has been uploaded.";
                } else {
                    $data["message"]["image"] = $data["message"]["image"]."<br> Sorry, there was an error uploading your file.";
                    $uploadOK = false;
                }
            }



        }
        if(!$uploadOK){
            $this -> set($data);
            $this->render("createProduct");
        }
        else{
            $product = [
                "name" => $name,
                "description" => $description,
                "price" => $price,
                "quantity" => $quantity,
                "img_ref" => $img_ref
            ];

            $onStoreProduct = $this->productModel->storeProduct($product);
            if( $onStoreProduct ){
                $data["onSuccess"]["storeProduct"] = "Successed to store product";
                $this -> set($data);
                header("Location:"."http://".HOST."/manager/create-product");
            }
            else {
                $data["onSuccess"]["storeProduct"] = "Failed to store product";
                $this -> set($data);
                $this->render("createProduct");

            }


        }
    }
}