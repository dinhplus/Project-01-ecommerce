<?php
class Request
{
    public $url;
    public $method;

    public function __construct()
    {
        $this->url = $_SERVER["REQUEST_URI"];
        $this->method = $_SERVER["REQUEST_METHOD"];
        // $this->header = getallheaders();
        // var_dump( $this->header);

        // foreach (getallheaders() as $name => $value) {
        //     echo "$name: $value\n";
        // }
    }
}
