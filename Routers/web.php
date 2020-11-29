<?php
Router::GET( "/dashboard/admin-manager/create-admin", "AdminController@createAdmin");
Router::POST( "/dashboard/admin-manager/store-admin","AdminController@storeAdmin");
Router::GET("/dashboard/login", "AdminController@getLogin");
Router::POST("/dashboard/login", "AdminController@postLogin");
Router::GET("/dashboard/logout", "AdminController@logout");






Router::GET("/acount/login","UserController@getLogin");
Router::POST("/acount/login","UserController@postLogin");

Router::GET("/acount/register","UserController@getRegister");
Router::POST("/acount/register","UserController@storeUser");

Router::GET("/home","HomeController@index");
Router::GET("/","HomeController@index");

Router::GET("/manager","ManagerController@index");
Router::GET("/manager/product","ManagerController@index");
Router::GET("/manager/create-product", "ManagerController@createProduct");
Router::POST("/manager/store-product", "ManagerController@storeProduct");

Router::GET("/posts","PostController@index");
Router::GET("/test","TestController@index");

// Router::GET("/posts/detail/$id","PostController@show");
Router::GET("/posts/create","PostController@create");
Router::POST("/posts/create","PostController@postCreate");
