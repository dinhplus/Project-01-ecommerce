<?php

Router::GET("/acount/login","UserController@getLogin");
Router::POST("/acount/login","UserController@postLogin");

Router::GET("/home","HomeController@index");
Router::GET("/","HomeController@index");



Router::GET("/posts","PostController@index");
Router::GET("/test","TestController@index");

// Router::GET("/posts/detail/$id","PostController@show");
Router::GET("/posts/create","PostController@create");
Router::POST("/posts/create","PostController@postCreate");
