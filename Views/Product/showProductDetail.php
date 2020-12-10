<div class="product-detail">
    <div class="product-infor-row" id="product-detail-name">
        <h1><b>Name: </b>
        <?= $product["name"] ?>
        </h1>
    </div>
    <form action="/dashboard/product-manager/edit-product?pid=<?= $product['id']?>" method="GET">
                                    <input type="hidden" name="pid" id="pid" value="<?=$product['id']?>">
                                    <button type="submit" id="edit-product-btn">Edit Product</button>
                                </form>
    <hr>
    <div class="detail-body">
        <div class="product-image">
            <img src="<?php if (preg_match("/^http?/", $product["img_ref"])) {
                            echo ($product["img_ref"]);
                        } else {
                            echo ("http://" . HOST . $product["img_ref"]);
                        }
                        ?>" alt="<?= $product["name"] ?>">
        </div>

        <div class="product-infor">

            <div class="product-infor-row">
                <b>Brand: &nbsp;</b>
                <?= $product["brand"] ?>
            </div>
            <div class="product-infor-row">
                <b>Category: &nbsp;</b>
                <?= $product["category"] ?>
            </div>
            <div class="product-infor-row">
                <b>Quantity: &nbsp;</b>
                <?= $product["quantity"] ?>
            </div>
            <div class="product-infor-row">
                <b>Price: &nbsp;</b>
                <?= $product["price"] ?>
            </div>
            <div class="product-infor-row">
                <b>Status: &nbsp;</b>
                <?= $product["status"] ?>
            </div>
        </div>
    </div>
    <div class="product-description">
        <h2>Description: <br></h2>
        <?=$product["description"] ?>
    </div>
</div>