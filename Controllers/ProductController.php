<?php

use Controller\BaseController as Controller;

require_once(ROOT . "Models/Product.php");
require_once(ROOT . "Controllers/AdminController.php");

class ProductController extends Controller
{
    public function __construct()
    {
        $this->layout = "dashboardLayout";
        $this->adminModel = new Admin();
        $this->productModel = new Product();
        $this->AdminController = new AdminController();
    }
    public function index()
    {
        $acount = $this->AdminController->checkLogin();
        // var_dump($acount);
        if (!$acount) {
            $this->popup("/dashboard/login", "please login to access dashboard!!");
        }
        // var_dump($_GET["category"]);;

        $pageNumber = $_GET["page"] ?? 1;
        $recordPerPage = 20;
        $productName = $_GET["q"] ?? null;
        // var_dump($productName);
        $category = isset($_GET["category"]) ? "(" . $_GET["category"] . ")" : null;
        $brand = isset($_GET["brand"]) ? "(" . $_GET["brand"] . ")" : null;
        $allProduct = $this->productModel->getAllProduct($pageNumber, $recordPerPage, $productName, $category, $brand);
        $data["products"] = $allProduct;
        $data["pageQtt"] = $allProduct ? count($allProduct) / $recordPerPage : 1;
        $this->set($data);
        $this->render("index");
    }

    public function createProduct()
    {
        $acount = $this->AdminController->checkLogin();
        if (!$acount) {
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
    }

    public function storeProduct()
    {
        try {
            //code...

            $acount = $this->AdminController->checkLogin();
            if (!$acount) {
                $this->popup("/dashboard/login", "please login to access dashboard!!");
            }

            $name = $_POST["name"];
            $description = $_POST["description"];
            $price = $_POST["price"];
            $quantity = $_POST["quantity"];
            $brand_id = $_POST["brand"];
            $category_id = $_POST["category"];
            $warranty_cycle = $_POST["warranty-cycle"];
            $status = $_POST["status"] ?? 0;
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
            die($e);
        }
    }

    public function deleteProduct()
    {
        $acount = $this->AdminController->checkLogin();
        if (!$acount) {
            $this->popup("/dashboard/login", "please login to access dashboard!!");
        } else if ($acount["role_id"] < 4) {
            $this->popup("/dashboard/product-manager", "You do not have permission!!");
        } else {
            $pid = $_POST["pid"];
            $onDelete = $this->productModel->removeProduct($pid);
            if ($onDelete) {
                $this->popup("/dashboard/product-manager", "The product had been deleted! 👌👌👌👌👌");
            } else {
                $this->popup("/dashboard/product-manager", "The product is not existed!! 👌👌👌👌👌");
            }
        }
    }
    public function productRemainder()
    {
        $acount = $this->AdminController->checkLogin();
        if (!$acount) {
            $this->popup("/dashboard/login", "please login to access dashboard!!");
        }
        $pageNumber = $_GET["page"] ?? 1;
        $recordPerPage = 20;
        $productName = $_GET["q"] ?? null;
        $isSort = $_GET["sort"] ?? 1; //sort = 1 ?? -1
        $category = null;
        $brand = null;
        $allProduct = $this->productModel->getAllProduct($pageNumber, $recordPerPage, $productName, $category, $brand, $isSort);
        $data["products"] = $allProduct;
        $data["pageQtt"] = $allProduct ? count($allProduct) / $recordPerPage : 1;
        $this->set($data);
        $this->render("remainder");
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
            die($e);
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
            die($e);
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

            $name = $_POST["name"];
            $description = $_POST["description"];
            $price = $_POST["price"];
            $quantity = $_POST["quantity"];
            $brand_id = $_POST["brand"];
            $category_id = $_POST["category"];
            $warranty_cycle = $_POST["warranty-cycle"];
            $status = $_POST["status"] ?? 0;
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
            die($e);
        }
    }
}
