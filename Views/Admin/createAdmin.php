<div class="login-form">
    <form action="/dashboard/admin-manager/store-admin" method="post">
        <h1 align="center">
            Create New Staff User
        </h1>
        <hr><span id="message" class="warning">
            <?php if (isset($message)) {
                echo ($message);
            } ?>
        </span><br><br>
        <table>
            <tr>
                <td>
                    <label for="username">
                        User Name
                    </label>
                </td>
                <td>
                    <input type="text" name="username" id="username" placeholder="Username ..." value="<?php if(isset($inputted)) echo($inputted["username"])?>">
                    <span id="username-err" class="warning err"></span>
                </td>
            </tr>
            <label for="password">
                <tr>
                    <td>
                        Password
                    </td>
                    <td>
                        <input type="password" name="password" id="password" placeholder="Password..." value="<?php if(isset($inputted)) echo($inputted["password"])?>">
                        <span id="password-err" class="warning err"></span>
                    </td>
                </tr>
            </label>
            <tr>
                <td>
                    <label for="cf-password">
                        Confirm password
                    </label>
                </td>
                <td>

                    <input type="password" name="cf-password" id="cf-password" placeholder="Confirm your password...." value="<?php if(isset($inputted)) echo($inputted["password"])?>">
                    <span id="cf-password-err" class="warning err"></span>
                </td>
            </tr>
            <tr>
                <td>
                    <label for="displayname">
                        Display Name
                    </label>
                </td>
                <td>
                    <input type="text" name="displayname" id="displayname" placeholder="Full name ..." value="<?php if(isset($inputted)) echo($inputted["name"])?>">
                    <span id="username-err" class="warning err"></span>
                </td>
            </tr>
            <tr>
                <td>
                    <label for="role">
                        Role
                    </label>
                </td>
                <td>
                    <select id="role" name="role" placeholder="Choose role for staff" value="<?php if(isset($inputted)) echo($inputted["role"])?>">
                        <?php if (isset($roles) && count($roles) > 0) {
                            foreach ($roles as $key => $role) {
                        ?>
                                <option value="<?= $role["level"] ?>">
                                    <?= $role["label"] ?>
                                </option>
                        <?php }
                        } ?>
                    </select>
                    <span id="username-err" class="warning err"></span>
                </td>
            </tr>
        </table>

        <div id="action">
            &emsp;
            <input type="reset" id="reset" name="reset" value="Reset Input value">
            <input type="submit" id="submit" name="submit" value="Create Acount">
            <br><br>
        </div>

    </form>

</div>