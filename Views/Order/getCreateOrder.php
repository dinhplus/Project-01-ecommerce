<?php
if (empty($_GET["page"])) {
    $_GET["page"] = 1;
}
?>
<div class="list-products">
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
                                    $position = strpos($product["description"], " ", 200);
                                    echo (substr($product["description"], -$position));
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
                                            ?>" alt="">
                            </div>
                        </td>
                        <td>
                            <div class="product-action">
                                <!-- TODO Define Action for javaScript function addToCart(pid) -->
                                <button type="submit" id="delete-product-btn" onclick="addToCart(<?= $product['id'] ?>)">Add this product to order</button>

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