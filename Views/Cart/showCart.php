<?php ?>
<div class="row" style="width: 90%; margin-bottom:50px; margin-top: 100px">
    <div class="order-detail row col-12 col-xl-8 col-lg-8 col-md-12">
        <div class="list-item" style="margin-left: 50px; width:100%; justify-content:space-between">
            <?php if (count($cart) === 0) { ?>
                <center>
                    <h1>Cart is empty! </h1>
                </center>
            <?php } ?>
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
    <div class="order-common col-12 col-xl-3 col-lg-4 col-md-12">
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
        <?php if ($cart && count($cart) > 0) { ?>
            <div class="clean-up">
                <form action="<?= "http://" . HOST . "/cart/clean-up" ?>" method="get">
                    <button type="submit" class="btn btn-danger" style="width: 100%;" onclick="return confirm('Are you sure?')"> Clean Up Cart</button>
                </form>
            </div>
            <div class="confirm-order">
                <form action="<?= "http://" . HOST . "/cart/get-confirm" ?>" method="get">
                    <button type="submit" class="btn btn-info" style="width: 100%;"> Confirm order</button>
                </form>
            </div>
        <?php } ?>
    </div>
</div>