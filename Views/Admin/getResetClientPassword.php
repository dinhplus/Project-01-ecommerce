<div class="reset-client-password container">
    <div class="input-group">
        <form action="" method="get" class="row">
            <button type="submit" class="btn btn-primary form-control" style="width: 10%;">
                Filter
            </button>
            <input type="search" id="filter" name="filter" class="form-control" value="<?= $_GET["filter"] ??'' ?>" style="width: 80%;" / placeholder="Type anything to find the account">
        </form>
    </div>
    <table class="table table-striped col-12">
        <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">Name</th>
                <th scope="col">username</th>
                <th scope="col">email</th>
                <th scope="col">Other Action</th>
            </tr>
        </thead>
        <tbody>
            <?php if ($customers && count($customers) > 0)
                foreach ($customers as $customer) {
                    extract($customer); ?>
                <tr>
                    <th scope="row"> <?= $id ?></th>
                    <td><?= $name ?? '' ?></td>
                    <td><?= $username ?></td>
                    <td><?= $email ?? '' ?></td>
                    <td>
                        <div class="reset-action">
                            <button onclick="showResetClientPassword('<?= $username ?>')" class="btn btn-danger" style="width: 100%;"> Reset password</button >
                            <form action="/dashboard/client-manager/reset-password" method="post" id="<?= "reset-form-" . $username ?>" style="display: none;">
                                <input readonly type="hidden" name="username" id="username" value="<?= $username ?>">
                                <br>
                                <!-- <span>Enter secret key</span> -->
                                <input type="text" name="secret-key" placeholder="Reset Password secret key" class="form-control">
                                <button type="reset" onclick="hideResetClientPassword('<?= $username ?>')" class="btn btn-warning" style="width: 49%;">Cancle</button>
                                <button type="submit" onclick="return confirm('Are you sure? This action cannot revert')" class="btn btn-success " style="width: 49%;"> Submit</button>
                            </form>
                        </div>
                    </td>
                </tr>
            <?php } ?>

        </tbody>
    </table>
</div>