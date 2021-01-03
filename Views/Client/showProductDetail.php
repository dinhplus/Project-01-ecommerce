<div class="row" style="width: 100%;">
    <div class="row col-12 col-xl-10 col-lg-9 col-md-12 _product_detail_">
        <div class="product-detail">
            <div class="product-infor-row" id="product-detail-name">
                <h1><b>Name: </b>
                    <?= $product["name"] ?>
                </h1>
            </div>
            <form action="/cart/add-item?pid=<?= $product['id'] ?>" method="GET">
                <input type="hidden" name="pid" id="pid" value="<?= $product['id'] ?>">
                <button type="submit" class="btn-primary" id="add-to-cart-btn">Add to cart</button>
            </form>
            <hr>
            <div class="detail-body container">
                <div class="product-image">
                    <img src="<?= imageRender($product["img_ref"])
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
                        <b>Price: &nbsp;</b>
                        <?= $product["price"] ?>
                    </div>
                    <div class="product-infor-row">
                        <b>Status: &nbsp;</b>
                        <?php if ($product["quantity"] > 0) {
                            echo (" Available now.");
                        } else {
                            echo ("Sold out");
                        } ?>
                    </div>
                </div>
            </div>
            <div class="product-description container">
                <h2>Description: <br></h2>
                <?= $product["description"] ?>
            </div>
        </div>


    </div>
    <?php if (isset($_SESSION["customerId"])) { ?>
        <div class="col-6 col-xl-2 col-lg-3 col-md-6 cart_info row">
            <!-- <?php print_r($customer) ?> -->
        </div>
    <?php } ?>
</div>