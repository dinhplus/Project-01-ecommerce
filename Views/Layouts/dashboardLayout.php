<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Aplication</title>
    <!-- <link rel="stylesheet" href="/public/assets/bootstrap/css/bootstrap.min.css"> -->
    <link rel="stylesheet" href="/public/assets/icofont/icofont.min.css">
    <link rel="stylesheet" href="/public/stylesheet/dashboardStyleSheet.css">

</head>

<body>
    <div class="site-header">
        <div class="title">

            <h1>
                Manager Site
            </h1>
        </div>
        <div class="query-field">
        <?php if(isset($enableSearch) && $enableSearch) { ?>
            <form action="#" method="GET" >
                <input type="text" placeholder=" Type some thing to search..." name="q" id="query" value="<?php if (isset($_GET["q"])) echo ($_GET["q"]) ?>">
                <button type="submit" id="query-submit-btn"><i class="icofont-search-2"></i> Search</button>

            </form>
            <?php }?>
        </div>
    </div>
    <div id="root">
        <div class="layout-sider">
            <div class="swanky">
                <div class="swanky_wrapper">
                    <input id="Dashboard" name="checkbox" type="checkbox"></input>
                    <label for="Dashboard">
                        <i class="icofont-dashboard icofont-2x"></i>
                        <span>Dashboard</span>
                        <div class="lil_arrow"></div>
                        <div class="bar"></div>
                        <div class="swanky_wrapper__content">
                            <ul>
                                <a href="<?php echo ("http://" . HOST . "/dashboard") ?>">
                                    <li>Dashboard</li>
                                </a>


                                <li>Analytics</li>

                                <a href="<?php echo ("http://" . HOST . "/dashboard/admin-manager/change-password") ?>">
                                    <li>Change Passwords</li>
                                </a>
                                <li>Show Sefl Acount detail</li>
                                <a href="<?php echo ("http://" . HOST . "/dashboard/admin-manager/edit-staff?uid=" . $_SESSION["uid"]) ?>">

                                    <li>Edit Self Profile</li>
                                </a>
                                <a href="<?php echo ("http://" . HOST . "/dashboard/logout") ?>">
                                    <li>Logout</li>
                                </a>
                            </ul>
                        </div>
                    </label>
                    <input id="Sales" name="checkbox" type="checkbox"></input>
                    <label for="Sales">
                        <i class="icofont-sale-discount icofont-2x"></i>
                        <span>Sales Manager</span>
                        <div class="lil_arrow"></div>
                        <div class="bar"></div>
                        <div class="swanky_wrapper__content">
                            <ul>
                                <li>New Sales</li>
                                <li>Expired Sales</li>
                                <li>Sales Reports</li>
                                <li>Deliveries</li>
                            </ul>
                        </div>
                    </label>
                    <input id="Messages" name="checkbox" type="checkbox"></input>
                    <label for="Messages">
                        <i class="icofont-listine-dots icofont-2x"></i>
                        <span>Product Manager</span>
                        <div class="lil_arrow"></div>
                        <div class="bar"></div>
                        <div class="swanky_wrapper__content">
                            <ul>
                                <a href='<?php echo ("http://" . HOST . "/dashboard/product-manager/create-product") ?>'>
                                    <li>New Product</li>
                                </a>
                                <a href="<?php echo ("http://" . HOST . "/dashboard/product-manager/index") ?>">
                                    <li>Show all Product</li>
                                </a>
                                <li>Import data</li>
                                <a href="<?php echo ("http://" . HOST . "/dashboard/product-manager/remainder") ?>">
                                    <li>Product remainder</li>
                                </a>
                            </ul>
                        </div>
                    </label>
                    <input id="Users" name="checkbox" type="checkbox"></input>
                    <label for="Users">
                        <i class="icofont-users-alt-3 icofont-2x"></i>
                        <span>Staff Manager</span>
                        <div class="lil_arrow"></div>
                        <div class="bar"></div>
                        <div class="swanky_wrapper__content">
                            <ul>
                                <a href="<?php echo ("http://" . HOST . "/dashboard/admin-manager/create-admin") ?>">
                                    <li>New Staff</li>
                                </a>
                                <a href="<?php echo ("http://" . HOST . "/dashboard/admin-manager/index") ?>">
                                    <li>All Staff</li>
                                </a>
                            </ul>
                        </div>
                    </label>
                    <input id="Settings" checkbox="checkbox" type="checkbox"></input>
                    <label for="Settings">
                        <i class="icofont-cart-alt icofont-2x"></i>
                        <span>Order Manager</span>
                        <div class="lil_arrow"></div>
                        <div class="bar"></div>
                        <div class="swanky_wrapper__content">
                            <ul>
                                <a href="<?php echo ("http://" . HOST . "/dashboard/order-manager/index") ?>">
                                    <li>List Orrder</li>
                                </a>
                                <a href="<?php echo ("http://" . HOST . "/dashboard/order-manager/pending") ?>">
                                    <li>Pending Order</li>
                                </a>
                                <a href="<?php echo ("http://" . HOST . "/dashboard/order-manager/processing") ?>">
                                    <li>In Progress Order</li>
                                </a>
                                <a href="<?php echo ("http://" . HOST . "/dashboard/order-manager/cancelled") ?>">
                                    <li>Cancelled Order</li>
                                </a>
                                <a href="<?php echo ("http://" . HOST . "/dashboard/order-manager/completed") ?>">
                                    <li>Completed Order</li>
                                </a>
                                <a href="<?php echo ("http://" . HOST . "/dashboard/order-manager/create-order") ?>">
                                    <li>Create New Order</li>
                                </a>
                            </ul>
                        </div>
                    </label>
                </div>
            </div>


        </div>
        <div role="main" class="container" id="main-site">
            <div class="starter-template">

                <?php
                echo $content_for_layout;
                ?>

            </div>

        </div>

    </div>

    <script src="/public/assets/bootstrap/Jquery/jquery-3.2.1.slim.min.js"></script>
    <!-- <script src="/public/assets/bootstrap/js/bootstrap.min.js"></script> -->
</body>

</html>