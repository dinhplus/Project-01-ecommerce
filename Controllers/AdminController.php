<?php
use Controller\BaseController as Controller;
require_once(ROOT."Models/Admin.php");
class AdminController extends Controller{

    public function __construct(){
        $this->layout = "dashboardLayout";
        $this->adminModel = new Admin();
    }

    public function index(){
        $acount = $this->checkLogin();
        if(!$acount){
            header("Location:"."http://".HOST."/dashboard/login");
        }
        else{
            $this->layout = "dashboardLayout";
            $this->render("index");
        }
    }

    public function checkLogin(){
        $checkLogin = false;
        if(
            isset($_SESSION["loginned"])
            && $_SESSION["loginned"] === true
            && isset($_SESSION["username"])
            && isset( $_SESSION["token"])
        ){
            $acount = $this->adminModel->checkLogin($_SESSION["username"], $_SESSION["token"]);
            if($acount !== false && count($acount) > 0 ){
                $checkLogin = $acount;
            }
            else{
                $checkLogin = false;
            }
        }
        else{
            $checkLogin = false;
        }
        return $checkLogin;
    }

    public function getLogin(){

        $acount = $this->checkLogin();
        if(!$acount){
            $this->layout = 'blankLayout';
            $this->render("getLogin");
        }
        else{
            $this->layout = "dashboardLayout";
                header("Location:"."http://".HOST."/dashboard/");
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
            $_SERVER["REQUEST_METHOD"] = "GET";
            $this->set($data);
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

    public function createAdmin(){
        $acount = $this->checkLogin();
        if($acount["role_id" > 4] ){
            $roles = $this->adminModel->getRoles();
            $data["roles"] = $roles;
            $this->set($data);
            $this->render("createAdmin");
        }
        else{
            header("Location:"."http://".HOST."/dashboard");
        }

    }

    public function storeAdmin(){
        $master = $this->checkLogin();
        if($master["role_id"] <= 5){
            echo("<h2>ERROR!!!</h1> <br><h1>This acount do not have permision for this action!!!👃🏿👃🏿👃🏿👃🏿 </h2>");
        }
        else{

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

    public function editPassword()
    {
        $acountLoginned = $this->checkLogin();
        if($acountLoginned && $acountLoginned["id"]){
            $this->layout = "blankLayout";
            $this-> render("getEditPassword");
        }
        else{
            $this->layout = 'blankLayout';
            header("Location:"."http://".HOST."/dashboard/login");
        }
    }
    public function updatePassword()
    {
        $currentPassword = $_POST["current-password"];
        $password = $_POST["password"];
        $username = $_SESSION["username"];

        $acount = $this->adminModel->fetchAcount($username, $currentPassword);
        // var_dump($acount);
        if(!$acount){
            $data["message"] = "Current password inputted is invalid 🦖🦖🦖!!!";
            $_SERVER["METHOD"] = "GET";
            $this->set($data);
            $this->editPassword();
        } else{
            $acount["password"] = $password;
            $onUpdate = $this->adminModel->updateAcount($acount);
            if($onUpdate){

                $this->popup("/dashboard","Your Password has been changed!");
                // header("Location:"."http://".HOST."/dashboard");
            }
        }




    }



}







?>