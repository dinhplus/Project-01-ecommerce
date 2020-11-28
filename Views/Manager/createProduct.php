<div id="create-product-form">

    <form action="/manager/store-product" method="post" enctype="multipart/form-data">

        <h1 align="center">
            Insert new product into product list
        </h1>
        <hr>
        <label for="">
            Product Name
            <input type="text" name="name" class="name" id="name" placeholder="Product's Name...">
            <span id="name-err" class="warning err"></span>
        </label>

        <label for="">
            Description
            <textarea type="text" name="description" class="description" id="description" placeholder="Product's description..."> </textarea>
            <span id="description-err" class="warning err"></span>
        </label>

        <label for="">
            Price
            <input type="number" name="price" class="price" id="price" placeholder="Product's price...">
            <span id="price-err" class="warning err"></span>
        </label>

        <label for="">
            Upload image
            <input type="file" name="img_ref" class="img_ref" id="img_ref" >
            <span id="name-err" class="warning err"><?php if(isset($message) && isset($message["image"])){print_r($message["image"]);}?></span>
        </label>

        <label for="">
            Quantity
            <input type="text" name="quantity" class="quantity" id="quantity" placeholder="Quantity...">
            <span id="quantity-err" class="warning err"></span>
        </label>
        <hr>
        <div class="form-action" >

            <input type="reset" id="reset" name="reset" value="reset">
            <input type="submit" id="submit" name="submit" value="Submit">
        </div>

    </form>

</div>
<script>
    <?php if(isset($onSuccess)){ ?>
    window.alert("<?=$onSuccess["storeProduct"]?>");
    <?php }?>
</script>