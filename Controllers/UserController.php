<?php
use Controller\BaseController as Controller;
require_once(ROOT."Models/User.php");
class UserController extends Controller{

    public function __construct(){
        $this->layout = "acountLayout";
        $this->userModel = new User();
    }
    public function getLogin(){
        if(isset($_COOKIE["username"])){
            header("Location:"."http://".HOST);
        }
        $this->render("getLogin");
    }

    public function postLogin()
    {
        $username = $_POST["username"];
        $password = $_POST["password"];

        $user = $this->userModel->fetchUser($username,$password);
        // $userClone = $user;
        // var_dump($user);
        if(!$user || $user === []){

            $data["message"] = "Username or password are invalid!";
            $this->set($data);
            // $this->render("getLogin");
            // header("Location:"."http://".HOST."/acount/login");
            $this->getLogin();
        }
        else{
            $userInfor = [
                "username"=> $user["username"],
                "user_level" => $user["user_level"],

            ];

            setcookie("username",$userInfor["username"], time() + (86400 * 7), "/");
            setcookie("user_level",$userInfor["user_level"], time() + (86400 * 7), "/");
            // setcookie("username",$userInfor["username"], time() + (86400 * 7), "/");
            header("Location:"."http://".HOST);
        }
    }

    public function getManageSite($userInfor){

        $this->render("getManagerSite");



    }

    public function getRegister()
    {
        $this->render("getRegister");
    }

    public function storeUser()
    {
        $username = $_POST["username"];
        $password = $_POST["password"];

        $user = $this->userModel->fetchUser($username,$password);

        if(!$user || $user === []){

            $acount = [
                "username" => $username,
                "password" => $password,
                "email" => null,
                "birthdate" => null,
                "address" => null,
                "phone" => null,
                "avatar_ref" => null,
                "user_level" => 1
            ];
            $storedUser = $this->userModel->storeUser($acount);


            setcookie("username",$acount["username"], time() + (86400 * 7), "/");
            setcookie("user_level",$acount["user_level"], time() + (86400 * 7), "/");
            // setcookie("username",$userInfor["username"], time() + (86400 * 7), "/");
            header("Location:"."http://".HOST);

        }
        else{

            $data["message"] = "The usename is already in use, please try an other";
            $this->set($data);
            // $this->render("getLogin");
            header("Location:"."http://".HOST."/acount/register");

        }

    }
}









?>