<div class="container edit-user">
    <div class="col-12 col-md-12">
        <form action="<?='http://'.HOST.'/user/update-profile'?>" class="form " method="POST">
                                    <h1>
                                        Edit profile:
                                    </h1>
                                <hr><span id="message" class="warning"><?php if (isset($message)) {
                                                                            echo ($message);
                                                                        } ?></span><br><br>
                                <div class="form-group">
                                    Username: <br>
                                    <input type="text" class="form-control" name="username" id="username" placeholder="Username ..." require pattern="^(?=[a-zA-Z0-9._]{6,20}$)(?!.*[_.]{2})[^_.].*[^_.]$" value="<?php if (isset($user["username"])) echo ($user["username"]) ?>" readonly aria-readonly="">
                                    <span id="r-username-err" class="warning err"></span>
                                </div>
                                <div class="form-group">
                                    Name: <br>
                                    <input type="text" class="form-control" name="name" id="name" placeholder="Your name ..." require  value="<?php if (isset($user["name"])) echo ($user["name"]) ?>">
                                    <span id="r-name-err" class="warning err"></span>
                                </div>
                                <div class="form-group">
                                    Phone number: <br>
                                    <input type="text" class="form-control" name="phone" id="phone" placeholder="Your Phone's number ..." require pattern="^[+]*[(]{0,1}[0-9]{1,4}[)]{0,1}[-\s\./0-9]*$" value="<?php if (isset($user["phone"])) echo ($user["phone"]) ?>">
                                    <span id="phone-err" class="warning err"></span>
                                </div>
                                <div class="form-group">
                                    Email address: <br>
                                    <input type="text" class="form-control" name="email" id="email" placeholder="Your Email ..." pattern="^[\w-\.]+@([\w-]+\.)+[\w-]{2,4}$" value="<?php if (isset($user["email"])) echo ($user["email"]) ?>">
                                    <span id="email-err" class="warning err"></span>
                                </div>
                                <div class="form-group">
                                    Address: <br>
                                    <input type="text" class="form-control" name="address" id="address" placeholder="Your adress ..." require parent="[\w]{5,}" value="<?php if (isset($user["address"]) ) echo ($user["address"]) ?>">
                                    <span id="address-err" class="warning err"></span>
                                </div>
                                <div class="form-group">
                                    Date of birth: <br>
                                    <input type="date" class="form-control" name="birth_date" id="birth_date" placeholder="Your Date of birth ..." value="<?php if (isset($user["birth_date"])) echo ($user["birth_date"]) ?>">
                                    <span id="birth_date-err" class="warning err"></span>
                                </div>
                                <div class="form-group">
                                    Confirm your current password: <br>
                                    <input type="password" class="form-control" name="password" id="password" placeholder="Current password..." require pattern="^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[a-zA-Z]).{6,32}">
                                    <span id="password-err" class="warning err"></span>
                                </div>
                                <div id="login-form-action">
                                    &emsp;
                                    <button type="submit" class="btn btn-info btn-block btn-round" id="submit" onclick="return editUserProfileBehavior()">  Update now </button>
                                    <br><br>
                                </div>




        </form>
    </div>
</div>