<?php ?>

<div class="row" style="width: 100%; margin-bottom:50px; margin-top: 100px">
    <div class="order-detail row col-12 col-xl-6 col-lg-6 col-md-12">
        <div class="list-item" style="margin-left: 50px; overflow: auto">
            <?php foreach ($cart as $item) { ?>
                <div class="row" style="border: 1px solid blue; border-collapse:collapse; margin-bottom: 30px; padding: 20px; border-radius: 10px">

                    <div class="item-img col-12 col-xl-4 col-lg-4 col-md-6 col-sm-6">
                        <a href="<?= "http://" . HOST . "/product/detail?pid=" . $item["id"] ?>">
                            <img src="<?php if (preg_match("/^http?/", $item["img_ref"])) {
                                            echo ($item["img_ref"]);
                                        } else {
                                            echo ("http://" . HOST . $item["img_ref"]);
                                        }
                                        ?>" alt="" style=" max-height: 200px; max-width: 250px">
                        </a>
                    </div>
                    <div class="content-summary col-12 col-xl-6 col-lg-6 col-md-6 col-sm-11" style="margin-left: 10px; ">
                        <b>
                            <h3>
                                <?= $item["name"] ?>
                            </h3>
                        </b>
                        <b>Unit Price: &nbsp;</b>
                        <?= $item["unit_price"] ?>
                        <br> <b>Quantity: &nbsp;</b>
                        <?= $item["item_quantity"] ?>
                        <hr>
                        <div class="item-action row">


                            <div class="delete-item">
                                <form action="<?= "http://" . HOST . "/cart/delete-item" ?>" method="get">
                                    <input type="hidden" value="<?= $item["id"] ?>" name="pid">
                                    <button type="submit" onclick="return confirm('Are you sure?')" class="btn btn-danger"> Delete Item</button>
                                </form>
                            </div>
                            <hr>
                            <div class="change-qtt">
                                <button onclick="decrease(<?= $item['id'] ?>)" class="btn btn-warning">Decrease - </button>
                                <button onclick="increase(<?= $item['id'] ?>)" class="btn btn-success">Increase + </button>
                                <form action="<?= "http://" . HOST . "/cart/update-quantity" ?>" method="post" id="<?= "formQtt-" . $item["id"] ?>" style="display: none;">
                                    <input type="hidden" name="pid" value="<?= $item["id"] ?>">
                                    <input type="string" value="<?= $item['item_quantity'] ?>" name="qtt" id="<?= "qtt-" . $item["id"] ?>" class="form-control" style="width: 100%;" pattern="^[0-9]+$">
                                    <button type="submit" class="btn btn-primary" class="form-control" style="width: 100%;">Submit</button>
                                </form>
                            </div>


                        </div>
                    </div>

                </div>
            <?php } ?>
        </div>
    </div>
    <div class="order-common col-12 col-xl-6 col-lg-6 col-md-12">
        <div class="order-info" style="border: 1px solid blue; padding: 20px; border-radius: 10px; margin: 10px;">
            <hr>
            <h3>
                Order information:
            </h3>
            <hr>
            <div class="">
                <b>Total Price:</b> $<?= $totalPrice ?> <br>
                <b>Customer:</b> <?= $customer["name"]  ?> <br>
                <b>Email:</b> <?= $customer["email"]  ?> <br>
                <b>Phone:</b> <?= $customer["phone"]  ?> <br>
                <b>Address:</b> <?= $customer["address"]  ?> <br>
                <b>Date of birth:</b> <?= $customer["birth_date"] ?>
            </div>
        </div>
        <div class="customer-detail" style="border: 1px solid blue; padding: 20px; border-radius: 10px; margin: 10px;">
            <hr>
            <h3>
                Confirm consignee information
            </h3>
            <hr>
            <form action="/cart/push-confirm" method="post">
                <div class="form-group">
                    <label for="name">
                        <h5>
                            Name of consignee
                        </h5>
                        <input type="text" class="form-control" name="name" id="name" placeholder="Your name ..." require value="<?php if (isset($_SESSION["name"]) && $_SESSION["name"]) {
                                                                                                                                        echo ($_SESSION["name"]);
                                                                                                                                    } else {
                                                                                                                                        echo ($customer["name"]);
                                                                                                                                    } ?>">
                        <span id="r-name-err" class="warning err"></span>
                    </label>
                </div>
                <div class="form-group">
                    <label for="phone">
                        <h5>Phone number of consignee</h5>
                        <div class="form-group">
                            <input type="text" class="form-control" name="phone" id="phone" placeholder="Your Phone's number ..." require pattern="^[+]*[(]{0,1}[0-9]{1,4}[)]{0,1}[-\s\./0-9]*$" value="<?php if (isset($_SESSION["phone"]) && $_SESSION["phone"]) {
                                                                                                                                                                                                            echo ($_SESSION["phone"]);
                                                                                                                                                                                                        } else {
                                                                                                                                                                                                            echo ($customer["phone"]);
                                                                                                                                                                                                        } ?>">
                            <span id="phone-err" class="warning err"></span>
                    </label>
                </div>
                <div class="form-group">
                    <h5>Address of consignee
                    </h5>
                    <label for="address">
                        <textarea type="text" rows="2" cols="50" class="form-control" name="address" id="address" placeholder="Your adress ..." require parent="[\w]{5,}"><?php if (isset($_SESSION["address"]) && $_SESSION["address"]) {
                                                                                                                                                                                echo ($_SESSION["address"]);
                                                                                                                                                                            } else echo $customer["address"] ?></textarea>
                        <span id="address-err" class="warning err"></span>
                    </label>
                </div>
                <div class="form-group">
                    <h5>Note about the order</h5>
                    <label for="note">

                        <textarea type="text" rows="2" cols="50" class="form-control" name="note" id="note" placeholder="Note ..."><?php if (isset($_SESSION["note"]) && $_SESSION["note"]) echo ($_SESSION["note"]) ?></textarea>
                        <span id="note-err" class="warning err"></span>
                    </label>
                </div>
                <div id="login-form-action">
                    &emsp;
                    <button type="submit" class="btn btn-info btn-block btn-round register_btn" id="submit" onclick="return confirmOrderHandling()"> Push Order </button>
                    <br><br>
                </div>
            </form>
        </div>

    </div>

</div>