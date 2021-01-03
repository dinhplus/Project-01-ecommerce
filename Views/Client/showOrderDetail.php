<div class="order-detail">
    <div class="order-common">
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
    </div>
    <div class="list-item">
        <?php foreach ($order["products"] as $product) { ?>
            <div class="td-row" style="border: 1px solid blue; border-collapse:collapse">
                <b><?= $product["product_id"] ?>. &nbsp;</b>
                <?= $product["name"] ?>
                <br>
                <b>Unit Price: &nbsp;</b>
                <?= $product["unit_price"] ?>
                <br> <b>Quantity: &nbsp;</b>
                <?= $product["quantity"] ?>
                <div class="item-img">
                <img src="<?php if (preg_match("/^http?/", $product["img_ref"])) {
                                                echo ($product["img_ref"]);
                                            } else {
                                                echo ("http://" . HOST . $product["img_ref"]);
                                            }
                                            ?>" alt="">
                </div>
            </div>
        <?php } ?>
    </div>
    <div class="customer-infor">
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
    </div>
    <div class="action">
        <?php if ($order["status_id"] == 1) { ?>
            <form action="/dashboard/order-manager/change-status" method="POST">
                <input type="hidden" name="oid" value="<?= $order["id"] ?>">
                <input type="hidden" name="status_id" value="2">
                <button type="submit" id="" onclick="return window.confirm('Are You sure? This action can not revert, Continute?')">Confirm the Order</button>
            </form>
        <?php } ?>

        <?php if ($order["status_id"] < 4) { ?>
            <form action="/dashboard/order-manager/change-status" method="POST">
                <input type="hidden" name="oid" value="<?= $order["id"] ?>">
                <input type="hidden" name="status_id" value="4">
                <button type="submit" id="" onclick="return window.confirm('Are You sure? This action can not revert, Continute?')">Complete Order</button>
            </form>

        <hr>
        <form action="/dashboard/order-manager/change-status" method="POST">
            <input type="hidden" name="oid" value="<?= $order["id"] ?>">
            <input type="hidden" name="status_id" value="6">
            <button type="submit" id="" onclick="return window.confirm('Are You sure? This action can not revert, Continute?')">Cancel Order</button>
        </form>
        <?php } ?>



    </div>
</div>