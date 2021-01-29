<div class="edit-staff-form">
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
                <select
                    id="role"
                    name="role"
                    value="<?php
                        if (isset($formInputted)) {
                            echo ($formInputted["role"]);
                        } else {
                            echo ($currentAccount["role_id"]);
                    } ?>">
                    <?php if (isset($roles) && count($roles) > 0) {
                        foreach ($roles as $key => $role) {
                    ?>
                            <option value="<?= $role["level"] ?>" <?=$currentAccount["role_id"]==$role["level"]?"selected":""?>>
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