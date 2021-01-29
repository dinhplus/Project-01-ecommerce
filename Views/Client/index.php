<?php
if (empty($_GET["page"])) {
    $_GET["page"] = 1;
}
// pd($products);
?>

<div class="row" style="width: 100%;">
    <div class="row col-12 col-xl-10 col-lg-9 col-md-12 item_list">
        <?php foreach ($products as $product) {
            if ($product["status_id"] > 1) {
        ?>
                <div class="card shop_item" style="width: 18rem;">

                    <div class="card-header">
                        <h5 class="card-title"><?= $product["name"] ?></h5>
                    </div>
                    <img class="card-img-top" src="<?= imageRender($product["img_ref"]) ?>" alt="Card image cap">
                    <div class="card-body">

                        <p class="card-text"><b> Price: </b> <?= $product["price"] ?> </p>
                        <p class="card-text"><b> Brand: </b> <?= $product["brand"] ?> </p>
                        <p class="card-text"><b> Category: </b> <?= $product["category"] ?> </p>
                        <p class="card-text"><?php
                                                if (strlen(($product["description"])) > 150) {
                                                    echo (substr($product["description"], 0, 150));
                                                } else echo ($product["description"]);
                                                ?></p>
                        <div class="card-footer text-muted" style="position:absolute; bottom:0px;background:white;z-index:10">

                            <a href="<?= "http://" . HOST . "/product/detail?pid=" . $product["id"] ?>" class="btn btn-detail">Show Detail</a>
                            <a href="/cart/add-item?pid=<?= $product['id'] ?>" class="btn btn-primary">Add to cart</a>
                        </div>
                    </div>
                </div>
        <?php  }
        } ?>


    </div>
    <?php if (isset($_SESSION["customerId"])) { ?>
        <div class="col-6 col-xl-2 col-lg-3 col-md-6 cart_info" style="margin-top: 20px; position: relative;">
            <div class="" style="position: fixed ; width:100%; top: 80px;">
                <h4> Welcome: <br> <?= $customer["name"] ?></h4>
                <hr>
                <h5><b>Current Shopping session:</b></h5> <br>
                <b>Total Item:</b> <?= $totalItem ?> <br>

                <b>Total Price:</b> $<?= $totalPrice ?> <br>
            </div>
            <form action="/cart/show-cart" style="position: fixed ; width:100%; bottom: 0;">
                <button type="submit" class="btn btn-success" style="width:15%;"> Go to checkout</button>
            </form>
        </div>
    <?php } ?>
</div>

<?php if (isset($pageQtt) && $pageQtt > 1) {
    $paginate = '';
    for ($page = 1; $page <= $pageQtt; $page++) {
        $paginate .= '<li class="page-item';
        if ($page == $_GET["page"]) {
            $paginate .= ' current-page';
        }
        $paginate .= '"><a class="page-link" href="http://' . HOST . '/product/index?page=' . $page;
        if (isset($_GET["q"]) && !(preg_match("/^[\s]*$/", $_GET["q"]) || $_GET["q"] == '')) {
            $paginate .= '&q=' . $_GET["q"];
        }
        if (isset($_GET["category"]) && !(preg_match("/^[\s]*$/", $_GET["category"]) || $_GET["category"] == '')) {
            $paginate .= '&category=' . $_GET["category"];
        }
        if (isset($_GET["brand"]) && !(preg_match("/^[\s]*$/", $_GET["brand"]) || $_GET["brand"] == '')) {
            $paginate .= '&brand=' . $_GET["brand"];
        }
        $paginate .= ' ">' . $page . '</a></li>';
    }
?>
    <nav aria-label="Page navigation example">
        <ul class="pagination justify-content-center">

            <?= $paginate ?>
        </ul>
    </nav>

<?php } ?>