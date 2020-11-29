<?php
use Controller\BaseController as Controller;
require_once(ROOT."Models/Admin.php");
class AdminController extends Controller{

    public function __construct(){
        $this->layout = "dashboardLayout";
        $this->adminModel = new Admin();
    }
    public function getLogin(){

        if(
            isset($_SESSION["loginned"])
            && $_SESSION["loginned"] === true
            && isset($_SESSION["username"])
            && isset( $_SESSION["token"])

        ){
            $acount = $this->adminModel->checkLogin($_SESSION["username"],$_SESSION["token"]);
            if(
                $acount !== false
                && count($acount) > 0
            ){

                $this->layout = "dashboardLayout";
                header("Location:"."http://".HOST."/dashboard");
            }
        }
        else{
            // echo("saiudhu");
            $this->layout = 'acountLayout';
            $this->render("getLogin");

        }

    }

    public function postLogin()
    {
        $username = $_POST["username"];
        $password = $_POST["password"];

        $acount = $this->adminModel->fetchAcount($username,$password);
        if(!$acount || $acount === []){

            $data["message"] = "Username or password are invalid!";
            $data["inputted"] = ["username" => $username, "password" => $password];
            $this->set($data);
            $_SERVER["REQUEST_METHOD"] = "GET";
            $this->getLogin();
        }
        else{

            $_SESSION["loginned"] = true;
            $_SESSION["username"] = $acount["username"];
            $_SESSION["token"] = $acount["password"];
            $_SESSION["role"] = $acount["role_id"];

            setcookie("x-access-token",'u='.$acount["username"].'&token='.$acount["password"], time() + (86400 * 30), "/");
            $this->layout = "dasboardLayout";
            header("Location:"."http://".HOST."/dashboard");
        }
    }

    public function logout(){

        $_SESSION["loginned"] = false;
        unset($_SESSION["username"]);
        unset($_SESSION["token"]);
        unset($_SESSION["role"]);
        confirm("use are logged out");
        header("Location:"."http://".HOST."/home");

    }
    public function getManageSite($userInfor){

        $this->render("getManagerSite");



    }

    public function createAdmin()
    {
        $roles = $this->adminModel->getRoles();
        $data["roles"] = $roles;
        $this->set($data);
        $this->render("createAdmin");
    }

    public function storeAdmin()
    {
        $username = $_POST["username"];
        $password = $_POST["password"];
        $displayName = $_POST["displayname"];
        $role_id = $_POST["role"];
        $acount = $this->adminModel->getAcount($username,$password);
        $newAcount = [
            "username" => $username,
            "password" => $password,
            "name" =>  $displayName,
            "role_id" => $role_id
        ];
        if(!isset($acount) || !$acount || $acount === []){

            $newAcount = [
                "username" => $username,
                "password" => $password,
                "name" =>  $displayName,
                "role_id" => $role_id
            ];

            $storedAcount = $this->adminModel->storeStaff($newAcount);
            if($storedAcount){

                alert("The account is stored");
                header("Location:"."http://".HOST."/dashboard");
            }
        }
        else{
            $data["inputted"] = [
                    "username" => $username,
                    "password" => $password,
                    "name" =>  $displayName,
                    "role_id" => $role_id
            ];
            $data["message"] = "The usename is already in use, please try an other";
            $_SERVER["REQUEST_METHOD"] = "GET";
            $this->set($data);
            $this->createAdmin();
        }

    }
}









?>