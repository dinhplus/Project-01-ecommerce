<?php ?>

<div class="row container" style="width: 80%; margin-bottom:50px; margin-top: 100px">
    <div class="order-detail">
        <div class="list-item" style="margin-left: 50px;">
            <?php foreach ($cart as $item) { ?>
                <div class="td-row" style="border: 1px solid blue; border-collapse:collapse; margin-bottom: 30px">
                    <b> <h3>
                    <?= $item["name"] ?>
                    </h3>
                    </b>
                    <b>Unit Price: &nbsp;</b>
                    <?= $item["unit_price"] ?>
                    <br> <b>Quantity: &nbsp;</b>
                    <?= $item["item_quantity"] ?>
                    <div class="item-img">
                        <img src="<?php if (preg_match("/^http?/", $item["img_ref"])) {
                                        echo ($item["img_ref"]);
                                    } else {
                                        echo ("http://" . HOST . $item["img_ref"]);
                                    }
                                    ?>" alt="">
                    </div>
                </div>
            <?php } ?>
        </div>
    </div>
    <div class="customer-detail">

    </div>
</div>