<div class=" container" style="margin-bottom: 50px;">
    <div class="product-infor-row" id="product-detail-name">
        <h1><b>Name: </b>
            <?= $product["name"] ?>
        </h1>
    </div>
    <form action="/dashboard/product-manager/edit-product?pid=<?= $product['id'] ?>" method="GET">
        <input type="hidden" name="pid" id="pid" value="<?= $product['id'] ?>">
        <button type="submit" id="edit-product-btn" class="btn btn-warning" style="position:fixed; bottom:0; right:0; width:80%">Edit Product</button>
    </form>
    <hr>
    <div class="detail-body">
        <div class="product-image container col-12">
            <img style="width: 100%;" src="<?= imageRender($product["img_ref"]) ?>" alt="<?= $product["name"] ?>">
        </div>
        <br> <br>
        <div class="product-infor container">

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
    <div class="product-description container container-fluid">
        <h2>Description: <br></h2> <br> <br>
        <?= $product["description"] ?>
    </div>
</div>