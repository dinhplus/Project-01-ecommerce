<?php
    $categories = $this->productModel->getCategories();
    $brands = $this->productModel->getBrands();
    // pd($categories);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>
        <?php
        if (isset($siteTitle)) {
            echo ($siteTitle . " ! TeckShop");
        } else {
            echo ("TeckShop");
        } ?>
    </title>
    <link rel="stylesheet" href="/public/assets/icofont/icofont.min.css">
    <link rel="stylesheet" href="/public/stylesheet/defaultLayoutStyleSheet.css">
</head>

<body>
    <div class="site-header menu_bar_mod">
        <nav class="navbar navbar-expand-lg navbar-dark bg-dark ">
            <a class="navbar-brand" href="<?="http://".HOST.'/home'?>">Home</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav mr-auto navbar_menu">
                    <!-- <li class="nav-item active">
                        <a class="nav-link" href="<?="http://".HOST.'/about'?>">About</a>
                    </li> -->
                    <li class="nav-item active">
                        <a class="nav-link" href="<?="http://".HOST.'/product'?>">Product</a>
                    </li>
                    <li class="nav-item active dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Category
                        </a>
                        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                            <?php
                            if (!empty($categories)) {
                                foreach ($categories as  $category) {
                            ?>
                                    <a class="dropdown-item" href="<?= "http://" . HOST . "/product/index?category=" . $category["id"] ?>"><?= $category["label"] ?></a>
                            <?php
                                }
                            } ?>
                        </div>
                    </li>
                    <li class="nav-item active dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Brand
                        </a>
                        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                            <?php
                            if (!empty($brands)) {
                                foreach ($brands as  $brand) {
                            ?>
                                    <a class="dropdown-item" href="<?= "http://" . HOST . "/product/index?brand=" . $brand["id"] ?>"><?= $brand["name"] ?></a>
                            <?php
                                }
                            } ?>
                        </div>
                    </li>
                    <li class="nav-item active">
                        <a class="nav-link" href="/cart/show-cart">Cart</a>
                    </li>
                    <li class="nav-item active dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Action
                        </a>
                        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                            <?php
                            if (empty($_SESSION["customerId"])) {
                            ?>
                                <a class="dropdown-item" type="button" class="btn btn-primary" data-toggle="modal" data-target="#loginModal"> Login</a>
                                <a class="dropdown-item" type="button" class="btn btn-primary" data-toggle="modal" data-target="#registerModal"> Register</a>
                            <?php
                            }
                            ?>
                            <?php
                            if (!empty($_SESSION["customerId"])) {
                            ?>
                                <a class="dropdown-item" href="<?= "http://" . HOST . "/user/order/list" ?>" ?> Show order History</a>
                                <a class="dropdown-item" href="<?= "http://" . HOST . "/user/show-profile" ?>" ?> Show Profile</a>
                                <a class="dropdown-item" href="<?= "http://" . HOST . "/user/edit-profile" ?>" ?> Edit Profile</a>
                                <a class="dropdown-item" href="<?= "http://" . HOST . "/user/change-password" ?>" ?> Change Password</a>
                                <a class="dropdown-item" href="<?= "http://" . HOST . "/user/logout" ?>" ?> Log out</a>
                            <?php
                            }
                            ?>
                        </div>
                    </li>
                </ul>
                <form class="form-inline my-2 my-lg-0" action='<?= "http://" . HOST . "/product/index" ?>'>
                    <input class="form-control mr-sm-2" type="search" placeholder="Search" aria-label="Search" name="q">
                    <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
                </form>
            </div>
        </nav>
    </div>
    <div class="site-body">
        <div class="starter-template" style="width: 100%;">
            <?php
            echo $content_for_layout;
            ?>
        </div>
    </div>
    <div class="site-footer">
    </div>
    <?php if (empty($_SESSION["customerId"])) { ?>
        <div class="customer-form-action container">
            <div class="modal fade" id="loginModal" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h3 class="modal-title" id="exampleModalLongTitle">Login</h3>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="d-flex flex-column text-center">
                                <span id="message" class="warning"><?php if (isset($loginFailed) && $loginFailed && isset($message)) {
                                                                        echo ($message);
                                                                    } ?></span>
                                <form id="loginForm" method="post" action="<?= 'http://' . HOST . '/user/login' ?>">
                                    <div class="form-group">
                                        <input type="text" class="form-control" id="username1" placeholder="Your username ..." name="username" value="<?php if (isset($_SESSION["username"]) && $_SESSION["username"]) echo ($_SESSION["username"]) ?>">
                                        <span id="username-err" class="warining">
                                        </span>
                                    </div>
                                    <div class="form-group">
                                        <input type="password" class="form-control" id="password1" placeholder="Your password..." name="password" value="<?php if (isset($_SESSION["password"]) && $_SESSION["password"]) echo ($_SESSION["password"]) ?>">
                                        <span id="password-err" class="warining">
                                        </span>
                                    </div>
                                    <div class="form-group">
                                        <input type="hidden" name="location" value='<?php
                                                                                    if (empty($_SESSION["location"])) {
                                                                                        echo ($_SERVER["REQUEST_URI"]);
                                                                                    } else {
                                                                                        echo ($_SESSION["location"]);
                                                                                    }
                                                                                    ?>'>
                                        <span id="login-err" class="warining">
                                        </span>
                                    </div>
                                    <button id="login-submit" type="submit" class="btn btn-info btn-block btn-round" onclick="return loginHandling()">Login</button>
                                    <hr>

                                    <a class="dropdown-item" type="button" class="btn btn-primary" data-toggle="modal" data-target="#registerModal">
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">Register</span>
                                        </button>
                                    </a>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal fade" id="registerModal" tabindex="-1" role="dialog" aria-labelledby="asd" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h3 class="modal-title" id="exampleModalLongTitle">Register</h3>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form id="register-form" method="post" action="/user/register">
                                <hr><span id="message" class="warning"><?php if (isset($registerFailed) && $registerFailed && isset($message)) {
                                                                            echo ($message);
                                                                        } ?></span><br><br>
                                <div class="form-group">
                                    <input type="text" class="form-control" name="username" id="username" placeholder="Username ..." require pattern="^(?=[a-zA-Z0-9._]{6,20}$)(?!.*[_.]{2})[^_.].*[^_.]$" value="<?php if (isset($_SESSION["username"]) && $_SESSION["username"]) echo ($_SESSION["username"]) ?>">
                                    <span id="r-username-err" class="warning err"></span>
                                </div>
                                <div class="form-group">
                                    <input type="text" class="form-control" name="name" id="name" placeholder="Your name ..." require value="<?php if (isset($_SESSION["name"]) && $_SESSION["name"]) echo ($_SESSION["name"]) ?>">
                                    <span id="r-name-err" class="warning err"></span>
                                </div>
                                <div class="form-group">
                                    <input type="password" class="form-control" name="password" id="password" placeholder="Password..." require pattern="^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[a-zA-Z]).{6,32}" value="<?php if (isset($_SESSION["password"]) && $_SESSION["password"]) echo ($_SESSION["password"]) ?>">
                                    <span id="r-password-err" class="warning err"></span>
                                </div>
                                <div class="form-group">
                                    <input type="password" class="form-control" name="cf-password" id="cf-password" placeholder="Confirm your password...." require pattern="^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[a-zA-Z]).{6,32}" value="<?php if (isset($_SESSION["password"]) && $_SESSION["password"]) echo ($_SESSION["password"]) ?>">
                                    <span id="cf-password-err" class="warning err"></span>
                                </div>
                                <div class="form-group">
                                    <input type="text" class="form-control" name="phone" id="phone" placeholder="Your Phone's number ..." require pattern="^[+]*[(]{0,1}[0-9]{1,4}[)]{0,1}[-\s\./0-9]*$" value="<?php if (isset($_SESSION["phone"]) && $_SESSION["phone"]) echo ($_SESSION["phone"]) ?>">
                                    <span id="phone-err" class="warning err"></span>
                                </div>
                                <div class="form-group">
                                    <input type="text" class="form-control" name="email" id="email" placeholder="Your Email ..." pattern="^[\w-\.]+@([\w-]+\.)+[\w-]{2,4}$" value="<?php if (isset($_SESSION["email"]) && $_SESSION["email"]) echo ($_SESSION["email"]) ?>">
                                    <span id="email-err" class="warning err"></span>
                                </div>
                                <div class="form-group">
                                    <input type="text" class="form-control" name="address" id="address" placeholder="Your adress ..." require parent="[\w]{5,}" value="<?php if (isset($_SESSION["address"]) && $_SESSION["address"]) echo ($_SESSION["address"]) ?>">
                                    <span id="address-err" class="warning err"></span>
                                </div>
                                <div class="form-group">
                                    <input type="date" class="form-control" name="birth_date" id="birth_date" placeholder="Your Date of birth ..." value="<?php if (isset($_SESSION["birth_date"]) && $_SESSION["birth_date"]) echo ($_SESSION["birth_date"]) ?>">
                                    <span id="birth_date-err" class="warning err"></span>
                                </div>
                                <div id="login-form-action">
                                    &emsp;
                                    <button type="submit" class="btn btn-info btn-block btn-round" id="submit" onclick="return registerHandling()"> Register Now </button>
                                    <br><br>
                                    <a class="dropdown-item" type="button" class="btn btn-primary " data-toggle="modal" data-target="#loginModal"> <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">Login</span>
                                        </button> </a>
                                </div>

                            </form>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    <?php } ?>
    <script src="/public/js/common/jquery.min.js"></script>
    <script src="/public/js/common/DOMBehavior.js"></script>
    <script src='https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js'></script>
    <script src="/public/js/clients/validateBehavior.js"></script>
    <?php if (isset($loginFailed) && $loginFailed) { ?>
        <script>
            $(document).ready(function() {
                $('#loginModal').modal('show');
                $(function() {
                    $('[data-toggle="tooltip"]').tooltip()
                })
            });
            $('#loginModal').on('shown.bs.modal', function() {
                $('#username1').trigger('focus')
            })
        </script>
    <?php } ?>
    <?php if (isset($registerFailed) && $registerFailed) { ?>
        <script>
            $(document).ready(function() {
                $('#registerModal').modal('show');
                $(function() {
                    $('[data-toggle="tooltip"]').tooltip();
                })
            });
            $('#registerModal').on('shown.bs.modal', function() {
                $('#username').trigger('focus');
            })
        </script>
    <?php } ?>
</body>

</html>