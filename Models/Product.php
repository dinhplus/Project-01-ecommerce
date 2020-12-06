<?php

// use Model\CoreModel as Model;

class Product extends Model
{
    public function getProductQuantity(){
        $query = "SELECT count(id) as quantity from products";

    }
    public function storeProduct($product){
        $query = "INSERT INTO products(name, description, price, quantity, img_ref)
                    VALUES(:name, :description, :price, :quantity, :img_ref)";
        $req = self::getConnection()->prepare($query);

        return  $req->execute([
            "name" => $product["name"],
            "description" => $product["description"],
            "price" => $product["price"],
            "quantity" => $product["quantity"],
            "img_ref" => $product["img_ref"]
        ]);
    }

    public function getAllProduct($page = 1, $recordPerPage = 20, $productName , $category, $brand )
    {
        //FIXME: Can not binding params with template
        $query = "SELECT p.*, c.label category , b.name brand FROM products p JOIN product_categories c ON c.id = p.category_id JOIN product_brand b ON b.id = p.brand_id WHERE 1 ";
        if($productName){
            $query.="AND p.name LIKE '%".$productName."%'";
        }
        if($category){
            $query.=" AND p.category_id in ".$category;
        }
        if($brand){
            $query.= " AND p.brand_id in ".$brand;
        }
        $query.= " LIMIT ".$recordPerPage." OFFSET ". $recordPerPage * ($page -1);
        $req = self::getConnection()->prepare($query);
        $req->execute();
        $req->setFetchMode(PDO::FETCH_ASSOC);
        return $req->fetchAll();
    }
    public function getCategories(){
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
        // $res = $req->fetchAll();
        // var_dump($res);die();
        return $req->fetchAll();
    }

}
