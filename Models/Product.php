<?php

// use Model\CoreModel as Model;

class Product extends Model
{

    public function getStatus()
    {
        $query = "SELECT * FROM product_status order by id asc";
        $req = self::getConnection()->prepare($query);
        $req->setFetchMode(PDO::FETCH_ASSOC);
        $req->execute();
        return $req->fetchAll();
    }

    public function storeProduct($product)
    {
        $query = "INSERT INTO products(name, description, price, quantity, img_ref, category_id, brand_id, warranty_cycle, status_id)
                    VALUES(:name, :description, :price, :quantity, :img_ref, :category_id, :brand_id, :warranty_cycle , :status_id)";
        $req = self::getConnection()->prepare($query);

        return  $req->execute([
            "name" => $product["name"],
            "description" => $product["description"],
            "price" => $product["price"],
            "quantity" => $product["quantity"],
            "img_ref" => $product["img_ref"],
            "category_id" => $product["category_id"],
            "brand_id" => $product["brand_id"],
            "warranty_cycle" => $product["warranty_cycle"],
            "status_id" => $product["status_id"]
        ]);
    }

    public function getAllProduct($productName, $category = null, $brand = null, $product_status = null, $isSort = false)
    {

        //FIXME: Can not binding params with template
        $query = "SELECT p.*, c.label category , b.name brand, stt.label status FROM products p JOIN product_categories c ON c.id = p.category_id JOIN product_brand b ON b.id = p.brand_id JOIN product_status stt ON stt.id = p.status_id WHERE 1 ";
        // if ($productName) {
            $query .= "AND p.name LIKE :productName";
        // }
        if ($category) {
            $query .= " AND p.category_id = :category" ;//. $category;
        }
        else {
            $query .= " AND p.category_id != :category" ;
        }
        if ($brand) {
            $query .= " AND p.brand_id = :brand"; //. $brand;
        } else {
            $query .= " AND p.brand_id != :brand";
        }
        if ($product_status) {
            $query .= " AND p.status_id = :product_status";// . $product_status;
        }
        else{
            $query .= " AND p.status_id != :product_status";// . $product_status;
        }
        if ($isSort == 1) {
            $query .= " ORDER BY p.quantity ASC";
        }
        if ($isSort == -1) {
            $query .= " ORDER BY p.quantity DESC";
        }
        // pd($query);
        $req = self::getConnection()->prepare($query);
        $req->execute([
            "productName" => $productName?"%".$productName."%":"%%",
            "category" => $category??'' ,
            "brand" => $brand??'' ,
            "product_status" => $product_status??''
        ]);
        // $req->setFetchMode(PDO::FETCH_ASSOC);
        // dd($req->fetchAll());
        return $req->fetchAll();
    }
    public function getCategories()
    {
        $query = 'SELECT * FROM product_categories';
        $req = self::getConnection()->prepare($query);
        $req->setFetchMode(PDO::FETCH_ASSOC);
        $req->execute();
        return $req->fetchAll();
    }
    public function getBrands()
    {
        $query = 'SELECT * FROM product_brand';
        $req = self::getConnection()->prepare($query);
        $req->setFetchMode(PDO::FETCH_ASSOC);
        $req->execute();
        return $req->fetchAll();
    }

    public function removeProduct($pid)
    {
        $query = "DELETE FROM products where id = :id";
        $req = self::getConnection()->prepare($query);
        return  $req->execute([
            "id" => $pid
        ]);
    }
    public function getProductById($pid)
    {
        $query = "SELECT p.*, c.label category , b.name brand, stt.label status FROM products p JOIN product_categories c ON c.id = p.category_id JOIN product_brand b ON b.id = p.brand_id JOIN product_status stt ON stt.id = p.status_id WHERE p.id = :id";
        $req = self::getConnection()->prepare($query);
        $req->setFetchMode(PDO::FETCH_ASSOC);
        $req->execute([
            "id" => $pid
        ]);
        return $req->fetch();
    }
    public function updateProduct($product)
    {
        $query = "UPDATE  products SET name = :name, description = :description, price = :price, quantity = :quantity, img_ref = :img_ref, category_id = :category_id, brand_id = :brand_id, warranty_cycle = :warranty_cycle, status_id = :status_id WHERE id = :id";
        $req = self::getConnection()->prepare($query);

        return  $req->execute([
            "id" => $product["id"],
            "name" => $product["name"],
            "description" => $product["description"],
            "price" => $product["price"],
            "quantity" => $product["quantity"],
            "img_ref" => $product["img_ref"],
            "category_id" => $product["category_id"],
            "brand_id" => $product["brand_id"],
            "warranty_cycle" => $product["warranty_cycle"],
            "status_id" => $product["status_id"]
        ]);
    }
    public function getProductAvailable($pid, $expect_quantity = 1, $currentSelectedQtt)
    {
        $query = "SELECT p.id from products p WHERE p.id = :pid AND p.quantity >= (:expect_quantity + :crrQtt)";
        $req = self::getConnection()->prepare($query);
        $req->execute([
            "pid" => $pid,
            "expect_quantity" => $expect_quantity,
            "crrQtt" => $currentSelectedQtt
        ]);
        return $req->fetch();
    }
    function decreaseProductQuantity($pid, $decreaseQuantity)
    {
        $query = "UPDATE products SET quantity = quantity - :dQtt WHERE id = :pid";
        $req = self::getConnection()->prepare($query);
        return $req->execute([
            "pid" => $pid,
            "dQtt" => $decreaseQuantity
        ]);
    }
    public function storeCategory($category)
    {
        if ($category) {

            $query = "INSERT INTO product_categories(label) VALUE (:category)";
            $req = self::getConnection()->prepare($query);
            return $req->execute([
                "category" => $category
            ]);
        } else return false;
    }
    public function updateCategory($categoryId, $category)
    {
        if (isset($categoryId) && isset($category)) {

            $query = "UPDATE product_categories SET label = :category WHERE id = :category_id";
            $req = self::getConnection()->prepare($query);
            return $req->execute([
                "category_id" => $categoryId,
                "category" => $category
            ]);
        } else return false;
    }
    public function deleteCategory($categoryId)
    {
        if (isset($categoryId)) {

            $query = "DELETE FROM product_categories  WHERE id = :category_id";
            $req = self::getConnection()->prepare($query);
            return $req->execute([
                "category_id" => $categoryId,
            ]);
        } else return false;
    }

    public function storeBrand($brand)
    {
        $query = "INSERT INTO product_brand(name) VALUE (:brand)";
        $req = self::getConnection()->prepare($query);
        return $req->execute([
            "brand" => $brand
        ]);
    }
    public function updateBrand($brandId, $brand)
    {
        if (isset($brandId) && isset($brand)) {

            $query = "UPDATE product_brand SET name = :brand WHERE id = :brand_id";
            $req = self::getConnection()->prepare($query);
            return $req->execute([
                "brand_id" => $brandId,
                "brand" => $brand
            ]);
        } else return false;
    }
    public function deleteBrand($brandId)
    {
        if (isset($brandId)) {

            $query = "DELETE FROM product_brand  WHERE id = :brand_id";
            $req = self::getConnection()->prepare($query);
            return $req->execute([
                "brand_id" => $brandId,
            ]);
        } else return false;
    }
}
