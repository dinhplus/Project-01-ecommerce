<?php
if (empty($_GET["page"])) {
    $_GET["page"] = 1;
    // pd($orders);
}
?>

<div class="list-orders">

    <div class="data">
        <table>
            <tr>
                <th>
                    Order index
                </th>
                <th>
                    Customer Information
                </th>
                <th>
                    Order common
                </th>
                <th>
                    Order Detail
                </th>
                <th> Other Action</th>
            </tr>
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
                    <tr>
                        <td>
                            <?= $order["id"] ?>
                        </td>
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
                                <?php } ?>
                            </div>
                        </td>
                        <td>
                            <div class="order-detail">
                                <?php foreach ($order["products"] as $product) { ?>
                                    <div class="td-row" style="border: 1px solid blue; border-collapse:collapse">
                                        <b>Name: &nbsp;</b>
                                        <?= $product["name"] ?>
                                        <br>
                                        <b>Unit Price: &nbsp;</b>
                                        <?= $product["unit_price"] ?>
                                        <br> <b>Quantity: &nbsp;</b>
                                        <?= $product["quantity"] ?>
                                    </div>
                                <?php } ?>
                            </div>
                        </td>
                        <td>
                            <div class="order-action">
                                <form action="/dashboard/order-manager/delete-order" method="POST">
                                    <input type="hidden" name="pid" value="<?= $order["id"] ?>">
                                    <button type="submit" id="delete-order-btn" onclick="return window.confirm('Are You sure? This action can not revert, Continute?')">Delete</button>
                                </form>
                                <form action="/dashboard/order-manager/edit-order?pid=<?= $order['id'] ?>" method="GET">
                                    <input type="hidden" name="pid" id="pid" value="<?= $order['id'] ?>">
                                    <button type="submit" id="edit-order-btn">Edit Order</button>
                                </form>
                                <form action="/dashboard/order-manager/order-detail?oid=<?= $order['id'] ?>" method="GET">
                                    <input type="hidden" name="pid" id="pid" value="<?= $order['id'] ?>">
                                    <button type="submit" id="show-order-btn"> Show Detail</button>
                                </form>
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