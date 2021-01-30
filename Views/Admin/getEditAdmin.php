<div class="edit-staff-form row">
    <div class="col-8">
    <form action="/dashboard/admin-manager/edit-staff" method="POST">
        <div>

            <label for="name">
                Name <br>
                <input type="text" name="name" id="name" value="<?php if (isset($formInputted)) {
                                                                    echo ($formInputted["name"]);
                                                                } else {
                                                                    echo ($currentAccount["name"]);
                                                                } ?>">
            </label>
        </div>
        <div>

            <label for="username">
                Username <br>
                <input readonly type="text" name="username" id="username" value="<?php echo ($currentAccount["username"]) ?>">
            </label>
        </div>
        <div>

            <label for="name">
                Role <br>
                <select id="role" name="role" value="<?php
                                                        if (isset($formInputted)) {
                                                            echo ($formInputted["role"]);
                                                        } else {
                                                            echo ($currentAccount["role_id"]);
                                                        } ?>">
                    <?php if (isset($roles) && count($roles) > 0) {
                        foreach ($roles as $key => $role) {
                    ?>
                            <option value="<?= $role["level"] ?>" <?= $currentAccount["role_id"] == $role["level"] ? "selected" : "" ?>>
                                <?= $role["label"] ?>
                            </option>
                    <?php }
                    } ?>
                </select>

            </label>


        </div>
        <input type="reset" value="reset" id="reset-btn">
        <input type="submit" value="Update now" id="submit-btn">
    </form>
    </div>


    <?php if ($_SESSION["role"] > 4) { ?>
        <div class="reset-password col-3" >
            <button class="btn btn-danger col-12" onclick="showResetPassword()">Reset password</button>
            <form action="/dashboard/admin-manager/reset-staff-password" method="post" id="reset-form" style="display: none;">

                <input readonly type="hidden" name="uid" id="uid" value="<?php echo ($currentAccount["id"]) ?>">
                <br>
                <span>Enter secret key</span>
                <input type="text" name="secret-key" placeholder="Reset Password secret key">
                <button type="submit" onclick="return confirm('Are you sure? This action cannot revert')" class="btn btn-success"> Submit</button>
                <button type="reset" onclick="hideResetPassword()" class="btn btn-warning">Cancle</button>
            </form>
        </div>
    <?php } ?>

</div>