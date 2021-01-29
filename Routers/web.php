<?php
Router::GET("/dashboard/register", function(){
    echo("<h1 style='color: red; align: center; v-align: center'> There is no register method for staff. Please contact your administrator🤗🤗🤗🤗🤗🤗🤗🤗</h1>");
});

Router::GET("/dashboard", "AdminController@index");

Router::GET( "/dashboard/admin-manager/create-admin", "AdminController@createAdmin");
Router::POST( "/dashboard/admin-manager/create-admin","AdminController@storeAdmin");

Router::GET("/dashboard/login", "AdminController@getLogin");
Router::POST("/dashboard/login", "AdminController@postLogin");

Router::GET("/dashboard/logout", "AdminController@logout");

Router::GET("/dashboard/admin-manager/change-password","AdminController@editPassword");
Router::POST("/dashboard/admin-manager/change-password", "AdminController@updatePassword");

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
Router::GET("/dashboard/product-manager/category-manage", "ProductController@showCategoryManage");
Router::POST("/dashboard/product-manager/add-category", "ProductController@storeCategory");
Router::POST("/dashboard/product-manager/delete-category", "ProductController@deleteCategory");
Router::POST("/dashboard/product-manager/update-category", "ProductController@updateCategory");

Router::GET("/dashboard/product-manager/brand-manage", "ProductController@showBrandManage");
Router::POST("/dashboard/product-manager/add-brand", "ProductController@storeBrand");
Router::POST("/dashboard/product-manager/delete-brand", "ProductController@deleteBrand");
Router::POST("/dashboard/product-manager/update-brand", "ProductController@updateBrand");


//FEATURE order:
Router::GET("/dashboard/order-manager/index", "OrderController@index");
Router::GET("/dashboard/order-manager", "OrderController@index");
Router::GET("/dashboard/order-manager/order-detail", "OrderController@showOrderDetail");
Router::POST("/dashboard/order-manager/change-status", "OrderController@changeOrderStatus");
Router::GET("/dashboard/order-manager/pending", "OrderController@getPendingOrder");
Router::GET("/dashboard/order-manager/processing", "OrderController@getProcessingOrder");
Router::GET("/dashboard/order-manager/cancelled", "OrderController@getCancelledOrder");
Router::GET("/dashboard/order-manager/completed", "OrderController@getCompletedOrder");
Router::POST("/dashboard/order-manager/add-item", "OrderController@addItem");
Router::GET( "/dashboard/order-manager/confirm-new-order", "OrderController@getConfirmOrder");
Router::POST( "/dashboard/order-manager/generate-order", "OrderController@generateOrder");
Router::POST("/dashboard/order-manager/update-temp-item-quantity", "OrderController@updateTempItemQuantity");
Router::POST("/dashboard/order-manager/delete-temp-item",  "OrderController@deleteTempItem");
Router::GET("/dashboard/order-manager/clean-up-temp-cart", "OrderController@cleanUpTempCart");

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
Router::POST("/user/change-password", "ClientController@updatePassword");
Router::GET("/user/order/list", "ClientController@showOrders");
Router::GET("/user/order/show", "ClientController@showOrderDetail");
Router::POST("/user/order/cancel", "ClientController@cancelOrder");

Router::GET("/cart/show-cart", "CartController@showCart");
Router::GET("/cart/add-item", "CartController@addItem");
Router::POST("/cart/update-quantity", "CartController@updateItemQuantity");
Router::GET("/cart/delete-item",  "CartController@deleteItem");
Router::GET("/cart/clean-up", "CartController@cleanUpCart");
Router::GET( "/cart/get-confirm",  "CartController@confirmOrder");
Router::POST("/cart/push-confirm", "CartController@pushOrder");
