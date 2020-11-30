#  * Manager
## Admin Controller
1. Login
    ```
    method: GET && POST
    router: "/dashboard/login"
    action: "AdminController@getLogin" && "AdminController@postLogin"
    permistion: "all"
    description: " To be define later"
    ```

2. Logout
    ```
    METHOD: POST
    router: "/dashboard/logout"
    action: "AdminController@logout"
    permistion: "all"
    description: " To be define later"
    ```

3. Show list admin
    ```
    method: GET
    router: "/dashboard/admin-manager/index" || "/dashboard/admin-manager"
    action: "AdminController@showAdmin"
    permistion: "all"
    description: " To be define later"
    ```

4. Show edit ADMIN
    ```
    method: GET
    router: "/dashboard/admin-manager/edit-admin/?id=:id"
    action: "AdminController@editAdmin"
    permistion: "master_admin"
    description: " To be define later"
    ```

5. Update ADMIN
    ```
    method: POST
    router: "/dashboard/admin-manager/update-admin"
    action: "AdminController@updateAdmin"
    permistion: "master_admin"
    description: " To be define later"
    ```

6. create ADMIN
    ```
    method: GET
    router: "/dashboard/admin-manager/create-admin"
    action: "AdminController@createAdmin"
    permistion: "master_admin"
    description: " To be define later"
    ```

7. store ADMIN
    ```
    method: POST
    router: "/dashboard/admin-manager/store-admin"
    action: "AdminController@storeAdmin"
    permistion: "master_admin"
    description: " To be define later"
    ```

8. show admin detail
    ```
    method: GET
    router: "/dashboard/admin-manager/admin-information?id=:id"
    action: "AdminController@storeAdmin"
    permistion: "master_admin/self"
    description: " To be define later"
    ```
9. change admin password

    ```
    method: GET
    router: "/dashboard/admin-manager/change-password?id=:id"
    action: "AdminController@editPassword"
    permistion: "master_admin/self"
    description: " To be define later"
    ```
10. UPDATE ADMIN PASSWORD

    ```
    method: POST
    router: "/dashboard/admin-manager/update-password?id=:id"
    action: "AdminController@updatePassword"
    permistion: "self"
    description: " To be define later"
    ```

##  Product Controller
1. Show All Product
    ```
    method: GET
    router: ("/dashboard/product-manager/index" || "/dashboard/product-manager").("?name=:name&category=:category&page=:page")
    action: "ProductController@index"
    permistion: "all"
    description: " Show all Products and paginate by rule && show permistion"
    ```

2. Add product
    ```
    method: GET
    router: "/dashboard/product-manager/create-product"
    action: "ProductController@createProduct"
    permistion: "master"
    description: " Add new product"
    ```

3. Store Product
    ```
    method: POST
    router: "/dashboard/product-manager/store-product"
    action: "ProductController@storeProduct"
    permistion: "master"
    description: " Store new product into database"
    ```

4. Show Product detail
    ```
    method: GET
    router: "/dashboard/product-manager/product-detail?id=:id"
    action: "ProductController@showProductDetail"
    permistion: "all"
    description: " Show product detail infor"
    ```

5. Edit product
    ```
    method: GET
    router: "/dashboard/product-manager/edit-product"
    action: "ProductController@editProduct"
    permistion: "master"
    description: " Get product infor from database then show all to `editProduct site`"
    ```

6. Store Product
    ```
    method: POST
    router: "/dashboard/product-manager/update-product"
    action: "ProductController@updateProduct"
    permistion: "master"
    description: " update product base on product_id"
    ```

7. Delete product from database
    ```
    method: POST
    router: "/dashboard/product-manager/delete-product"
    action: "ProductController@deleteProduct"
    permistion: "master"
    description: " confirm again with admin then delete product base on product_id"
    ```

8. Release product
    ```
    method: POST
    router: "/dashboard/product-manager/release-product?id=:id"
    action: "ProductController@changeProductStatus"
    permistion: "master"
    description: " upate product status base on product_id"
    ```
## Pre-Product Controller (High level feature, will complete if have enough time)

1. Show all pre-product
    ```
    method: GET
    router: ("/dashboard/pre-product/index" || "/dashboard/pre-product").("?name=:name&category=:category&page=:page")
    action: "PreProductController@preProductIndex"
    permistion: "all"
    description: " Show all Pre-Products and paginate by rule && show permistion"
    ```

2. Add Pre-product
    ```
    method: GET
    router: "/dashboard/pre-product/create-product"
    action: "PreProductController@createPreProduct"
    permistion: "all"
    description: " Add new Pre product"
    notice: "Employee (not master) from `Product-Manager/index` when click create-product button will redirect to this page,<br> the product will store into 'pre_products' table, by master_admin confirm product,<br> the product will  insert this product into 'products' table then release"
    ```

3. Store Product
    ```
    method: POST
    router: "/dashboard/pre-product/store-product"
    action: "PreProductController@storePreProduct"
    permistion: "all"
    description: " Store new pre product into database"
    ```

4. Show Pre-Product detail
    ```
    method: GET
    router: "/dashboard/pre-product/product-detail?id=:id"
    action: "PreProductController@showPreProductDetail"
    permistion: "all"
    description: " Show product detail infor"
    ```

5. Edit Pre-Product
    ```
    method: GET
    router: "/dashboard/pre-product/edit-product"
    action: "PreProductController@editPreProduct"
    permistion: "all"
    description: " Get product infor from database then show all to `editProduct site`"
    notice: "Employee (not master) from `Product-Manager/index` when click edit-product button will redirect to this page, the product will store into 'pre_products' table, by master_admin confirm product, the product will  update 'products' table then release"
    ```

6. Store Pre-Product
    ```
    method: POST
    router: "/dashboard/pre-product/update-product"
    action: "PreProductController@storePreProduct"
    permistion: "all"
    description: " update pre-product base on pre_product_id"
    ```

7. Delete Pre-product from database
    ```
    method: POST
    router: "/dashboard/pre-product/delete-product"
    action: "PreProductController@deletePreProduct"
    permistion: "all"
    description: " confirm again with admin then delete this pre-product base on pre_product_id"
    ```

8. Confirm pre-product
    ```
    method: POST
    router: "/dashboard/pre-product/confirm-product"
    action: "PreProductController@confirmPreProduct"
    permistion: "all"
    description: " confirm again with admin then insert/update this pre-product into 'products' table base on product_id && pre_product_id"
    ```
## Order Controller

1. The Order Queue (Index)
    ```
    method: GET
    router: ("/dashboard/orders/index" || "/dashboard/orders").("?oid=:oid&cid:cid")
    action: "OrderController@index"
    permistion: "all"
    description: " Show all Order and paginate by rule && show permistion"
    ```

2. Show Order Detail
    ```
    method: GET
    router: "/dashboard/orders/oder-detail?oid=:oid"
    action: "OrderController@showOrderDetail"
    permistion: "all"
    description: " Show All information from this order, include product{name, category, unit_price, order_quantity}, total price, order_time"
    ```

3. Confirm Order
    ```
    method: POST
    router: "/dashboard/orders/confirm-order?oid=:oid"
    action: "OrderController@confirmOrder"
    permistion: "all"
    description: " By confirm this order, the bill will generate, the Shop will prepare for package then send the package  "
    ```

4. Cancel Order
    ```
    method: POST
    router: "/dashboard/orders/cancel-order?oid=:oid"
    action: "OrderController@cancelOrder"
    permistion: "master/manager"
    description: " The master_admin/(manager) can cancel the Oder while the shop can not complete the Order  "
    ```

5. Generate new Order

    ```
    method: GET && POST
    router: "/dashboard/orders/genarate-order"
    action: "OrderController@generateOrder"
    permistion: "All"
    description: " All employee can create new Order base on information what collected from other channel"
    ```
## Dashboard analyze Controller (High level feature)

### Expect Feature
        ```
        1. total revenue week, month, year
        2. each Product quantity of output sold per week, month, year
        3. real income from each product
        ```

# * Client

## Customer Controller
    ```
        Authenticate by user session
    ```
1. Show all product and search

    ```
    method: GET
    router: "/" || "/home" || "/product/index"
    action: "ClientController@listProduct"
    permistion: "all"
    description: "Show all product 'on sale' status"
    ```

2. Show Product Detail

    ```
    method: GET
    router: "/product/detail"
    action: "ClientController@productDetail"
    permistion: "all"
    description: "Show all product information with out quantity extant"
    ```
3. get Register

    ```
    method: GET
    router: "/user/register"
    action: "ClientController@getRegister"
    permistion: "undefined client"
    description: "redirect to login page"
    ```
4. Post Register
    ```
    method: POST
    router: "/user/register"
    action: "ClientController@storeUser"
    permistion: "undefined client"
    description: "post register infor then auto login"
    ```

5. Show self profile
    ```
    method: GET
    router: "/user/show-profile?uid:uid"
    action: "ClientController@showProfile"
    permistion: "self user"
    description: "get customer profile then show on client"
    ```

6. Edit Sefl profile
    ```
    method: GET
    router: "/user/edit-profile?uid=:uid"
    action: "ClientController@editUserProfile"
    permistion: "self user"
    description: "get customer profile then render into 'edit-user-profile'"
    ```
7. Update user profile
    ```
    method: POST
    router: "/user/update-profile?uid=:uid"
    action: "ClientController@updateUserProfile"
    permistion: "self user"
    description: "update userProfile on database base on customer_id"
    ```
8. Show Order list

    ```
    method: GET
    router: "/user/order?uid=:uid"
    action: "ClientController@showOrders"
    permistion: "self user"
    description: "show all order for this customer with status , linked to Order detail"
    ```
9. Show Order list

    ```
    method: GET
    router: "/user/order?uid=:uid&oid=:oid"
    action: "ClientController@showOrderDetail"
    permistion: "self user"
    description: "show all information for this Order"
    ```
## Cart Controller

1. Show cart

    ```
    method: get
    router: "/cart/show-cart?uid=:uid"
    action: "CartController@showCart"
    permistion: "self user"
    description: "Show all product with more infor which added to cart"
    ```
2. add to cart

    ```
    method: POST
    router: "/cart/add-item?uid=:uid"
    action: "CartController@addItem"
    permistion: "self user"
    description: "Add product to cart"
    ```
3. update product quantity in cart

    ```
    method: POST
    router: "/cart/update-quantity?uid=:uid&pid"
    action: "CartController@updateItemQuantity"
    permistion: "self user"
    description: "increase or decrease  product quantity"
    ```
4. delete product from cart
    ```
    method: POST
    router: "/cart/delete-item?pid=:pid"
    action: "CartController@deleteItem"
    permistion: "self user"
    description: "delete Item from cart"
    ```

5. Confirm Order to Buy

    ```
    method: GET
    router: "/cart/confirm?pid=:pid&cid=:cid"
    action: "CartController@confirmOrder"
    permistion: "self user"
    description: "Show cart with readOnly method, by confirm Shop Manager will show this Order"
    ```
6. Push Order comfirmed

    ```
    method: POST
    router: "/cart/confirm?pid=:pid&cid=:cid"
    action: "CartController@pushOrder"
    permistion: "self user"
    description: "Push this Order to 'Order' table then manager can show this Order from dashboard. final, show the order status"
    ```
