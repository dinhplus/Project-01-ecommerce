<?php

if (empty($_GET["page"])) {
    $_GET["page"] = 1;
}

?>
<div class="list-products" style="width: 100%;">
    <div class="action">

        <?php
        if (
            $_SESSION["role"] > 0
            && $_SESSION["role"] !== 3
        ) { ?>
            <div class="generate-product">
                <form action="/dashboard/product-manager/create-product" method="GET">
                    <!-- <input type="text"> -->
                    <button type="submit" id="create-product-btn" class="btn btn-primary btn-round"> New Product</button>
                </form>
            </div> <br>
        <?php } ?>

    </div>
    <div class="" style="width: 100%;">
        <table style="width: inherit;" class="table table-striped">
            <tr>
                <th scope="col">
                    id
                </th>
                <th scope="col">
                    Information
                </th>
                <th scope="col">
                    Description
                </th>
                <th scope="col">
                    Cover Image
                </th>
                <th scope="col"> Other Action</th>
            </tr>
            <?php
            if (!empty($products) && isset($pageQtt)) {
                $paginate = '';
                for ($page = 1; $page <= $pageQtt; $page++) {
                    $paginate .= '<a href=http://' . HOST . '/dashboard/product-manager/remainder?page=' . $page;
                    $paginate .= '&sort=' . ($_GET["sort"]??1);
                    if (isset($_GET["q"]) && !(preg_match("/^[\s]*$/", $_GET["q"]) || $_GET["q"] == '')) {
                        $paginate .= '&q=' . $_GET["q"];
                    }
                    if (isset($_GET["category"]) && !(preg_match("/^[\s]*$/", $_GET["category"]) || $_GET["category"] == '')) {
                        $paginate .= '&category=' . $_GET["category"];
                    }
                    if (isset($_GET["brand"]) && !(preg_match("/^[\s]*$/", $_GET["brand"]) || $_GET["brand"] == '')) {
                        $paginate .= '&brand=' . $_GET["brand"];
                    }
                    $paginate .= ' class = "paginate"> <button>page ' . $page . '</button></a>';
                }
                foreach ($products as $key => $product) {
            ?>
                    <tr>
                        <td scope="row">
                            <?= $product["id"] ?>
                        </td>
                        <td>
                            <div class="product-infor">


                                <div class="td-row">
                                    <b>Name: </b>
                                    <?= $product["name"] ?>
                                </div>
                                <div class="td-row">
                                    <b>Brand: &nbsp;</b>
                                    <?= $product["brand"] ?>
                                </div>
                                <div class="td-row">
                                    <b>Category: &nbsp;</b>
                                    <?= $product["category"] ?>
                                </div>
                                <div class="td-row">
                                    <b>Quantity: &nbsp;</b>
                                    <?= $product["quantity"] ?>
                                </div>
                                <div class="td-row">
                                    <b>Price: &nbsp;</b>
                                    <?= $product["price"] ?>
                                </div>
                                <div class="td-row">
                                    <b>Status: &nbsp;</b>
                                    <?= $product["status"] ?>
                                </div>
                            </div>
                        </td>
                        <td style="width:30%">
                            <div class="product-description" >
                                <?php
                                if (strlen(($product["description"])) > 200) {
                                    echo (substr($product["description"], 0, 200));
                                } else echo ($product["description"]);

                                ?>

                            </div>
                        </td>
                        <td>
                            <div class="product-cover-img">
                                <img src="<?php if (preg_match("/^http?/", $product["img_ref"])) {
                                                echo ($product["img_ref"]);
                                            } else {
                                                echo ("http://" . HOST . $product["img_ref"]);
                                            }
                                            ?>" alt="" style="width:300px">
                            </div>
                        </td>
                        <td>
                            <div class="row" >
                                <div class="product-action" >
                                    <form action="/dashboard/order-manager/add-item" method="POST">
                                        <input type="hidden" name="pid" value="<?= $product["id"] ?>">
                                        <input type="hidden" name="itemQtt" id="" value=1>
                                        <button type="submit" id="delete-product-btn" onclick="return window.confirm('Add this product to new order?')" style="background: green; color:white; " class="btn btn-round">add to order</button>
                                    </form>
                                    <form action="/dashboard/product-manager/product-detail?pid=<?= $product['id'] ?>" method="GET">
                                        <input type="hidden" name="pid" id="pid" value="<?= $product['id'] ?>">
                                        <button class="btn btn-round" type="submit" id="show-product-btn" style="background: blue; color:white; "> Show Detail</button>
                                    </form>
                                </div>
                                <div class="product-action" style="width:200px">
                                    <form action="/dashboard/product-manager/delete-product" method="POST">
                                        <input type="hidden" name="pid" value="<?= $product["id"] ?>">
                                        <button class="btn btn-round" type="submit" id="delete-product-btn" onclick="return window.confirm('Are You sure? This action can not revert, Continute?')" style="background: red; color:white; ">Delete</button>
                                    </form>
                                    <form action="/dashboard/product-manager/edit-product?pid=<?= $product['id'] ?>" method="GET">
                                        <input type="hidden" name="pid" id="pid" value="<?= $product['id'] ?>">
                                        <button class="btn btn-round" type="submit" id="edit-product-btn" style="background: blue; color:white; ">Edit Product</button>
                                    </form>

                                </div>
                            </div>
                        </td>

                    </tr>

            <?php
                }
            }
            ?>
        </table>
        <?php if ($pageQtt > 1)  echo ($paginate); ?>
    </div>


</div>