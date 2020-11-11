<div class="login-form">
    <form action="/acount/login" method="post">
        <h1 align="center">
            Login
        </h1>
        <hr><br><br>
        <label for="">
            User Name <br>
            <input type="text" name="username" id="username" placeholder="Username or email...">
            <span id="username-err" class="warning"></span>
        </label><br>
        <label for="">
            Password <br>
            <input type="password" name="password" id="password" placeholder="Password...">
            <span id="password-err" class="warning"></span>
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
            <button onclick="location.href=`/acount/register`" action="/acount/register" href="/acount/register">Register</button>
        </span>
    </div>
</div>
