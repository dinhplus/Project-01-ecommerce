<?php
use Controller\BaseController as Controller;
class TestController extends Controller{
    public function __construct() {
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
