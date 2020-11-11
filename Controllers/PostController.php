<?php
use Controller\BaseController as Controller;
class PostController extends Controller{
    public function __construct() {
        $this->layout = "defaultAplication";
    }
    public function index(){
        $this->render("index");
    }
}
