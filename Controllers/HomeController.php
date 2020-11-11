<?php

use Controller\BaseController as Controller;

class HomeController extends Controller
{
    public function __construct()
    {
        $this->layout = "defaultAplication";
    }
    public function index()
    {
        echo "This is Home";
    }
}
