<?php

// use Model\CoreModel as Model;

class Admin extends Model
{
    public function getRoles()
    {
        $query = "SELECT * FROM staff_role";
        $req = self::getConnection()->prepare($query);
        $req->setFetchMode(PDO::FETCH_ASSOC);
        $req->execute();
        return $req->fetchAll();
    }

    public function getAccount($username){
        // $query = "SELECT * FROM users WHERE username = :account AND password = :password";
        $query = "SELECT * FROM staffs WHERE username = :username";
        $req = self::getConnection()->prepare($query);
        $req->setFetchMode(PDO::FETCH_ASSOC);

        $req->execute([
            'username' => $username,
        ]);

        return $req->fetch();
    }
    public function checkLogin($username,$password){
        // $query = "SELECT * FROM users WHERE username = :account AND password = :password";
        $query = "SELECT * FROM staffs WHERE username = :username AND password = :password";
        $req = self::getConnection()->prepare($query);
        $req->setFetchMode(PDO::FETCH_ASSOC);
        $req->execute([
            'username' => $username,
            'password' => $password
        ]);
        $account  = $req->fetch();

        return $account;
    }

    public function fetchAccount($username,$password){
        // $query = "SELECT * FROM users WHERE username = :account AND password = :password";
        $query = "SELECT * FROM staffs WHERE username = :username";
        $req = self::getConnection()->prepare($query);
        $req->setFetchMode(PDO::FETCH_ASSOC);
        $req->execute([
            'username' => $username
        ]);
        $account  = $req->fetch();

        if($account && password_verify($password,$account["password"])){
            return $account;
        }
        else return false;
    }

    public function storeStaff($account){
        $query = "INSERT INTO staffs(username, password, name, role_id) VALUES(:username, :password, :name, :role_id)";
        $req = self::getConnection()->prepare($query);
        // $req->setFetchMode(PDO::FETCH_ASSOC);
        return  $req->execute([
            "username" => $account["username"],
            "password" => password_hash($account["password"],PASSWORD_DEFAULT),
            "name" => $account["name"],
            "role_id" => $account["role_id"]
        ]);

    }

    public function updateAccount($account){
        $query = "UPDATE staffs SET role_id = :role_id, name = :name, password = :password WHERE username = :username";
        // var_dump($account);
        $req = self::getConnection()->prepare($query);
        return $req->execute([
            "role_id" => $account["role_id"],
            "password" => $account["password"],
            "name" => $account["name"],
            "username" => $account["username"]
        ]);
    }

    public function getAccountRecord($username = null){
        $query = "SELECT s.id, s.name, s.username, s.role_id, r.label from staffs s join staff_role r on s.role_id = r.level where s.username like :username";
        $req = self::getConnection()->prepare($query);
        $req->setFetchMode(PDO::FETCH_ASSOC);
        $req->execute([
            "username" => $username? "%".$username."%" : "%%"
        ]);
        $staffs = $req->fetchAll();
        return $staffs;
    }
    public function getAccountById($uid){
        $query = "SELECT s.id, s.name, s.username,s.password, s.role_id, r.label from staffs s join staff_role r on s.role_id = r.level WHERE s.id = :uid";
        $req = self::getConnection() -> prepare($query);
        $req->setFetchMode(PDO::FETCH_ASSOC);
        $req->execute([
            "uid" => $uid
        ]);
        $account = $req->fetch();

        return $account;
    }

    public function deleteStaff($uid)
    {
        $query = "DELETE from staffs WHERE id = :id";
        $req = self::getConnection()->prepare($query);
        return $req->execute([
            "id" => $uid
        ]);
    }
}