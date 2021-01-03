<?php
Router::GET("/dashboard/register", function(){
    echo("<h1 style='color: red; align: center; v-align: center'> This site just a joke!!! LOL🤗🤗🤗🤗🤗🤗🤗🤗</h1>");
});

Router::GET("/dashboard", "AdminController@index");

Router::GET( "/dashboard/admin-manager/create-admin", "AdminController@createAdmin");
Router::POST( "/dashboard/admin-manager/create-admin","AdminController@storeAdmin");

Router::GET("/dashboard/login", "AdminController@getLogin");
Router::POST("/dashboard/login", "AdminController@postLogin");

Router::GET("/dashboard/logout", "AdminController@logout");

Router::GET("/dashboard/admin-manager/change-password","AdminController@editPassword");
Router::POST("/dashboard/admin-manager/update-password", "AdminController@updatePassword");

Router::GET("/dashboard/admin-manager/index","AdminController@showAdmin");
Router::GET("/dashboard/admin-manager","AdminController@showAdmin");

Router::GET("/dashboard/admin-manager/edit-staff","AdminController@editStaff");
Router::POST("/dashboard/admin-manager/edit-staff","AdminController@updateStaff");

Router::POST("/dashboard/admin-manager/delete-staff", "AdminController@deleteStaff");

Router::GET("/dashboard/product-manager/index",  "ProductController@index");
Router::GET("/dashboard/product-manager",  "ProductController@index");

Router::GET("/dashboard/product-manager/create-product", "ProductController@createProduct");
Router::POST("/dashboard/product-manager/create-product", "ProductController@storeProduct");

Router::POST( "/dashboard/product-manager/delete-product",  "ProductController@deleteProduct");

Router::GET("/dashboard/product-manager/remainder", "ProductController@productRemainder");

Router::GET("/dashboard/product-manager/product-detail", "ProductController@showProductDetail" );


Router::GET("/dashboard/product-manager/edit-product", "ProductController@editProduct");
Router::POST("/dashboard/product-manager/edit-product", "ProductController@updateProduct");

//TODO : Do implement feature later
// Router::GET("/dashboard/product-manager/add-category", "ProductController@createCategory");
// Router::POST("/dashboard/product-manager/add-category", "ProductController@storeCategory");

// Router::GET("/dashboard/product-manager/add-brand", "ProductController@createBrand");
// Router::POST("/dashboard/product-manager/add-brand", "ProductController@storeBrand");


Router::GET("/dashboard/order-manager/index", "OrderController@index");
Router::GET("/dashboard/order-manager", "OrderController@index");
Router::GET("/dashboard/order-manager/order-detail", "OrderController@showOrderDetail");
Router::POST("/dashboard/order-manager/change-status", "OrderController@changeOrderStatus");
Router::GET("/dashboard/order-manager/pending", "OrderController@getPendingOrder");
Router::GET("/dashboard/order-manager/processing", "OrderController@getProcessingOrder");
Router::GET("/dashboard/order-manager/cancelled", "OrderController@getCancelledOrder");
Router::GET("/dashboard/order-manager/completed", "OrderController@getCompletedOrder");
Router::GET( "/dashboard/order-manager/create-order", "OrderController@getCreateOrder");
Router::POST( "/dashboard/order-manager/create-order", "OrderController@generateOrder");


Router::GET("/product/index", "ClientController@listProduct");
Router::GET("/product", "ClientController@listProduct");
Router::GET("/home", "ClientController@listProduct");
Router::GET("/", "ClientController@listProduct");
Router::GET("/product/detail","ClientController@productDetail");
Router::POST("/user/register",   "ClientController@storeUser");
Router::GET("/user/register",   "ClientController@getRegister");
Router::POST("/user/login", "ClientController@postLogin");
Router::GET("/user/login", "ClientController@getLogin");
Router::GET("/user/logout", "ClientController@getLogout");
Router::GET("/user/show-profile", "ClientController@showProfile");
Router::GET( "/user/edit-profile", "ClientController@editUserProfile");
Router::POST("/user/update-profile",  "ClientController@updateUserProfile");
Router::GET("/user/change-password", "ClientController@getChangePassword");
Router::POST("/user/update-password", "ClientController@updatePassword");

Router::GET("/user/order/list", "ClientController@showOrders");
Router::GET("/user/order/show", "ClientController@showOrderDetail");







Router::GET("/quick-checker", function(){
    dd($_GET["check"]);

});
