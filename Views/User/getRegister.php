
<div class="login-form">
    <form action="/acount/register" method="post">
        <h1 align="center">
            Register
        </h1>
        <hr><span id="message" class = "warning" ><?php if(isset($message)){echo($message);} ?></span><br><br>

        <label for="">
            User Name <br>
            <input type="text" name="username" id="username" placeholder="Username ...">
            <span id="username-err" class="warning err"></span>
        </label><br>

        <label for="">
            Password <br>
            <input type="password" name="password" id="password" placeholder="Password...">
            <span id="password-err" class="warning err"></span>
        </label><br>


        <label for="">
            Confirm password<br>
            <input type="password" name="cf-password" id="cf-password" placeholder="Confirm your password....">
            <span id="cf-password-err" class="warning err"></span>
        </label><br>



        <div id="login-form-action">
        &emsp;
            <!-- <a href="/acount/forgot-password">
                <span id="forgot-password">
                Forgot password?
                <span>

            </a> -->
            <input type="submit" id="submit" name="submit" value="Register Now">
            <br><br>

        </div>

    </form>
    <div class="more-action">
        <span id="register">
            <hr>
            Are member? Login now!!<br>
            <button onclick="location.href=`/acount/login`">Login</button>
        </span>
    </div>
</div>
