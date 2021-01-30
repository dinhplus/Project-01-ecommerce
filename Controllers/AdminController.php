<?php

use Controller\BaseController as Controller;

require_once(ROOT . "Models/Admin.php");
require_once(ROOT . "Models/Customer.php");
class AdminController extends Controller
{

    public function __construct()
    {
        $_POST = $this->secure_form($_POST);
        $_GET = $this->secure_form($_GET);
        $_REQUEST = $this->secure_form($_REQUEST);
        $this->layout = "dashboardLayout";
        $this->adminModel = new Admin();
        $this->customerModel = new Customer();
    }

    public function index()
    {
        try {
            $account = $this->checkLogin();
            if (!$account) {
                header("Location:" . "http://" . HOST . "/dashboard/login");
            } else {
                $this->layout = "dashboardLayout";
                $this->render("getDashboard");
            }
        } catch (Exception $th) {
            throw $th;
        }
    }
    public function resetPassword(){
        try {


            $master = $this->checkLogin();
            // var_dump($master);
            if (!$master) {
                $this->popup("/dashboard/login", "Please login before do anything </h2>");
            }
            if ($master && $master["role_id"] <= 5) {
                $this->popup("/dashboard/admin-manager", "<h2>ERROR!!!</h1> <br><h1>This account do not have permision for this action!!!👃🏿👃🏿👃🏿👃🏿 </h2>");
            } else {
                if($_POST["secret-key"] == RESET_STAFF_PASSWORD_SECRET){
                    $user =  $this->adminModel->getAccountById($_POST["uid"]);
                    if($user && count($user) > 0){
                        $user["password"] = password_hash(DEFAULT_PASSWORD_RESET, PASSWORD_DEFAULT);
                        $onReset = $this->adminModel->updateAccount($user);
                        if($onReset){
                            $this->popup("/dashboard/admin-manager", "Reset Password successfully. <br> New password is: ".DEFAULT_PASSWORD_RESET);
                        }
                        else{
                            $this->popup("/dashboard/admin-manager", "Reset Password failed");
                        }
                    }
                    else{
                        $this->popup("/dashboard/admin-manager", "Reset Password failed! This account is not exist");
                    }
                }
                else{
                    $this->popup("/dashboard/admin-manager", "Secret Key is invalid. Please re-check or contact technicians ");
                }
            }
        } catch (Exception $th) {
            throw $th;
        }
    }
    public function checkLogin()
    {
        try {
            $checkLogin = false;
            if (
                isset($_SESSION["loginned"])
                && $_SESSION["loginned"] === true
                && isset($_SESSION["username"])
                && isset($_SESSION["token"])
            ) {
                $account = $this->adminModel->checkLogin($_SESSION["username"], $_SESSION["token"]);
                if ($account !== false && count($account) > 0) {
                    $checkLogin = $account;
                } else {
                    $checkLogin = false;
                }
            } else {
                $checkLogin = false;
            }
            return $checkLogin;
        } catch (Exception $th) {
            throw $th;
        }
    }

    public function getLogin()
    {
        try {
            $account = $this->checkLogin();
            if (!$account) {
                $this->layout = 'blankLayout';
                $this->render("getLogin");
            } else {
                $this->layout = "dashboardLayout";
                header("Location:" . "http://" . HOST . "/dashboard/");
            }
        } catch (Exception $th) {
            throw $th;
        }
    }

    public function postLogin()
    {
        try {
            //code...

            $username = $_POST["username"];
            $password = $_POST["password"];
            if (!(regexUsename($username) && regexPassword($password))) {
                $data["message"] = "Please enter correctly according to the specified form!";
                $data["inputted"] = ["username" => $username, "password" => $password];
                $_SERVER["REQUEST_METHOD"] = "GET";
                $this->set($data);
                $this->getLogin();
                die();
            }
            $account = $this->adminModel->fetchAccount($username, $password);
            if (!$account || $account === []) {
                $data["message"] = "Username or password are invalid!";
                $data["inputted"] = ["username" => $username, "password" => $password];
                $_SERVER["REQUEST_METHOD"] = "GET";
                $this->set($data);
                $this->getLogin();
            } else if ($account["role_id"] == 0) {
                $this->popup("/home", "This acount is deactived. Please contact Admin/technical!!");
            } else {
                $_SESSION["loginned"] = true;
                $_SESSION["uid"] = $account["id"];
                $_SESSION["username"] = $account["username"];
                $_SESSION["token"] = $account["password"];
                $_SESSION["role"] = $account["role_id"];
                setcookie("x-access-token", 'u=' . $account["username"] . '&token=' . $account["password"], time() + (86400 * 30), "/");
                $this->layout = "dasboardLayout";
                header("Location:" . "http://" . HOST . "/dashboard");
            }
        } catch (Exception $th) {
            throw $th;
        }
    }

    public function logout()
    {
        try {
            $_SESSION["loginned"] = false;
            unset($_SESSION["username"]);
            unset($_SESSION["token"]);
            unset($_SESSION["role"]);
            confirm("use are logged out");
            header("Location:" . "http://" . HOST . "/home");
        } catch (Exception $th) {
            throw $th;
        }
    }

    public function createAdmin()
    {
        try {
            $account = $this->checkLogin();
            // var_dump($account); die();

            if ($account["role_id"] > 4) {
                $roles = $this->adminModel->getRoles();
                $data["roles"] = $roles;
                $this->set($data);
                $this->render("createAdmin");
            } else {
                header("Location:" . "http://" . HOST . "/dashboard");
            }
        } catch (Exception $th) {
            throw $th;
        }
    }

    public function storeAdmin()
    {
        try {


            $master = $this->checkLogin();
            // var_dump($master);
            if (!isset($master["username"])) {
                header("Location:" . "http://" . HOST . "/dashboard");
            }
            if ($master && $master["role_id"] <= 5) {
                echo ("<h2>ERROR!!!</h1> <br><h1>This account do not have permision for this action!!!👃🏿👃🏿👃🏿👃🏿 </h2>");
            } else {

                $username = $_POST["username"];
                $password = $_POST["password"];
                $displayName = $_POST["displayname"];
                $role_id = $_POST["role"];
                if (!(regexUsename($username)
                    && regexPassword($password)
                    && isValidName($displayName))) {
                    $data["message"] = "Please enter correctly according to the specified form!";
                    $data["inputted"] = [
                        "username" => $username,
                        "password" => $password,
                        "name" =>  $displayName,
                        "role_id" => $role_id
                    ];
                    $_SERVER["REQUEST_METHOD"] = "GET";
                    $this->set($data);
                    $this->createAdmin();
                    die();
                }
                $account = $this->adminModel->getAccount($username, $password);
                $newAccount = [
                    "username" => $username,
                    "password" => $password,
                    "name" =>  $displayName,
                    "role_id" => $role_id
                ];
                if (!isset($account) || !$account || $account === []) {

                    $newAccount = [
                        "username" => $username,
                        "password" => $password,
                        "name" =>  $displayName,
                        "role_id" => $role_id
                    ];

                    $storedAccount = $this->adminModel->storeStaff($newAccount);
                    if ($storedAccount) {

                        $this->popup("/dashboard", "<h1>New staff has been stored !!</h1>");
                    } else {
                        $this->popup("/dashboard", "<h1>  Unexpected exception. Update Store staff failed  !!</h1>");
                    }
                } else {
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
        } catch (Exception $th) {
            throw $th;
        }
    }

    public function editPassword()
    {
        $accountLoginned = $this->checkLogin();

        if ($accountLoginned && $accountLoginned["id"]) {
            $this->layout = "dashboardLayout";
            $this->render("getEditPassword");
        } else {
            $this->layout = 'blankLayout';
            header("Location:" . "http://" . HOST . "/dashboard/login");
        }
    }
    public function updatePassword()
    {
        $currentPassword = $_POST["current-password"];
        if(!regexPassword($_POST["password"])){
            $data["message"] = "Please enter correctly according to the specified form!";
            $_SERVER["METHOD"] = "GET";
            $this->set($data);
            $this->editPassword();
        }
        $password = password_hash($_POST["password"], PASSWORD_DEFAULT);
        $username = $_SESSION["username"];

        $account = $this->adminModel->fetchAccount($username, $currentPassword);
        // var_dump($account);
        if (!$account) {
            $data["message"] = "Current password inputted is invalid 🦖🦖🦖!!!";
            $_SERVER["METHOD"] = "GET";
            $this->set($data);
            $this->editPassword();
        } else {
            $account["password"] = $password;
            $onUpdate = $this->adminModel->updateAccount($account);
            if ($onUpdate) {
                $this->popup("/dashboard", "Your Password has been changed!");
            }
        }
    }

    public function showAdmin()
    {
        try{

            $accountLoginned = $this->checkLogin();
            // $accountRecords = $this->adminModel->getAccountRecord();
            if (!$accountLoginned) {
                header("Location:" . "http://" . HOST . "/dashboard/login");
            } else {
                $this->layout = "dashboardLayout";
                $username = $_GET["q"] ?? null;

                $accountRecords = $this->adminModel->getAccountRecord($username);
                // var_dump($accountRecords);
                $data["enableSearch"] = true;
                $data["accountLoginned"] = $accountLoginned;
                $data["records"] = $accountRecords;
                $this->set($data);
                $this->render("index");
            }
        }
        catch(Exception $e){
            pd($e);
        }
    }

    public function editStaff()
    {
        try {
            $accountLoginned = $this->checkLogin();
            if (!$accountLoginned) {
                header("Location:" . "http://" . HOST . "/dashboard/login");
            }
            $uid = $_GET["uid"];
            if ($uid && ($_GET["uid"] === $accountLoginned["id"] || $accountLoginned["role_id"] > 4)) {
                $currentAccount = $this->adminModel->getAccountById($uid);
                if (!$currentAccount) {
                    $this->popup("/dashboard/admin-manager", "This account do not existed : <br> uid = " . $_GET["uid"]);
                } else {
                    $_SESSION["uid-editting"] = $currentAccount["id"];
                    $roles = $this->adminModel->getRoles();
                    $data["currentAccount"] = $currentAccount;
                    $data["accountLoginned"] = $accountLoginned;
                    $data["roles"] = $roles;
                    $this->set($data);
                    $this->render("getEditAdmin");
                }
            } else {
                $this->popup("/dashboard/admin-manager", "You do not have permission to edit this account : <br> Username:" . $accountLoginned["username"]);
            }
        } catch (Exception $th) {
            throw $th;
        }
    }
    public function updateStaff()
    {
        try {
            $accountLoginned = $this->checkLogin();
            if (!$accountLoginned) {
                $this->popup("/dashboard/login", "Sorry <br> Please login to continute this action");
            } else {
                $uid = $_SESSION["uid-editting"];
                unset($_SESSION["uid-editting"]);
                $temp = $this->adminModel->getAccountById($uid);
                if (intval($_POST["role"]) > intval($temp["role_id"])) {
                    $temp["role_id"] = $temp["role_id"];
                } else {
                    $temp["role_id"] = $_POST["role"];
                }
                $temp["name"] = $_POST["name"];
                $onUpdate = $this->adminModel->updateAccount($temp);
                if ($onUpdate) {
                    $this->popup("/dashboard/admin-manager", "<h1>Update Staff Success</h1>");
                } else {
                    $this->popup("/dashboard/admin-manager", "<h1>Update Staff Failed</h1>");
                }
            }
        } catch (Exception $th) {
            throw $th;
        }
    }
    public function deleteStaff()
    {
        try {

            $accountLoginned = $this->checkLogin();
            if (!$accountLoginned) {
                $this->popup("/dashboard/login", "Sorry <br> Please login to continute this action");
            } else if ($accountLoginned["role_id"] < 5) {
                $this->popup("/dashboard/admin-manager", "Sorry <br> You do not have permission to implement this action");
            } else {
                $uid = $_POST["staff-id"];
                if ($uid == $accountLoginned["id"]) {
                    $this->popup("/dashboard/admin-manager", "You can not delete your self!");
                }
                $onDelete = $this->adminModel->deleteStaff($uid);
                if ($onDelete) {
                    header("Location:" . "http://" . HOST . "/dashboard/admin-manager");
                }
            }
        } catch (Exception $th) {
            throw $th;
        }
    }
    public function getResetClientPassword()
    {
        try {


            $master = $this->checkLogin();
            // var_dump($master);
            if (!$master) {
                $this->popup("/dashboard/login", "Please login before do anything </h2>");
            }
            if ($master && $master["role_id"] <= 5) {
                $this->popup("/dashboard/admin-manager", "<h2>ERROR!!!</h1> <br><h1>This account do not have permision for this action!!!👃🏿👃🏿👃🏿👃🏿 </h2>");
            } else {
                $filterKey = $_GET["filter"] ?? null;
                $filterResult = $this->customerModel->filterCustomer($filterKey);
                $data["customers"] = $filterResult;
                $this->set($data);
                $this->render("getResetClientPassword");
            }
        } catch (Exception $th) {
            throw $th;
        }
    }
    public function postResetClientPassword()
    {
        try {


            $master = $this->checkLogin();
            // var_dump($master);
            if (!$master) {
                $this->popup("/dashboard/login", "Please login before do anything </h2>");
            }
            if ($master && $master["role_id"] <= 5) {
                $this->popup("/dashboard/admin-manager", "<h2>ERROR!!!</h1> <br><h1>This account do not have permision for this action!!!👃🏿👃🏿👃🏿👃🏿 </h2>");
            } else {
                if($_POST["secret-key"] == RESET_CLIENT_PASSWORD_SECRET){
                    $user =  $this->customerModel->getCustomerByUsername($_POST["username"]);
                    if($user && count($user) > 0){
                        $user["password"] = PASSWORD_DEFAULT;
                        $onReset = $this->customerModel->updateUserPassword($user);
                        if($onReset){
                            $this->popup("/dashboard/client-manager/reset-password", "Reset Password successfully. <br> New password is: ".DEFAULT_PASSWORD_RESET);
                        }
                        else{
                            $this->popup("/dashboard/client-manager/reset-password", "Reset Password failed");
                        }
                    }
                    else{
                        $this->popup("/dashboard/client-manager/reset-password", "Reset Password failed! This account is not exist");
                    }
                }
                else{
                    $this->popup("/dashboard", "Secret Key is invalid. Please re-check or contact technicians ");
                }
            }
        } catch (Exception $th) {
            throw $th;
        }
    }
}
