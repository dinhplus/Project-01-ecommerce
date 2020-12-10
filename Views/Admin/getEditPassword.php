
<div class="edit-password-form">
    <form action="/dashboard/admin-manager/update-password" method="post">
        <h1 align="center">
            Change Password
        </h1>
        <hr><span id="message" class = "warning" ><?php if(isset($message)){echo($message);} ?></span><br><br>

        <label for="current-password">
            Current Password <br>
            <input type="password" name="current-password" id="current-password" placeholder="Your current password...">
            <span id="password-err" class="warning err"></span>
        </label><br>
        <label for="password">
            New Password <br>
            <input type="password" name="password" id="password" placeholder="New Password...">
            <span id="password-err" class="warning err"></span>
        </label><br>
        <label for="confirm-password">
            Confirm New Password <br>
            <input type="password" name="confirm-password" id="confirm-password" placeholder="Confirm New Password...">
            <span id="password-err" class="warning err"></span>
        </label><br>
        <div id="form-action">
            <input type="submit" id="submit" name="submit" value="Submit">
            <br><br>
        </div>

    </form>

</div>
