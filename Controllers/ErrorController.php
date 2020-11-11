<?php
use Controller\BaseController as Controller;
class ErrorController extends  Controller{
   public function __construct() {
       $this->layout = "Error";
   }
    public function notFound(){
        $this->render("404");
    }
}