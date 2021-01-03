<div class="container edit-user">
    <div class="col-12 col-md-12">
        <form action="<?='http://'.HOST.'/user/update-password'?>" class="form " method="POST">
                                    <h1>
                                        Edit profile:
                                    </h1>
                                <hr><span id="message" class="warning"><?php if (isset($message)) {
                                                                            echo ($message);
                                                                        } ?></span><br><br>

                                <div class="form-group">
                                    Current password: <br>
                                    <input type="password" class="form-control" name="password" id="password" placeholder="Current password..." require pattern="^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[a-zA-Z]).{6,32}">
                                    <span id="password-err" class="warning err"></span>
                                </div>

                                <div class="form-group">
                                    New password: <br>
                                    <input type="password" class="form-control" name="new-password" id="new-password" placeholder="Current password..." require pattern="^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[a-zA-Z]).{6,32}">
                                    <span id="new-password-err" class="warning err"></span>
                                </div>

                                <div class="form-group">
                                    Confirm new password: <br>
                                    <input type="password" class="form-control" name="" id="cf-new-password" placeholder="Current password..." require pattern="^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[a-zA-Z]).{6,32}">
                                    <span id="cf-new-password-err" class="warning err"></span>
                                </div>
                                <div id="login-form-action">
                                    &emsp;
                                    <button type="submit" class="btn btn-info btn-block btn-round" id="submit" onclick="return updatePasswordBehavior()">  Update now! </button>
                                    <br><br>
                                </div>




        </form>
    </div>
</div>