<?php

class Customer extends Model{
    public function getCustomerByUsername($username)
    {
        $query = "SELECT * FROM customers WHERE username = :username";
        $req = self::getConnection()->prepare($query);
        $req->setFetchMode(PDO::FETCH_ASSOC);

        $req->execute([
            'username' => $username,
        ]);

        return $req->fetch();
    }
    public function fetchAccount($username,$password){
        $query = "SELECT * FROM customers WHERE username = :username";
        $req = self::getConnection()->prepare($query);
        $req->setFetchMode(PDO::FETCH_ASSOC);
        $req->execute([
            'username' => $username
        ]);
        $account  = $req->fetch();

        if( $account && password_verify($password,$account["password"])){
            return $account;
        }
        else return false;
    }
    public function checkLogin($username,$password){
        $query = "SELECT * FROM customers WHERE username = :username AND password = :password";
        $req = self::getConnection()->prepare($query);
        $req->setFetchMode(PDO::FETCH_ASSOC);
        $req->execute([
            'username' => $username,
            'password' => $password
        ]);
        $account  = $req->fetch();

        return $account;
    }
    public function storeUser(
        $name,
        $username,
        $password,
        $phone,
        $email = null,
        $address,
        $birth_date = null
    )
    {
        $query = "INSERT INTO customers(name, username, password, phone, email, address, birth_date) VALUES(:name, :username, :password, :phone, :email, :address, :birth_date)";
        $req = self::getConnection()->prepare($query);
        // $req->setFetchMode(PDO::FETCH_ASSOC);
        return  $req->execute([
            "name" => $name,
            "username" => $username,
            "password" => password_hash($password,PASSWORD_DEFAULT),
            "phone" => $phone,
            "email" => $email,
            "address" => $address,
            "birth_date" => $birth_date
        ]);
    }
}