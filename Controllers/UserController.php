<?php
use Controller\BaseController as Controller;
class UserController extends Controller{
    public function __construct(){
        $this->layout = "acountLayout";
    }
    public function getLogin(){
        $this->render("getLogin");
    }

    function postLogin()
    {

    }



}









?>