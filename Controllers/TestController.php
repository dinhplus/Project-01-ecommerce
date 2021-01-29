<?php
use Controller\BaseController as Controller;

require_once(ROOT."Models/User.php");
class TestController extends Controller{
    public function __construct() {
        $_POST = $this->secure_form($_POST);
        $_GET = $this->secure_form($_GET);
        $_REQUEST = $this->secure_form($_REQUEST);
        $this->layout = "defaultAplication";
    }
    public function index(){

        if($_GET["name"]&&$_GET["name"]!=""){
            $data["name"] = $_GET["name"];
        }

        if($data["name"]){
            $this->set($data);

        }
        $this->render("index");



    }
    public function getForm(){

    }

}
