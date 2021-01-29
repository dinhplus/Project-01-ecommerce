<?php

use Controller\BaseController as Controller;

require_once(ROOT . "Models/Product.php");
require_once(ROOT . "Controllers/AdminController.php");

class ProductController extends Controller
{
    public function __construct()
    {
        $_POST = $this->secure_form($_POST);
        $_GET = $this->secure_form($_GET);
        $_REQUEST = $this->secure_form($_REQUEST);
        $this->layout = "dashboardLayout";
        $this->adminModel = new Admin();
        $this->productModel = new Product();
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
            $productName = $_GET["q"] ?? null;
            // pd($productName);
            $category = isset($_GET["category"]) ? "(" . $_GET["category"] . ")" : null;
            $brand = isset($_GET["brand"]) ? "(" . $_GET["brand"] . ")" : null;
            $allProduct = $this->productModel->getAllProduct($productName, $category, $brand);
            pd($allProduct);
            $data["enableSearch"] = true;
            $data["products"] = array_slice($allProduct, ($pageNumber - 1) * $recordPerPage, $recordPerPage) ?? [];
            $data["pageQtt"] = $allProduct ? ceil(count($allProduct) / $recordPerPage) : 1;
            $this->set($data);
            $this->render("index");
        } catch (Exception $e) {
            pd($e);
        }
    }

    public function createProduct()
    {
        try {
            $acount = $this->AdminController->checkLogin();
            if (!$acount) {
                $this->layout = "blankLayout";
                $this->popup("/dashboard/login", "please login to access dashboard!!");
            }
            $categories = $this->productModel->getCategories();
            $brands = $this->productModel->getBrands();
            $status = $this->productModel->getStatus();
            $data["categories"] = $categories;
            $data["brands"] = $brands;
            $data["status"] = $status;
            $this->set($data);
            $this->layout = "dashboardLayout";
            $this->render("getCreateProduct");
        } catch (Exception $e) {
            //pd($e);
        }
    }

    public function storeProduct()
    {
        try {
            $acount = $this->AdminController->checkLogin();
            if (!$acount) {
                $this->popup("/dashboard/login", "please login to access dashboard!!");
            }
            // dd($_POST);
            $name = $_POST["name"];
            $description = $_POST["description"];
            // dd($description);
            $price = $_POST["price"];
            $quantity = $_POST["quantity"];
            $brand_id = $_POST["brand"];
            $category_id = $_POST["category"];
            $warranty_cycle = $_POST["warranty-cycle"];
            $status = $_POST["status"] ?? 2;
            $img_selector = $_POST["image-selector"] ?? 1;
            if ($img_selector == 2) {
                $img_base_name = basename($_FILES["img_ref"]["name"]) ?? null;
                if ($img_base_name) {
                    $img_store_target = ROOT . 'WEBROOT\\public\\upload\\images\\';
                    $img_ref_target = WEBROOT . 'public/upload/images/';

                    $img_store_name = $img_base_name !== '' ?  explode(".", $img_base_name)[0] . microtime(true) . "." . explode(".", $img_base_name)[1] : '';
                    $img_store_path =  $img_store_target . $img_store_name;
                    $img_ref =  $img_ref_target . $img_store_name;
                    $imageFileType = strtolower(pathinfo($img_store_path, PATHINFO_EXTENSION));
                    $uploadOK = true;
                    $check = getimagesize($_FILES["img_ref"]["tmp_name"]);
                    $data["message"]["image"] = '';
                    if (!$check) {
                        //TODO: return alert "File is not an image";
                        $data["message"]["image"] = $data["message"]["image"] . "<br>File is not an image.";
                        $uploadOK = false;
                    }

                    if (
                        $imageFileType != "jpg"
                        && $imageFileType != "png"
                        && $imageFileType != "jpeg"
                        && $imageFileType != "gif"
                    ) {
                        //TODO
                        $data["message"]["image"] = $data["message"]["image"] . "<br> Only JPG, JPEG, PNG & GIF files are allowed.";
                        $uploadOK = false;
                    }
                    if (!$uploadOK) {
                        //TODO Alert smthg
                        $data["message"]["image"] = "File uploaded is invalid <br>" . $data["message"]["image"];
                    } else {
                        if (move_uploaded_file($_FILES["img_ref"]["tmp_name"], $img_store_path)) {
                            $data["onSuccess"]["image"] =  "The file " . htmlspecialchars(basename($_FILES["img_ref"]["name"])) . " has been uploaded.";
                        } else {
                            $data["message"]["image"] = $data["message"]["image"] . "<br> Sorry, there was an error uploading your file.";
                            $uploadOK = false;
                        }
                    }
                }
            } else if ($img_selector == 1) {
                $img_ref = $_POST["img_ref"] ?? null;
            }
            if ($img_selector == 2 && $img_base_name && !$uploadOK) {
                $this->set($data);
                $this->createProduct();
            } else if ($img_selector == 1 || ($img_selector == 2 && !$img_base_name) || ($img_base_name && $uploadOK)) {
                $product = [
                    "name" => $name,
                    "description" => $description,
                    "price" => $price,
                    "quantity" => $quantity,
                    "img_ref" => $img_ref ?? null,
                    "category_id" => $category_id,
                    "brand_id" => $brand_id,
                    "warranty_cycle" => $warranty_cycle,
                    "status_id" => $status
                ];
                $onStoreProduct = $this->productModel->storeProduct($product);
                if ($onStoreProduct) {
                    $data["onSuccess"]["storeProduct"] = "Successed to store product";
                    $this->set($data);
                    $this->popup("/dashboard/product-manager", "Stored Product Success");

                    // header("Location:"."http://".HOST."/manager/create-product");
                } else {
                    $data["onSuccess"]["storeProduct"] = "Failed to store product";
                    $this->set($data);
                    $this->createProduct();
                }
            }
        } catch (Exception $e) {
            //pd($e);
        }
    }

    public function deleteProduct()
    {
        try {
            $acount = $this->AdminController->checkLogin();
            if (!$acount) {
                $this->popup("/dashboard/login", "please login to access dashboard!!");
            } else if ($acount["role_id"] < 4) {
                $this->popup("/dashboard/product-manager", "You do not have permission!!");
            } else {
                $pid = $_POST["pid"];
                $product =  $this->productModel->getProductById($pid);
                $onDelete = $this->productModel->removeProduct($pid);
                if ($onDelete) {
                    $this->dropUploadedFile($product["img_ref"]);
                    $this->popup("/dashboard/product-manager", "The product had been deleted! 👌👌👌👌👌");
                } else {
                    $this->popup("/dashboard/product-manager", "The product is not existed!! 👌👌👌👌👌");
                }
            }
        } catch (Exception $e) {
            //pd($e);
        }
    }
    public function productRemainder()
    {
        try {
            $acount = $this->AdminController->checkLogin();
            if (!$acount) {
                $this->popup("/dashboard/login", "please login to access dashboard!!");
            }
            $pageNumber = $_GET["page"] ?? 1;
            $recordPerPage = PAGINATE;
            $productName = $_GET["q"] ?? null;
            $isSort = $_GET["sort"] ?? 1; //sort = 1 ?? -1
            $category = null;
            $brand = null;
            $allProduct = $this->productModel->getAllProduct($productName, $category, $brand, null, $isSort);
            $data["products"] = array_slice($allProduct, ($pageNumber - 1) * $recordPerPage, $recordPerPage) ?? [];
            $data["pageQtt"] = $allProduct ? ceil(count($allProduct) / $recordPerPage) : 1;
            $this->set($data);
            $this->render("index");
        } catch (Exception $e) {
            //pd($e);
        }
    }
    public function showProductDetail()
    {
        try {
            $acount = $this->AdminController->checkLogin();
            if (!$acount) {
                $this->popup("/dashboard/login", "please login to access dashboard!!");
            }

            $pid = $_GET["pid"];
            $product = $this->productModel->getProductById($pid);
            if ($product && count($product) > 0) {

                $data["product"] = $product;
                $this->set($data);
                $this->render("showProductDetail");
            } else {
                $this->popup("/dashboard/product-manager", "This product is not exist! 👆👆👆👆👆👆");
            }
        } catch (Exception $e) {
            //pd($e);
        }
    }

    public function editProduct()
    {
        try {
            $acount = $this->AdminController->checkLogin();
            if (!$acount) {
                $this->popup("/dashboard/login", "please login to access dashboard!!");
            }
            $pid = $_GET["pid"];
            $product = $this->productModel->getProductById($pid);
            if ($product && count($product) > 0) {
                $_SESSION["in-progress-pid"] = $pid;
                $categories = $this->productModel->getCategories();
                $brands = $this->productModel->getBrands();
                $status = $this->productModel->getStatus();
                $data["categories"] = $categories;
                $data["brands"] = $brands;
                $data["status"] = $status;
                $data["product"] = $product;
                $this->set($data);
                $this->render("getEditProduct");
            } else {
                $this->popup("/dashboard/product-manager", "This product is not exist! 👆👆👆👆👆👆");
            }
        } catch (Exception $e) {
            //pd($e);
        }
    }
    public function updateProduct()
    {
        try {
            //code...

            $acount = $this->AdminController->checkLogin();
            if (!$acount) {
                $this->popup("/dashboard/login", "please login to access dashboard!!");
            }
            $oldProduct = $this->productModel->getProductById($_SESSION["in-progress-pid"]);
            $name = $_POST["name"];
            $description = $_POST["description"];
            $price = $_POST["price"];
            $quantity = $_POST["quantity"];
            $brand_id = $_POST["brand"];
            $category_id = $_POST["category"];
            $warranty_cycle = $_POST["warranty-cycle"];
            $status = $_POST["status"] ?? 2;
            $img_selector = $_POST["image-selector"] ?? 1;
            if ($img_selector == 2) {
                $img_base_name = basename($_FILES["img_ref"]["name"]) ?? null;



                if ($img_base_name) {
                    $img_store_target = ROOT . 'WEBROOT\\public\\upload\\images\\';
                    $img_ref_target = WEBROOT . 'public/upload/images/';

                    $img_store_name = $img_base_name !== '' ?  explode(".", $img_base_name)[0] . microtime(true) . "." . explode(".", $img_base_name)[1] : '';
                    $img_store_path =  $img_store_target . $img_store_name;
                    $img_ref =  $img_ref_target . $img_store_name;
                    $imageFileType = strtolower(pathinfo($img_store_path, PATHINFO_EXTENSION));
                    $uploadOK = true;
                    $check = getimagesize($_FILES["img_ref"]["tmp_name"]);
                    $data["message"]["image"] = '';
                    if (!$check) {
                        //TODO: return alert "File is not an image";
                        $data["message"]["image"] = $data["message"]["image"] . "<br>File is not an image.";
                        $uploadOK = false;
                    }

                    if (
                        $imageFileType != "jpg"
                        && $imageFileType != "png"
                        && $imageFileType != "jpeg"
                        && $imageFileType != "gif"
                    ) {
                        //TODO
                        $data["message"]["image"] = $data["message"]["image"] . "<br> Only JPG, JPEG, PNG & GIF files are allowed.";
                        $uploadOK = false;
                    }
                    if (!$uploadOK) {
                        //TODO Alert smthg
                        $data["message"]["image"] = "File uploaded is invalid <br>" . $data["message"]["image"];
                    } else {
                        if (move_uploaded_file($_FILES["img_ref"]["tmp_name"], $img_store_path)) {
                            $data["onSuccess"]["image"] =  "The file " . htmlspecialchars(basename($_FILES["img_ref"]["name"])) . " has been uploaded.";
                            $this->dropUploadedFile($oldProduct["img_ref"]);
                        } else {
                            $data["message"]["image"] = $data["message"]["image"] . "<br> Sorry, there was an error uploading your file.";
                            $uploadOK = false;
                        }
                    }
                } else if (!$img_base_name) {
                    $img_ref = $oldProduct["img_ref"];
                }
            } else if ($img_selector == 1) {
                if (isset($_POST["img_ref"]) && strlen($_POST["img_ref"]) > 0 && trim($_POST["img_ref"]) != ' ') {
                    $img_ref = $_POST["img_ref"];
                    $this->dropUploadedFile($oldProduct["img_ref"]);
                } else {
                    $img_ref = $oldProduct["img_ref"];
                }
            }

            if ($img_selector == 2 && $img_base_name && !$uploadOK) {
                $this->set($data);
                $this->createProduct();
            } else if ($img_selector == 1 || ($img_selector == 2 && !$img_base_name) || ($img_base_name && $uploadOK)) {
                $product = [
                    "id" => $oldProduct["id"],
                    "name" => $name,
                    "description" => $description,
                    "price" => $price,
                    "quantity" => $quantity,
                    "img_ref" => $img_ref ?? null,
                    "category_id" => $category_id,
                    "brand_id" => $brand_id,
                    "warranty_cycle" => $warranty_cycle,
                    "status_id" => $status
                ];
                $onUpdateProduct = $this->productModel->updateProduct($product);
                if ($onUpdateProduct) {
                    $data["onSuccess"]["storeProduct"] = "Successed to store product";
                    $this->set($data);
                    $this->popup("/dashboard/product-manager", "Stored Product Success");

                    // header("Location:"."http://".HOST."/manager/create-product");
                } else {
                    $data["onSuccess"]["storeProduct"] = "Failed to store product";
                    $this->set($data);
                    $this->createProduct();
                }
            }
        } catch (Exception $e) {
            //pd($e);
        }
    }

    public function showCategoryManage(){
        try {
            $acount = $this->AdminController->checkLogin();
            if (!$acount) {
                $this->popup("/dashboard/login", "please login to access dashboard!!");
            }
            $data["categories"] = $this->productModel->getCategories();
            $this->set($data);
            // pd($data);
            $this->render("categoryManage");
        } catch (Exception $e) {
            pd($e);
        }
    }
    public function storeCategory()
    {
        try {
            $acount = $this->AdminController->checkLogin();
            if (!$acount) {
                $this->popup("/dashboard/login", "please login to access dashboard!!");
            }
            if($acount["role_id"] < 4){
                $this->popup("/dashboard/login", "please check your permission!!");
            }
            $category = $_POST["category"] ?? '';
            $onStore = true;
            if(strlen($category) > 1){
                $onStore = $this->productModel->storeCategory($category);
            }
            else{
                $onStore = false;
            }
            if($onStore){
                $data["alert"] = "Store new category successfully";
            }
            else{
                $data["alert"] = "Store new category failed with unexpected error! Kindly try again!";
            }
            $this->popup("http://" . HOST . $_SESSION["currentUrl"],  $data["alert"]);

        } catch (Exception $e) {
            //pd($e);
        }
    }
    public function updateCategory()
    {
        try {
            $acount = $this->AdminController->checkLogin();
            if (!$acount) {
                $this->popup("/dashboard/login", "please login to access dashboard!!");
            }
            if($acount["role_id"] < 4){
                $this->popup("/dashboard/login", "please check your permission!!");
            }
            $categoryId = $_POST["category_id"] ?? '';
            $category = $_POST["category"] ?? '';
            $onStore = true;
            if(strlen($category) > 1){
                $onStore = $this->productModel->updateCategory($categoryId, $category);
            }
            else{
                $onStore = false;
            }
            if($onStore){
                $data["alert"] = "Update new category successfully";
            }
            else{
                $data["alert"] = "Update new category failed with unexpected error! Kindly try again!";
            }
            $this->popup("http://" . HOST . $_SESSION["currentUrl"],  $data["alert"]);
        } catch (Exception $e) {
            //pd($e);
        }
    }

    public function showBrandManage(){
        try {

            $acount = $this->AdminController->checkLogin();
            // dd($acount);
            if (!$acount) {
                $this->popup("/dashboard/login", "please login to access dashboard!!");
            }
            $data["brands"] = $this->productModel->getBrands();
            $this->set($data);
            // pd($data);
            $this->render("brandManage");
        } catch (Exception $e) {
            pd($e);
        }
    }
    public function storeBrand()
    {
        try {
            $acount = $this->AdminController->checkLogin();
            if (!$acount) {
                $this->popup("/dashboard/login", "please login to access dashboard!!");
            }
            if($acount["role_id"] < 4){
                $this->popup("/dashboard/login", "please check your permission!!");
            }

            $brand = $_POST["brand"] ?? '';
            $onStore = true;
            if(strlen($brand) > 1){
                $onStore = $this->productModel->storeBrand($brand);
            }
            else{
                $onStore = false;
            }
            if($onStore){
                $data["alert"] = "Store new brand successfully";
            }
            else{
                $data["alert"] = "Store new brand failed with unexpected error! Kindly try again!";
            }
            $this->popup("http://" . HOST . $_SESSION["currentUrl"],  $data["alert"]);

        } catch (Exception $e) {
            //pd($e);
        }
    }
    public function updateBrand()
    {
        try {
            $acount = $this->AdminController->checkLogin();
            if (!$acount) {
                $this->popup("/dashboard/login", "please login to access dashboard!!");
            }
            if($acount["role_id"] < 4){
                $this->popup("/dashboard/login", "please check your permission!!");
            }
            $brandId = $_POST["brand_id"] ?? '';
            $brand = $_POST["brand"] ?? '';
            $onStore = true;
            if(strlen($brand) > 1){
                $onStore = $this->productModel->updateBrand($brandId, $brand);
            }
            else{
                $onStore = false;
            }
            if($onStore){
                $data["alert"] = "Update new category successfully";
            }
            else{
                $data["alert"] = "Update new category failed with unexpected error! Kindly try again!";
            }
            $this->popup("http://" . HOST . $_SESSION["currentUrl"],  $data["alert"]);
        } catch (Exception $e) {
            //pd($e);
        }
    }
}
