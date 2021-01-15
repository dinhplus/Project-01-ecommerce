
<div class="login-form">
    <form action="/user/register" method="post">
        <h1 align="center">
            Register
        </h1>
        <hr><span id="message" class="warning"><?php if (isset($registerFailed) && $registerFailed && isset($message)) {
                                                                            echo ($message);
                                                                        } ?></span><br><br>
                                <div class="form-group">
                                    <label for="username">

                                        <input type="text" class="form-control" name="username" id="username" placeholder="Username ..." require value="<?php if (isset($_SESSION["username"]) && $_SESSION["username"]) echo ($_SESSION["username"]) ?>">
                                        <span id="r-username-err" class="warning err"></span>
                                    </label>
                                </div>
                                <div class="form-group">
                                    <label for="name">


                                        <input type="text" class="form-control" name="name" id="name" placeholder="Your name ..." require value="<?php if (isset($_SESSION["name"]) && $_SESSION["name"]) echo ($_SESSION["name"]) ?>">
                                        <span id="r-name-err" class="warning err"></span>
                                    </label>
                                </div>
                                <div class="form-group">
                                    <label for="password">

                                        <input type="password" class="form-control" name="password" id="password" placeholder="Password..." require value="<?php if (isset($_SESSION["password"]) && $_SESSION["password"]) echo ($_SESSION["password"]) ?>">
                                        <span id="r-password-err" class="warning err"></span>
                                    </label>
                                </div>
                                <div class="form-group">
                                    <label for="cf-password">

                                        <input type="password" class="form-control" name="cf-password" id="cf-password" placeholder="Confirm your password...." require value="<?php if (isset($_SESSION["password"]) && $_SESSION["password"]) echo ($_SESSION["password"]) ?>">
                                        <span id="cf-password-err" class="warning err"></span>
                                    </label>
                                </div>
                                <label for="phone">

                                    <div class="form-group">
                                        <input type="text" class="form-control" name="phone" id="phone" placeholder="Your Phone's number ..." require pattern="^[+]*[(]{0,1}[0-9]{1,4}[)]{0,1}[-\s\./0-9]*$" value="<?php if (isset($_SESSION["phone"]) && $_SESSION["phone"]) echo ($_SESSION["phone"]) ?>">
                                        <span id="phone-err" class="warning err"></span>
                                    </label>
                                </div>
                                <div class="form-group">
                                    <label for="email">

                                        <input type="text" class="form-control" name="email" id="email" placeholder="Your Email ..." pattern="^[\w-\.]+@([\w-]+\.)+[\w-]{2,4}$" value="<?php if (isset($_SESSION["email"]) && $_SESSION["email"]) echo ($_SESSION["email"]) ?>">
                                        <span id="email-err" class="warning err"></span>
                                    </div>
                                </label>
                                <div class="form-group">
                                    <label for="address">

                                        <input type="text" class="form-control" name="address" id="address" placeholder="Your adress ..." require parent="[\w]{5,}" value="<?php if (isset($_SESSION["address"]) && $_SESSION["address"]) echo ($_SESSION["address"]) ?>">
                                        <span id="address-err" class="warning err"></span>
                                    </label>
                                </div>
                                <div class="form-group">
                                    <label for="birth_date">

                                        <input type="date" class="form-control" name="birth_date" id="birth_date" placeholder="Your Date of birth ..." value="<?php if (isset($_SESSION["birth_date"]) && $_SESSION["birth_date"]) echo ($_SESSION["birth_date"]) ?>">
                                        <span id="birth_date-err" class="warning err"></span>
                                    </label>
                                </div>
                                <div id="login-form-action">
                                    &emsp;
                                    <button type="submit" class="btn btn-info btn-block btn-round register_btn" id="submit" onclick="return registerHandling()"> Register Now </button>
                                    <br><br>
                                </div>

    </form>
    <div class="more-action">
        <span id="register">
            <hr>
            Are member? Login now!!<br>
            <button onclick="location.href='<?='http:\/\/'.HOST.'/user/login'?>'">Login</button>
        </span>
        <a href="<?='http://'.HOST.'/'?>">Back to Home</a>
    </div>
</div>
