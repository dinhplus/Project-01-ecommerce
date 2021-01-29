<?php
if (empty($_GET["page"])) {
    $_GET["page"] = 1;
}
?>
<div class="list-brands" style="width: 100%;">
    <h3>List Brand</h3>
    <br>
    <?php if ($_SESSION["role"] > 3) { ?>
    <div class="add-new">
        <form action="/dashboard/product-manager/add-brand" method="POST" class="row">
            <input type="text" name="brand" id="add-brand" placeholder="New Brand ..." class="form-control" style="width: 40%;">
            <input type="submit" onclick="return addBrandCheck()" value="Add new Brand" class="btn btn-info btn-block btn-round" class="form-control" style="width: 40%;"> <br>
            <span id="add-brand-err" class="warning"></span>
        </form>
    </div>
    <?php } ?>
    <hr>
    <table class="table table-striped table-dark" style="width: 100%;">
        <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">Brand name</th>
                <th scope="col"> Action</th>
            </tr>
        </thead>
        <tbody>
            <?php if ($brands) {
                foreach ($brands as $brand) {
                    extract($brand);
            ?>
                    <tr>
                        <td scope="row">
                            <?= $id ?>
                        </td>
                        <td>
                            <?= $name ?>
                        </td>
                        <td>
                            <!-- <div class="delete" id="<?" delete".$id?>">
                                <button>
                                    Delete Brand
                                </button>
                                <div class="delete-submit">
                                    <form action="/dashboard/product-manager/delete-brand" method="post">
                                        <input type="hidden" name="brand_id" id="<?= "brand-" . $id ?>">
                                        <button>Yes! I readly wan to Delete it!</button>
                                    </form>
                                    <button onclick="return cancelDeleteBrand()">
                                        No! I am not sure!
                                    </button>
                                    <button>

                                    </button>
                                </div>
                            </div> -->
                            <div class="edit" id="<?= "edit" . $id ?>">
                            <?php if ($_SESSION["role"] > 3) { ?>
                                <button onclick="showEditBrand(<?= $id ?>)"  class="btn btn-warning btn-block btn-round">
                                    Edit Brand
                                </button>
                                <div class="edit-brand-form" id="<?= 'edit-brand-' . $id ?>" style="display: none;">
                                    <form action="/dashboard/product-manager/update-brand" method="post" id="<?= 'form-edit-brand-' . $id ?>">
                                        <input type="hidden" name="brand_id" value="<?= $id ?>">
                                        <input type="text" name="brand" id="<?= "brand-" . $id ?>" value="<?= $name ?>" placeholder="Brand label..." class="form-control">
                                        <br>
                                        <span class="warning" id="brand-err-<?= $id ?>"></span> <br>
                                        <input type="submit" onclick="return editBrandCheck(<?= $id ?>)" class="btn btn-info btn-block btn-round" class="form-control" style="width: 49%;">
                                        <button onclick="cancelEditBrand(<?= $id ?>)" type="reset"  class="btn btn-danger btn-block btn-round" class="form-control" style="width: 49%;"> Cancel</button>
                                    </form>
                                </div>
                                <?php } ?>
                            </div>
                        </td>
                    </tr>
            <?php  }
            }  ?>

        </tbody>
    </table>
</div>