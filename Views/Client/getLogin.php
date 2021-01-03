
<div class="login-form">
    <form action="<?= 'http://' . HOST . '/user/login' ?>" method="post">
        <h1 align="center">
            Login
        </h1>
        <hr><span id="message" class = "warning" ><?php if(isset($message)){echo($message);} ?></span><br><br>

        <label for="username">
            User Name <br>
            <input type="text" class="form-control" id="username1" placeholder="Your username ..." name="username" value="<?php if (isset($_SESSION["username"] )&& $_SESSION["username"]) echo ($_SESSION["username"]) ?>">
            <span id="username-err" class="warning err"></span>
        </label><br>
        <label for="password">
            Password <br>
            <input type="password" class="form-control" id="password1" placeholder="Your password..." name="password" value="<?php if (isset($_SESSION["password"] )&& $_SESSION["password"]) echo ($_SESSION["password"]) ?>">
            <span id="password-err" class="warning err"></span>
        </label><br>
        <div id="login-form-action">
        &emsp;
            <a href="/account/forgot-password">
                <span id="forgot-password">
                Forgot password?
                <span>

            </a>
            <button id="submit" type="submit" class="btn btn-info btn-block btn-round" onclick="return loginHandling()">Login</button>
            <br><br>

        </div>

    </form>
    <div class="more-action">
        <span id="register">
            <hr>
            Not a member yet? Register with us and get speacial Deals! <br>
            <button onclick="location.href='<?='http:\/\/'.HOST.'/user/register'?>'" >Register</button>
        </span>
        <a href="<?='http://'.HOST.'/'?>">Back to Home</a>
    </div>
</div>
