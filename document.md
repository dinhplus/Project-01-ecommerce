# Manager
## Admin Controller
1. Login
    ```
    method: GET && POST
    router: "/dashboard/login"
    action: "AdminController@Login"
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
    method: get
    router: "/dashboard/admin-manager/admin-information?id=:id"
    action: "AdminController@storeAdmin"
    permistion: "master_admin/self"
    description: " To be define later"
    ```

##  Product Controller
1. Show All Product

     ```
    method: GET
    router: ("/dashboard/product-manager/index" || "/dashboard/product-manager").("?name=:name&category=:category&page=:page")
    action: "ProductController@index"
    permistion: "all"
    description: " Show all Products and paginate by rule"
    ```
2.




# Client