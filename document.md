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
    router: "/dashboard/admin-manager/create-admin"
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
11. DELETE ACOUNT

    ```
    method: POST
    router: "/dashboard/admin-manager/delete-staff"
    action: "AdminController@deleteStaff"
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
    router: "/dashboard/product-manager/create-product"
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

6. update Product
    ```
    method: POST
    router: "/dashboard/product-manager/edit-product"
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

9. Product Remainder

    ```
    method: GET
    router: ("/dashboard/product-manager/remainder").("?page=:page&desc=:desc")
    action: "ProductController@productRemainder"
    permistion: "all"
    description: " Show all sort by remainder"
    ```

9. add Product Category

    ```
    method: GET
    router: "/dashboard/product-manager/add-category"
    action: "ProductController@createCategory"
    permistion: "all"
    description: " Add new Category for product"
    ```

10. store Product Category

    ```
    method: POST
    router: "/dashboard/product-manager/add-category"
    action: "ProductController@storeCategory"
    permistion: "all"
    description: " Store new Category in database"
    ```
11. add Product Brand

    ```
    method: GET
    router: "/dashboard/product-manager/add-brand"
    action: "ProductController@createBrand"
    permistion: "all"
    description: " Add new Category for product"
    ```
12. store Product Brand

    ```
    method: POST
    router: "/dashboard/product-manager/add-brand"
    action: "ProductController@storeBrand"
    permistion: "all"
    description: " Store new Brand in database"
    ```
13. lst Category

    ```
    method: GET
    router: "/dashboard/product-manager/lst-category"
    action: "ProductController@lstAllCategory"
    permistion: "all"
    description: " Show all categories"
    ```
14. Edit Category
    ```
    method: GET
    router: "/dashboard/product-manager/edit-category"
    action: "ProductController@editCategory"
    permistion: "all"
    description: " Edit Special category label"
    ```
15. Update Category
    ```
    method: POST
    router: "/dashboard/product-manager/edit-category"
    action: "ProductController@storeCategory"
    permistion: "all"
    description: " Update Special category label in database"
    ```

16. Delete Category
    ```
    method: POST
    router: "/dashboard/product-manager/delete-category"
    action: "ProductController@deleteCategory"
    permistion: "all"
    description: " Delete special category"
    ```

17. lst Brand
    ```
    method: GET
    router: "/dashboard/product-manager/lst-brands"
    action: "ProductController@lstAllCategory"
    permistion: "all"
    description: " Show all Brands"
    ```
18. Edit Brand
    ```
    method: GET
    router: "/dashboard/product-manager/edit-brands"
    action: "ProductController@editCategory"
    permistion: "all"
    description: " Edit Special Brand label"
    ```
19. Update Brand
    ```
    method: POST
    router: "/dashboard/product-manager/edit-brands"
    action: "ProductController@storeCategory"
    permistion: "all"
    description: " Update Special Brand label in database"
    ```
20. Delete Brand
    ```
    method: POST
    router: "/dashboard/product-manager/delete-brands"
    action: "ProductController@deleteCategory"
    permistion: "all"
    description: " Delete special Brand"
    ```
## Order Controller

1. The Order Queue (Index)
    ```
    method: GET
    router: ("/dashboard/order-manager/index" || "/dashboard/order-manager").("?oid=:oid&cid:cid")
    action: "OrderController@index"
    permistion: "all"
    description: " Show all Order and paginate by rule && show permistion"
    ```

2. Show Order Detail
    ```
    method: GET
    router: "/dashboard/order-manager/order-detail"
    action: "OrderController@showOrderDetail"
    permistion: "all"
    description: " Show All information from this order, include product{name, category, unit_price, order_quantity}, total price, order_time"
    ```

3. Confirm Order
    ```
    method: POST
    router: "/dashboard/order-manager/change-status"
    action: "OrderController@changeOrderStatus"
    permistion: "all"
    description: " By confirm this order, the bill will generate, the Shop will prepare for package then send the package  "
    ```

//TODO commplete feature for dashboard "OrderController@generateOrder"
4. Generate new Order

    ```
    method: GET && POST
    router: "/dashboard/order-manager/create-order"
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

## Client Controller
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
3. Post Login

    ```
    method: POST
    router: "/user/login"
    action: "ClientController@postLogin"
    permistion: "registered User"
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
    router: "/user/show?uid:uid"
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
    router: "/user/order/list"
    action: "ClientController@showOrders"
    permistion: "self user"
    description: "show all order for this customer with status , linked to Order detail"
    ```
9. Show Order Detail

    ```
    method: GET
    router: "/user/order/show?oid=:oid"
    action: "ClientController@showOrderDetail"
    permistion: "self user"
    description: "show all information for this Order"

    ```
10. GET LOG OUT
    ```
    method: GET
    router: "/user/logout"
    action: "ClientController@getLogout"
    permistion: "self user"
    description: "Logout and reset Session";

    ```
11. Change password
```
method: GET
router: "/user/change-password"
action: "ClientController@getChangePassword"
permistion: "self user"
description: "redirect to changePassword page"
```
12. Update password
```
method: POST
router:  "/user/update-password"
action: "ClientController@updatePassword"
permistion: "self user"
description: "recieve password and new passsword, confirm then update when the old is valid"
```
13. Cancel Order
```
method: POST
router:  "/user/order/cancel"
action: "ClientController@cancelOrder"
permistion: "self user"
description: "Cancel order for self user"
```
## Cart Controller

1. Show cart

    ```
    method: get
    router: "/cart/show-cart"
    action: "CartController@showCart"
    permistion: "self user"
    description: "Show all product with more infor which added to cart"
    ```
2. add to cart

    ```
    method: GET
    router: "/cart/add-item"
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
    router: "/cart/get-confirm"
    action: "CartController@confirmOrder"
    permistion: "self user"
    description: "Show cart with readOnly method, by confirm Shop Manager will show this Order"
    ```
6. Push Order comfirmed

    ```
    method: POST
    router: "/cart/push-confirm"
    action: "CartController@pushOrder"
    permistion: "self user"
    description: "Push this Order to 'Order' table then manager can show this Order from dashboard. final, show the order status"
    ```
