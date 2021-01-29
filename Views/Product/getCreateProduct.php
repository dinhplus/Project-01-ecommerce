<div class="create-product-form">

    <form action="/dashboard/product-manager/create-product" method="POST" enctype="multipart/form-data">

        <h1 align="center">
            Insert new product into product list
        </h1>
        <hr><br><br>
        <div class="form-component">
            <label for="name">
                Product Name <br>
                <input type="text" name="name" class="name" id="name" placeholder="Product's Name...">
                <span id="name-err" class="warning err"></span>
            </label>
        </div>
        <div class="form-component">
            <label for="brand">
                Brand <br>
                <select id="brand" name="brand" value="<?php if (isset($inputted)) echo ($inputted["brand"]) ?>" <?php if (isset($brands) && count($brands) > 0) {
                                                                                                                        echo ('default="' . $brands['1']['name'] . '"');
                                                                                                                    } ?>>
                    <?php if (isset($brands) && count($brands) > 0) {
                        foreach ($brands as $key => $brand) {
                    ?>
                            <option value="<?= $brand["id"] ?>">
                                <?= $brand["name"] ?>
                            </option>
                    <?php }
                    } ?>
                </select>
                <span id="username-err" class="warning err"></span>
            </label>
        </div>
        <div class="form-component">
            <label for="category">
                Category <br>
                <select id="category" name="category" value="<?php if (isset($inputted)) echo ($inputted["category"]) ?>" <?php if (isset($categories) && count($categories) > 0) {
                                                                                                                                echo ('default="' . $categories['1']['label'] . '"');
                                                                                                                            } ?>>
                    <?php if (isset($categories) && count($categories) > 0) {
                        foreach ($categories as $key => $category) {
                    ?>
                            <option value="<?= $category["id"] ?>">
                                <?= $category["label"] ?>
                            </option>
                    <?php }
                    } ?>
                </select>
                <span id="username-err" class="warning err"></span>
            </label>
        </div>
        <div class="form-component">
            <label for="warranty-cycle">
                Warranty cycle <br>
                <input type="text" name="warranty-cycle" class="warranty-cycle" id="warranty-cycle" placeholder="Warranty cycle...">
                <span id="warranty-cycle-err" class="warning err"></span>
            </label>
        </div>
        <div class="form-component">

            <label for="description">
                <!-- TODO expect_feature: input description & image with flex-form, auto show all by formatted document. use ck-editer -->
                Description <br>
                <textarea type="text" name="description" class="description" id="description" placeholder="Product's description..."> </textarea>
                <span id="description-err" class="warning err"></span>
            </label>
        </div>
        <div class="form-component">

            <label for="price">
                Price <br>
                <input type="number" name="price" class="price" id="price" placeholder="Product's price...">
                <span id="price-err" class="warning err"></span>
            </label>
        </div>
        <div class="form-component" id="image-selecting">
        Image <br>
            <div id="old-product-image">
                <!-- <span>
                    Do nothing to keep old image.
                </span> -->
                <img src="<?php if (preg_match("/^http?/", $product["img_ref"])) {
                                echo ($product["img_ref"]);
                            } else {
                                echo ("http://" . HOST . $product["img_ref"]);
                            }
                            ?>" alt="">
            </div>
            <input type="radio" name="image-selector" id="custom-url-img" value="1">
            <label for="custom-url-img">
                Custom URL
            </label>
            <br>
            <input type="radio" name="image-selector" id="upload-img" value="2">
            <label for="upload-img">
                Upload new Image
            </label>
            <label for="custom-url-input" id="custom-url">
                <input type="text" name="img_ref" id="custom-url-input">
            </label>
            <label for="upload-img-input" id="upload-image">
                <input type="file" name="img_ref" class="img_ref" id="upload-img-input" placeholder="Choose image">
                <span id="img-err" class="warning err"><?php if (isset($message) && isset($message["image"])) {
                                                            print_r($message["image"]);
                                                        } ?></span>
            </label>
            <!-- <label for="img_ref">
                Upload image <br>
                <input type="file" name="img_ref" class="img_ref" id="img_ref" placeholder="Choose image">
                <span id="name-err" class="warning err"><?php if (isset($message) && isset($message["image"])) {
                                                            print_r($message["image"]);
                                                        } ?></span>
            </label> -->
        </div>
        <div class="form-component">

            <label for="quantity">
                Quantity <br>
                <input type="text" name="quantity" class="quantity" id="quantity" placeholder="Quantity...">
                <span id="quantity-err" class="warning err"></span>
            </label>
        </div>
        <?php if ($_SESSION["role"] > 3) { ?>
            <div class="form-component">
                <label for="status">
                    Status <br>
                    <select id="status"
                        name="status"
                        value="<?php
                        if (isset($inputted))
                            echo ($inputted["status"])
                        ?>"
                        <?php if (isset($status) && count($status) > 0) {
                            echo ('default="' . $status['1']['label'] . '"');
                        } ?>>
                        <?php if (isset($status) && count($status) > 0) {
                            foreach ($status as $key => $stt) {
                        ?>
                            <option value="<?= $stt["id"] ?>">
                                <?= $stt["label"] ?>
                            </option>
                        <?php }
                        } ?>
                    </select>
                    <span id="status-err" class="warning err"></span>
                </label>
            </div>
        <?php } ?>



        <hr>
        <div class="form-action">


            <button type="reset" id="reset-btn" onclick="return confirm('Are you sue? This action can not revert. Complete??')">Reset</button>
            <button type="submit" id="submit-btn">Submit</button>

        </div>

    </form>

</div>
<script>
    <?php if (isset($onSuccess)) { ?>
        window.alert("<?= $onSuccess["storeProduct"] ?>");
    <?php } ?>
</script>