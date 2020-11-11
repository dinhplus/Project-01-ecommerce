<?php
use Controller\BaseController as Controller;
class adminController extends Controller {

    public function __construct() {
        $this->layout = "adminAplication";
    }

}