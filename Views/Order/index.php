<?php
if (empty($_GET["page"])) {
    $_GET["page"] = 1;
}
?>

<div class="list-orders " style="width: 100%;">
    <?php?>
    <div class="row">

        <form action="" method="GET">
            <input type="hidden" name="cheapest" id="" value="1">
            <!-- <input type="hidden" name="newest" id="" value=0> -->
            <button type="submit" class="btn btn-primary">Order By cheapest</button>
        </form>
        <form action="" method="GET">
            <input type="hidden" name="cheapest" id="" value="-1">
            <!-- <input type="hidden" name="newest" id="" value=0> -->
            <button type="submit" class="btn btn-warning">Order By most expensive</button>
        </form>
    </div>
    <?php?>
    <div class="" style="width: 100%;">
        <table class="table table-striped .table-responsive" style="width: 100%;">
            <thead>
                <tr>
                    <th scope="col">
                    <form action="" method="get">
                                    <input type="hidden" name="newest" id="" value="<?=isset($_GET["newest"])?-intval($_GET["newest"]):1?>">
                                    <!-- <input type="hidden" name="cheapest" id="" value=0> -->
                                    <button type="submit" class="" value="#" style="background:#e3e6e7; border:0;width:40px;height:30px"> # </button>
                                </form>
                    </th>
                    <th scope="col">
                        Customer Information
                    </th>
                    <th scope="col">
                        Consignee information
                    </th>
                    <th scope="col">
                        Order common
                    </th>
                    <th scope="col">
                        Order Detail
                    </th>
                    <th> Other Action</th>
                </tr>
            </thead>
            <?php
            if (!empty($orders) && isset($pageQtt)) {
                $paginate = '';
                for ($page = 1; $page <= $pageQtt; $page++) {
                    $paginate .= '<a href=http://' . HOST . '/dashboard/order-manager/index?page=' . $page;
                    if (isset($_GET["q"]) && !(preg_match("/^[\s]*$/", $_GET["q"]) || $_GET["q"] == '')) {
                        $paginate .= '&q=' . $_GET["q"];
                    }
                    if (isset($_GET["oid"]) && !(preg_match("/^[\s]*$/", $_GET["oid"]) || $_GET["oid"] == '')) {
                        $paginate .= '&oid=' . $_GET["oid"];
                    }
                    if (isset($_GET["cid"]) && !(preg_match("/^[\s]*$/", $_GET["cid"]) || $_GET["cid"] == '')) {
                        $paginate .= '&cid=' . $_GET["cid"];
                    }
                    if (isset($_GET["startDateRange"]) && !(preg_match(DATE_TIME_REGEX_PATTERN, $_GET["startDateRange"]) || $_GET["startDateRange"] == '')) {
                        $paginate .= '&startDateRange=' . $_GET["startDateRange"];
                    }
                    if (isset($_GET["endDateRange"]) && !(preg_match("/^[\s]*$/", $_GET["endDateRange"]) || $_GET["endDateRange"] == '')) {
                        $paginate .= '&brand=' . $_GET["brand"];
                    }
                    $paginate .= ' class = "paginate"> <button>page ' . $page . '</button></a>';
                }
                foreach ($orders as $key => $order) {
                    // pd($order);
            ?>
                    <tbody>
                        <tr>
                            <th scope="row">
                                <?= $order["id"] ?>
                            </th>
                            <td>

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
                            </td>
                            <td>
                                <div class="customer-infor">


                                    <div class="td-row">
                                        <b>Consignee Name: </b>
                                        <?= $order["name"] ?>
                                    </div>
                                    <div class="td-row">
                                        <b>Consignee Number: &nbsp;</b>
                                        <?= $order["phone"] ?>
                                    </div>
                                    <div class="td-row">
                                        <b>Consignee Adress: &nbsp;</b>
                                        <?= $order["address"] ?>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <div class="order-common">
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
                            </td>
                            <td>
                                <div class="order-detail">
                                    <ul class="list-group">
                                        <?php foreach ($order["products"] as $product) { ?>
                                            <li class="list-group-item list-group-item-action">
                                                <b><?= $product["product_id"] ?>. &nbsp;</b>
                                                <?= $product["name"] ?>

                                            </li>
                                        <?php } ?>
                                    </ul>
                                </div>
                            </td>
                            <td>
                                <div class="order-action">
                                    <!-- <form action="/dashboard/order-manager/delete-order" method="POST">
                                    <input type="hidden" name="pid" value="<?= $order["id"] ?>">
                                    <button type="submit" id="delete-order-btn" onclick="return window.confirm('Are You sure? This action can not revert, Continute?')">Delete</button>
                                </form>
                                <form action="/dashboard/order-manager/edit-order?pid=<?= $order['id'] ?>" method="GET">
                                    <input type="hidden" name="pid" id="pid" value="<?= $order['id'] ?>">
                                    <button type="submit" id="edit-order-btn">Edit Order</button>
                                </form> -->
                                    <form action="/dashboard/order-manager/order-detail" method="GET">
                                        <input type="hidden" name="oid" id="oid" value="<?= $order['id'] ?>">
                                        <button type="submit" id="show-order-btn" class="btn btn-primary"> Show Detail</button>
                                    </form>
                                    <?php if($order["customer_id"]){?>
                                <form action="" method="get">
                                    <input type="hidden" name="cid" id="" value="<?=$order["customer_id"]?>">
                                    <button type="submit" class="btn btn-info">View this customer</button>
                                </form>
                                <?php }?>
                                </div>
                            </td>

                        </tr>
                    </tbody>
            <?php
                }
            }
            ?>
        </table>
        <?php if ($pageQtt > 1)  echo ($paginate); ?>
    </div>


</div>