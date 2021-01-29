<div class="order-detail row" style="width: 100%; margin-top:100px;  margin-bottom: 80px; justify-content:space-around">
    <div class="row" style="width: 100%;">

    </div>
    <div class="order-common col-4">
        <hr><br>
        <h3>Order Summary</h3>
        <div class="td-row">
            <b>Order index: &nbsp;</b>
            <?= $order["id"] ?>
        </div>
        <div class="td-row">
            <b>Status: &nbsp;</b>
            <?= $order["order_status"] ?>
        </div>
        <div class="td-row">
            <b>Create time: &nbsp;</b>
            <?= $order["created_at"] ?>
        </div>
        <div class="td-row">
            <b>Total Price: &nbsp;</b>
            <?= $order["total_price"] ?>
        </div>
        <?php if ($order["status_id"] > 1) { ?>
            <div class="td-row">
                <b>Update time: &nbsp;</b>
                <?= $order["update_at"] ?>
            </div>
            <div class="td-row">
                <b>Updated by (staff id): &nbsp;</b>
                <?= $order["staff_ref"] ?>
            </div>
            <div class="td-row">
                <b>Note: &nbsp;</b>
                <?= $order["note"] ?>
            </div>
        <?php } ?>

        <hr>
        <h3>Customer summary</h3>
        <br>
        <div class="td-row">
            <b>Customer Name: </b>
            <?= $order["customer_name"] ?>
        </div>
        <div class="td-row">
            <b>Customer's Email: &nbsp;</b>
            <?= $order["customer_email"] ?>
        </div>
        <div class="td-row">
            <b>Phone Number: &nbsp;</b>
            <?= $order["customer_phone_number"] ?>
        </div>
        <div class="td-row">
            <b>Adress: &nbsp;</b>
            <?= $order["customer_address"] ?>
        </div>
        <hr>
        <h3>
            Consignee information
        </h3>
        <div class="td-row">
            <b>Name of consignee: </b>
            <?= $order["name"] ?>
        </div>
        <div class="td-row">
            <b>Phone number of consignee: </b>
            <?= $order["phone"] ?>
        </div>
        <div class="td-row">
            <b>Address of consignee: </b>
            <?= $order["address"] ?>
        </div>
    </div>
    <div class="col-6 col-xl-6 col-md-6">
        <?php foreach ($order["products"] as $product) { ?>
            <div class="row col-12 col-xl-12 col-md-12" style="border: 1px solid blue; border-collapse:collapse; margin-bottom: 30px; border-radius: 10px ; width:100% ; padding:10px" >

            <div class="item-img col-5 col-xl-5 col-lg-4">
                    <a href="<?= "http://" . HOST . "/product/detail?pid=" . $product["product_id"] ?>">
                        <img src="<?= imageRender($product["img_ref"]) ?>" alt="" style=" max-height: 200px; max-width: 250px">
                    </a>
                </div>
                <div class="content-summary col-5 col-xl-6 col-lg-6 col-md-6 col-sm-11" style="margin-left: 10px; ">
                    <b>
                        <h4>
                            <?= $product["name"] ?>
                        </h4>
                    </b>
                    <b>Unit Price: &nbsp;</b>
                    <?= $product["unit_price"] ?>
                    <br> <b>Quantity: &nbsp;</b>
                    <?= $product["quantity"] ?>
                </div>

            </div>
        <?php } ?>
    </div>


    <div class="row" style=" position: fixed; bottom:0;width:85%; justify-content: center;">
        <?php if ($order["status_id"] < 4) { ?>
            <hr>
            <form action="/user/order/cancel" method="POST" style="width: 80%;">
                <input type="hidden" name="oid" value="<?= $order["id"] ?>">
                <input type="hidden" name="change_status_note" id="change_status_note">
                <button type="submit" onclick="return cancelOrderConfirm()" class="btn btn-danger form-control" style="width: 100%;">Cancel Order</button>
            </form>
        <?php } ?>


    </div>
</div>