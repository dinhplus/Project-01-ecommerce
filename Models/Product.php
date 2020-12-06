<?php

// use Model\CoreModel as Model;

class Product extends Model
{
    public function getProductQuantity(){
        $querry = "SELECT count(id) as quantity from products";

    }
    public function getProducts($condition)
    {
        $querry = "SELECT * FROM  products WHERE :condition";
        $req = self::getConnection()->prepare($querry);
        $req->setFetchMode(PDO::FETCH_ASSOC);
        return $req;
        // return $req->execute([
        //     "condition" => $condition
        // ]);
    }
    public function storeProduct($product){
        $querry = "INSERT INTO products(name, description, price, quantity, img_ref)
                    VALUES(:name, :description, :price, :quantity, :img_ref)";
        $req = self::getConnection()->prepare($querry);

        // $req->setFetchMode(PDO::FETCH_ASSOC);

        return  $req->execute([
            "name" => $product["name"],
            "description" => $product["description"],
            "price" => $product["price"],
            "quantity" => $product["quantity"],
            "img_ref" => $product["img_ref"]
        ]);
    }

    public function create($title, $description)
    {
        $sql = "INSERT INTO posts (title, description, created_at, updated_at) VALUES (:title, :description, :created_at, :updated_at)";

        $req = self::getConnection()->prepare($sql);

        return $req->execute([
            'title' => $title,
            'description' => $description,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')

        ]);
    }

    public function showPost($id)
    {
        $sql = "SELECT * FROM posts WHERE id =  $id";
        $req = self::getConnection()->prepare($sql);
        $req->execute();

        return $req->fetch();
    }

    public function getAllProduct($page = 1, $recordPerPage = 20, $productName = '')
    {
        $sql = "SELECT p.*, c.label category , b.name brand, FROM products p JOIN product_categories c ON c.id = p.category_id JOIN product_brand b ON b.id = p.brand_id WHERE p.name like '%:name%' LIMIT :quantity OFFSET :offset";
        $req = self::getConnection()->prepare($sql);
        $req->setFetchMode(PDO::FETCH_ASSOC);
        $req->execute([
            "quantity" => $recordPerPage,
            "offset" => $recordPerPage * $page,
            "name" => $productName,

        ]);
        return $req->fetch();
    }


}