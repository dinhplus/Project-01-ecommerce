<?php


class User extends Model
{
    //UserModel
    // public function fetchUser($username,$password){
    //     // $querry = "SELECT * FROM (SELECT * FROM users WHERE email = :acount OR username = :acount) WHERE password = :password";
    //     $querry = "SELECT * FROM user WHERE email = :acount OR username = :acount";
    //     $req = self::getConnection()->prepare($querry);
    //     return $req->execute([
    //         'acount'=>$username,
    //         'password'=>$password
    //     ]);

    // }

    public function fetchUser($username,$password){
        // $querry = "SELECT * FROM users WHERE username = :acount AND password = :password";
        $querry = "SELECT * FROM (SELECT * FROM users WHERE email = :acount OR username = :acount) acount WHERE password = :password";
        $req = self::getConnection()->prepare($querry);
        $req->setFetchMode(PDO::FETCH_ASSOC);

        $req->execute([
            'acount' => $username,
            'password' => $password
        ]);

        return $req->fetch();
    }

    public function storeUser($acount){
        $querry = "INSERT INTO users(username, password, email, birth_date, address, phone , avatar_ref, user_level) VALUES(:username, :password, :email, :birthdate, :address, :phone , :avatar_ref, :user_level)";
        $req = self::getConnection()->prepare($querry);

        // $req->setFetchMode(PDO::FETCH_ASSOC);

        $req->execute([
            "username" => $acount["username"],
            "password" => $acount["password"],
            "email" => $acount["email"],
            "birthdate" => $acount["birthdate"],
            "address" => $acount["address"],
            "phone" => $acount["phone"],
            "avatar_ref" => $acount["avatar_ref"],
            "user_level" => $acount["user_level"],
        ]);
        $temp = $req->fetch();
        echo($temp);
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

    public function showAllPosts()
    {
        $sql = "SELECT * FROM posts";
        $req = self::getConnection()->prepare($sql);
        $req->execute();
        return $req->fetch();
    }

    public function edit($id, $title, $description)
    {
        $sql = "UPDATE posts SET title = :title, description = :description , updated_at = :updated_at WHERE id = :id";

        $req = self::getConnection()->prepare($sql);

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
        $req = self::getConnection()->prepare($sql);
        return $req->execute();
    }
}