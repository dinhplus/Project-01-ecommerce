<?php

Router::GET("/acount/login","UserController@getLogin");
Router::POST("/acount/login","UserController@postLogin");




Router::GET("/posts/callback",function(){
    echo "Req";
    echo(json_encode($_REQUEST));
    echo("<br>server<br>");
    echo(json_encode($_SERVER));
    echo("<br>GET<br>");
    echo(json_encode($_GET));
});
Router::GET("/home","HomeController@index");
Router::GET("/posts","PostController@index");
Router::GET("/test","TestController@index");

// Router::GET("/posts/detail/$id","PostController@show");
Router::GET("/posts/create","PostController@create");
Router::POST("/posts/create","PostController@postCreate");
