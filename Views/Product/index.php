<?php
if (empty($_GET["page"])) {
    $_GET["page"] = 1;
}
?>
<div class="list-products">
    <div class="action">

        <?php
        if (
            $_SESSION["role"] > 0
            && $_SESSION["role"] !== 3
        ) { ?>
            <div class="generate-product">
                <form action="/dashboard/product-manager/create-product" method="GET">
                    <!-- <input type="text"> -->
                    <button type="submit" id="create-product-btn"> New Product</button>
                </form>
            </div>
        <?php } ?>
    </div>
    <div class="data">
        <table>
            <tr>
                <th>
                    id
                </th>
                <th>
                    Information
                </th>
                <th>
                    Description
                </th>
                <th>
                    Cover Image
                </th>
                <th> Other Action</th>
            </tr>
            <?php
            if (!empty($products) && isset($pageQtt)) {
                $paginate = '';
                for ($page = 1; $page <= $pageQtt; $page++) {
                    $paginate .= '<a href=http://' . HOST . '/dashboard/product-manager/index?page=' . $page;
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
                        <td>
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
                        <td>
                            <div class="product-description">
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
                            <div class="" style="display: flex;">
                                <div class="product-action">
                                    <form action="/dashboard/order-manager/add-item" method="POST">
                                        <input type="hidden" name="pid" value="<?= $product["id"] ?>">
                                        <input type="hidden" name="itemQtt" id="" value=1>
                                        <button type="submit" id="delete-product-btn" onclick="return window.confirm('Add this product to new order?')" style="background: green; color:white; width:80px; height:40px">add items to temp order</button>
                                    </form>
                                </div>
                                <div class="product-action" style="width:200px">
                                    <form action="/dashboard/product-manager/delete-product" method="POST">
                                        <input type="hidden" name="pid" value="<?= $product["id"] ?>">
                                        <button type="submit" id="delete-product-btn" onclick="return window.confirm('Are You sure? This action can not revert, Continute?')" style="background: red; color:white; width:80px; height:30px">Delete</button>
                                    </form>
                                    <form action="/dashboard/product-manager/edit-product?pid=<?= $product['id'] ?>" method="GET">
                                        <input type="hidden" name="pid" id="pid" value="<?= $product['id'] ?>">
                                        <button type="submit" id="edit-product-btn" style="background: blue; color:white; width:80px; height:30px">Edit Product</button>
                                    </form>
                                    <form action="/dashboard/product-manager/product-detail?pid=<?= $product['id'] ?>" method="GET">
                                        <input type="hidden" name="pid" id="pid" value="<?= $product['id'] ?>">
                                        <button type="submit" id="show-product-btn" style="background: blue; color:white; width:80px; height:30px"> Show Detail</button>
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