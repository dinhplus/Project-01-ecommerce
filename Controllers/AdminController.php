<?php
use Controller\BaseController as Controller;
require_once(ROOT."Models/Admin.php");
class AdminController extends Controller{

    public function __construct(){
        $this->layout = "dashboardLayout";
        $this->adminModel = new Admin();
    }

    public function index(){
        $account = $this->checkLogin();
        if(!$account){
            header("Location:"."http://".HOST."/dashboard/login");
        }
        else{
            $this->layout = "dashboardLayout";
            $this->render("getDashboard");
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
            $account = $this->adminModel->checkLogin($_SESSION["username"], $_SESSION["token"]);
            if($account !== false && count($account) > 0 ){
                $checkLogin = $account;
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

        $account = $this->checkLogin();
        if(!$account){
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
        $account = $this->adminModel->fetchAccount($username,$password);
        if(!$account || $account === []){
            $data["message"] = "Username or password are invalid!";
            $data["inputted"] = ["username" => $username, "password" => $password];
            $_SERVER["REQUEST_METHOD"] = "GET";
            $this->set($data);
            $this->getLogin();
        }
        else if( $account["role_id"] == 0){
            $this->popup("/home","This acount is deactived. Please contact Admin/technical!!");
        }
        else{
            $_SESSION["loginned"] = true;
            $_SESSION["uid"] = $account["id"];
            $_SESSION["username"] = $account["username"];
            $_SESSION["token"] = $account["password"];
            $_SESSION["role"] = $account["role_id"];
            setcookie("x-access-token",'u='.$account["username"].'&token='.$account["password"], time() + (86400 * 30), "/");
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
        $account = $this->checkLogin();
        // var_dump($account); die();
        if($account["role_id"] > 4 ){
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
        // var_dump($master);
        if(!isset($master["username"])){
            header("Location:"."http://".HOST."/dashboard");
        }
        if($master && $master["role_id"] <= 5){
            echo("<h2>ERROR!!!</h1> <br><h1>This account do not have permision for this action!!!👃🏿👃🏿👃🏿👃🏿 </h2>");
        }
        else{

            $username = $_POST["username"];
            $password = $_POST["password"];
            $displayName = $_POST["displayname"];
            $role_id = $_POST["role"];
            $account = $this->adminModel->getAccount($username,$password);
            $newAccount = [
                "username" => $username,
                "password" => $password,
                "name" =>  $displayName,
                "role_id" => $role_id
            ];
            if(!isset($account) || !$account || $account === []){

                $newAccount = [
                    "username" => $username,
                    "password" => $password,
                    "name" =>  $displayName,
                    "role_id" => $role_id
                ];

                $storedAccount = $this->adminModel->storeStaff($newAccount);
                if($storedAccount){

                    $this->popup("/dashboard","<h1>New staff has been stored !!</h1>");
                }
                else{
                    $this->popup("/dashboard","<h1>  Unexpected exception. Update Store staff failed  !!</h1>");
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
        $accountLoginned = $this->checkLogin();
        if($accountLoginned && $accountLoginned["id"]){
            $this->layout = "dashboardLayout";
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
        $password = password_hash($_POST["password"],PASSWORD_DEFAULT);
        $username = $_SESSION["username"];

        $account = $this->adminModel->fetchAccount($username, $currentPassword);
        // var_dump($account);
        if(!$account){
            $data["message"] = "Current password inputted is invalid 🦖🦖🦖!!!";
            $_SERVER["METHOD"] = "GET";
            $this->set($data);
            $this->editPassword();
        } else{
            $account["password"] = $password;
            $onUpdate = $this->adminModel->updateAccount($account);
            if($onUpdate){
                $this->popup("/dashboard","Your Password has been changed!");
            }
        }
    }

    public function showAdmin()
    {
        $accountLoginned = $this->checkLogin();
        $accountRecords = $this->adminModel->getAccountRecord();
        if(!$accountLoginned){
            header("Location:"."http://".HOST."/dashboard/login");
        }
        else
        {
            $this->layout = "dashboardLayout";
            $accountRecords = $this->adminModel->getAccountRecord();
            // var_dump($accountRecords);
            $data["accountLoginned"] = $accountLoginned;
            $data["records"] = $accountRecords;
            $this->set($data);
            $this->render("index");
        }
    }

    public function editStaff()
    {
        $accountLoginned = $this->checkLogin();
        if(!$accountLoginned){
            header("Location:"."http://".HOST."/dashboard/login");
        }
        $uid = $_GET["uid"];
        if($uid && ($_GET["uid"] === $accountLoginned["id"] || $accountLoginned["role_id"] > 4)){
            $currentAccount = $this->adminModel->getAccountById($uid);
            if(!$accountLoginned){
                $this->popup("/dashboard/admin-manager","This account do not existed : <br> uid = ".$accountLoginned["username"]);
            }
            else{
                $_SESSION["uid-editting"] = $currentAccount["id"];
                $roles = $this->adminModel->getRoles();
                $data["currentAccount"] = $currentAccount;
                $data["accountLoginned"] = $accountLoginned;
                $data["roles"] = $roles;
                $this->set($data);
                $this->render("getEditAdmin");
            }
        }
        else {
            $this->popup("/dashboard/admin-manager","You do not have permission to edit this account : <br> Username:".$accountLoginned["username"]);
        }
    }
    public function updateStaff()
    {
        $accountLoginned = $this->checkLogin();
        if(!$accountLoginned){
            $this->popup("/dashboard/login","Sorry <br> Please login to continute this action");
        }
        else{
            $uid = $_SESSION["uid-editting"];
            unset($_SESSION["uid-editting"]);
            $temp = $this->adminModel->getAccountById($uid);
            $temp["role_id"] = $_POST["role"];
            $temp["name"] = $_POST["name"];
            $onUpdate = $this->adminModel->updateAccount($temp);
            if($onUpdate){
                $this->popup("/dashboard/admin-manager","<h1>Update Staff Success</h1>");
            }
            else{
                $this->popup("/dashboard/admin-manager","<h1>Update Staff Failed</h1>");
            }
        }
    }
    public function deleteStaff(){
        $accountLoginned = $this->checkLogin();
        if(!$accountLoginned){
            $this->popup("/dashboard/login","Sorry <br> Please login to continute this action");
        }
        else if($accountLoginned["role_id"] < 5){
            $this->popup("/dashboard/admin-manager","Sorry <br> You do not have permission to implement this action");
        }
        else{
            $uid = $_POST["staff-id"];
            $onDelete = $this->adminModel->deleteStaff($uid);
            if($onDelete){
                header("Location:"."http://".HOST."/dashboard/admin-manager");
            }
        }
    }
}
