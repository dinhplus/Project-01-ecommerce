
<div class="login-form">
    <form action="/dashboard/login" method="post">
        <h1 align="center">
            Login
        </h1>
        <hr><span id="message" class = "warning" ><?php if(isset($message)){echo($message);} ?></span><br><br>

        <label for="username">
            User Name <br>
            <input type="text" name="username" id="username" placeholder="Username or email..."  value="<?php if(isset($inputted)) echo($inputted["username"])?>">
            <span id="username-err" class="warning err"></span>
        </label><br>
        <label for="password">
            Password <br>
            <input type="password" name="password" id="password" placeholder="Password..."   value="<?php if(isset($inputted)) echo($inputted["password"])?>">
            <span id="password-err" class="warning err"></span>
        </label><br>
        <div id="login-form-action">
        &emsp;
            <a href="/acount/forgot-password">
                <span id="forgot-password">
                Forgot password?
                <span>

            </a>
            <input type="submit" id="submit" name="submit" value="Submit">
            <br><br>

        </div>

    </form>
    <div class="more-action">
        <span id="register">
            <hr>
            Not a member yet? Register with us and get speacial Deals! <br>
            <button onclick="location.href=`/dashboard/register`" >Register</button>
        </span>
    </div>
</div>
