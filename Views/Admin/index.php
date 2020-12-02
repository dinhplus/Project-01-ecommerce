<?php $recordsPerPage = 2;
    if(empty($_GET["page"])){
        $_GET["page"] = 1;
    }
?>
<div class="list-staffs">
    <div class="action">
        <div class="filter-staff">
            <form action="#" method="get">
                <input type="text" name="filter" placeholder="Filter Account....">
            </form>
        </div>
        <?php if ($accountLoginned["role_id"] > 4) { ?>
            <div class="generate-account">
                <form action="/dashboard/admin-manager/create-admin">
                    <input type="submit" name="submit" id="create-account-btn" value="Create new account">
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
                    Display Name
                </th>
                <th>
                    Username
                </th>
                <th>
                    Role
                </th>
                <th>
                    Action
                </th>
            </tr>


        <?php
        if (isset($records) && count($records) > 0) {
            $paginate = '';
            $pageQtt = count($records) % $recordsPerPage == 0
                ? (int) count($records) / $recordsPerPage
                : (int) (count($records) / $recordsPerPage) +1;
            for ($page = 1; $page <= $pageQtt ; $page++) {
                $paginate .= '<a href=http://'.HOST.'/dashboard/admin-manager/index?page='.$page.' class = "paginate">page'. $page .'</a>';
                if ($_GET["page"] == $page) {
                    $lastIndex =  $page == $pageQtt ? count($records) : $page * $recordsPerPage;
                    for ($index = ($page - 1) * $recordsPerPage; $index < $lastIndex; $index++) {
        ?>
            <tr>
                <td><?=$records[$index]["id"]?></td>
                <td><?=$records[$index]["name"]?></td>
                <td><?=$records[$index]["username"]?></td>
                <td><?=$records[$index]["label"]?></td>
                <td>
                    <?php if($accountLoginned["role_id"] > 4){?>
                        <form action="/dashboard/admin-manager/delete-staff" method="post">
                        <input type="hidden" value="<?=$records[$index]["id"]?>" name="staff-id">
                        <input type="submit" value="Delete Staff" onclick="window.confirm('Are you sure? Deletion cannot be recovered!')">
                    </form>
                    <?php }?>
                    <?php ?>
                    <a href='<?php echo("/dashboard/admin-manager/edit-staff?uid=".$records[$index]["id"])?>'>
                        <button>
                            Edit staff
                        </button>
                    </a>
                    <!-- <form action="/dashboard/admin-manager/edit-staff?uid=<?=$records[$index]["id"]?>" method="GET">
                        <input type="submit" value="Edit Staff">
                    </form> -->

                    <?php ?>
                </td>
            </tr>
        </table>
        <?php
                    }
                }
            }
            echo ($paginate);
        }
        ?>
    </div>


</div>