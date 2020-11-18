<?php

use Model\CoreModel as Model;

class User extends Model
{
    //UserModel
    // public function fetchUser($username,$password){
    //     // $querry = "SELECT * FROM (SELECT * FROM users WHERE email = :acount OR username = :acount) WHERE password = :password";
    //     $querry = "SELECT * FROM user WHERE email = :acount OR username = :acount";
    //     $req = DB::getConnection()->prepare($querry);
    //     return $req->execute([
    //         'acount'=>$username,
    //         'password'=>$password
    //     ]);

    // }

    public function fetchUser($username,$password){
        // $querry = "SELECT * FROM users WHERE username = :acount AND password = :password";
        $querry = "SELECT * FROM (SELECT * FROM users WHERE email = :acount OR username = :acount) acount WHERE password = :password";
        $req = DB::getConnection()->prepare($querry);
        $req->setFetchMode(PDO::FETCH_ASSOC);

        $req->execute([
            'acount' => $username,
            'password' => $password
        ]);

        return $req->fetch();
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