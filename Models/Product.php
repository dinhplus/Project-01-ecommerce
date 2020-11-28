<?php

use Model\CoreModel as Model;

class Product extends Model
{
    public function getProductQuantity(){
        $querry = "SELECT count(id) as quantity from products";

    }
    public function getProducts($condition)
    {
        $querry = "SELECT * FROM  products WHERE :condition";
        $req = DB::getConnection()->prepare($querry);
        $req->setFetchMode(PDO::FETCH_ASSOC);
        return $req;
        // return $req->execute([
        //     "condition" => $condition
        // ]);
    }
    public function storeProduct($product){
        $querry = "INSERT INTO products(name, description, price, quantity, img_ref)
                    VALUES(:name, :description, :price, :quantity, :img_ref)";
        $req = DB::getConnection()->prepare($querry);

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

        $req = DB::getConnection()->prepare($sql);

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
        $req = DB::getConnection()->prepare($sql);
        $req->execute();

        return $req->fetch();
    }

    public function showAllPosts()
    {
        $sql = "SELECT * FROM posts";
        $req = DB::getConnection()->prepare($sql);
        $req->execute();
        return $req->fetch();
    }

    public function edit($id, $title, $description)
    {
        $sql = "UPDATE posts SET title = :title, description = :description , updated_at = :updated_at WHERE id = :id";

        $req = DB::getConnection()->prepare($sql);

        return $req->execute([
            'id' => $id,
            'title' => $title,
            'description' => $description,
            'updated_at' => date('Y-m-d H:i:s')

        ]);
    }

    public function delete($id)
    {
        echo $id;
        $sql = "DELETE FROM posts WHERE id = $id";
        $req = DB::getConnection()->prepare($sql);
        return $req->execute();
    }
}