<?php
if (empty($_GET["page"])) {
    $_GET["page"] = 1;
}
?>
<div class="list-categories">
    <h3>List Category</h3>
    <br>
    <?php if ($_SESSION["role"] > 3) { ?>

        <div class="add-new">
            <form action="/dashboard/product-manager/add-category" method="POST">
                <input type="text" name="category" id="add-category" placeholder="New Category ...">
                <input type="submit" onclick="return addCategoryCheck()" value="Add new Category" class="btn btn-info btn-block btn-round"> <br>
                <span id="add-category-err" class="warning"></span>
            </form>
        </div>
    <?php } ?>
    <hr>
    <table class="table table-striped table-dark">
        <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">Category Label</th>
                <th scope="col"> Action</th>
            </tr>
        </thead>
        <tbody>
            <?php if ($categories) {
                foreach ($categories as $label) {
                    extract($label);
            ?>
                    <tr>
                        <td scope="row">
                            <?= $id ?>
                        </td>
                        <td>
                            <?= $label ?>
                        </td>
                        <td>
                            <!-- <div class="delete" id="<?" delete".$id?>">
                                <button>
                                    Delete Category
                                </button>
                                <div class="delete-submit">
                                    <form action="/dashboard/product-manager/delete-category" method="post">
                                        <input type="hidden" name="category_id" id="<?= "category-" . $id ?>">
                                        <button>Yes! I readly wan to Delete it!</button>
                                    </form>
                                    <button onclick="return cancelDeleteCategory()">
                                        No! I am not sure!
                                    </button>
                                    <button>

                                    </button>
                                </div>
                            </div> -->
                            <div class="edit" id="<?= "edit" . $id ?>">
                                <?php if ($_SESSION["role"] > 3) { ?>
                                    <button onclick="showEditCategory(<?= $id ?>)" class="btn btn-warning btn-block btn-round">
                                        Edit Category
                                    </button>
                                    <div class="edit-category-form" id="<?= 'edit-ctg-' . $id ?>" style="display: none;">
                                        <form action="/dashboard/product-manager/update-category" method="post" id="<?= 'form-edit-ctg-' . $id ?>">
                                            <input type="hidden" name="category_id" value="<?= $id ?>">
                                            <input type="text" name="category" id="<?= "category-" . $id ?>" value="<?= $label ?>" placeholder="Category label...">
                                            <br>
                                            <span class="warning" id="category-err-<?= $id ?>"></span> <br>
                                            <input type="submit" onclick="return editCategoryCheck(<?= $id ?>)" class="btn btn-info btn-block btn-round">
                                            <button onclick="cancelEditCategory(<?= $id ?>)" type="reset" class="btn btn-danger btn-block btn-round"> Cancel</button>
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