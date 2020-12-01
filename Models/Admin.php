<?php

use Model\CoreModel as Model;

class Admin extends Model
{
    public function getRoles()
    {
        $querry = "SELECT * FROM staff_role";
        $req = DB::getConnection()->prepare($querry);
        $req->setFetchMode(PDO::FETCH_ASSOC);
        $req->execute();
        return $req->fetchAll();
    }

    public function getAcount($username){
        // $querry = "SELECT * FROM users WHERE username = :acount AND password = :password";
        $querry = "SELECT * FROM staffs WHERE username = :username";
        $req = DB::getConnection()->prepare($querry);
        $req->setFetchMode(PDO::FETCH_ASSOC);

        $req->execute([
            'username' => $username,
        ]);

        return $req->fetch();
    }
    public function checkLogin($username,$password){
        // $querry = "SELECT * FROM users WHERE username = :acount AND password = :password";
        $querry = "SELECT * FROM staffs WHERE username = :username AND password = :password";
        $req = DB::getConnection()->prepare($querry);
        $req->setFetchMode(PDO::FETCH_ASSOC);
        $req->execute([
            'username' => $username,
            'password' => $password
        ]);
        $acount  = $req->fetch();

        return $acount;
    }

    public function fetchAcount($username,$password){
        // $querry = "SELECT * FROM users WHERE username = :acount AND password = :password";
        $querry = "SELECT * FROM staffs WHERE username = :username";
        $req = DB::getConnection()->prepare($querry);
        $req->setFetchMode(PDO::FETCH_ASSOC);
        $req->execute([
            'username' => $username
        ]);
        $acount  = $req->fetch();

        if(password_verify($password,$acount["password"])){
            return $acount;
        }
        else return false;
    }

    public function storeStaff($acount){
        $querry = "INSERT INTO staffs(username, password, name, role_id) VALUES(:username, :password, :name, :role_id)";
        $req = DB::getConnection()->prepare($querry);
        // $req->setFetchMode(PDO::FETCH_ASSOC);
        return  $req->execute([
            "username" => $acount["username"],
            "password" => password_hash($acount["password"],PASSWORD_DEFAULT),
            "name" => $acount["name"],
            "role_id" => $acount["role_id"]
        ]);

    }

    public function updateAcount($acount){
        $querry = "UPDATE staffs SET role_id = :role_id, name = :name, password = :password WHERE username = :username";
        // var_dump($acount);
        $req = DB::getConnection()->prepare($querry);
        return $req->execute([
            "role_id" => $acount["role_id"],
            "password" => password_hash($acount["password"],PASSWORD_DEFAULT),
            "name" => $acount["name"],
            "username" => $acount["username"]
        ]);
    }



}