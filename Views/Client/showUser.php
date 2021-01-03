<div class="container user_detail">
    <div class="col-12 col-md-12 ">
        <?php if (isset($user) && count($user)) { ?>
            <a class="btn btn-block btn-primary" type="button" href="<?="http://".HOST."/user/edit-profile"?>"> Edit profile</a>
            <table class="table table-striped table-dark">
                <thead>
                    <tr><th>
                        <h1>

                            User Info
                        </h1>
                    </th></tr>

                </thead>

                <tbody>
                    <tr>
                        <th>
                            Name (full name) :
                        </th>
                        <td>
                            <?=$user["name"]?>
                        </td>
                    </tr>
                    <tr>
                        <th>
                           Username :
                        </th>
                        <td>
                            <?=$user["username"]?>
                        </td>
                    </tr>
                    <tr>
                        <th>
                            Phone Number :
                        </th>
                        <td>
                            <?=$user["phone"]?>
                        </td>
                    </tr>
                    <tr>
                        <th>
                           Email address :
                        </th>
                        <td>
                            <?=$user["email"]?>
                        </td>
                    </tr>
                    <tr>
                        <th>
                            Address :
                        </th>
                        <td>
                            <?=$user["address"]?>
                        </td>
                    </tr>
                    <tr>
                        <th>
                            Date of Birth :
                        </th>
                        <td>
                            <?=$user["birth_date"]?>
                        </td>
                    </tr>
                    <tr>
                        <th>
                            Join in at :
                        </th>
                        <td>
                            <?=$user["joined_at"]?>
                        </td>
                    </tr>
                </tbody>
            </table>
        <?php } ?>
    </div>
</div>