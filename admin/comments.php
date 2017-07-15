<?php
include "header.php";
$res_comments_seen = mysqli_query($connect,"select * from comments where seen = 'yes' order by id desc");
$res_comments_not_seen = mysqli_query($connect,"select * from comments where seen = 'no' order by id desc");

?>

<div class="container">
    <table class="table table-bordered">
        <thead>
        <tr>
            <th>Username</th>
            <th>Product Name</th>
            <th>Comment</th>
            <th>Delete</th>
            <th>YES or NO</th>
        </tr>
        </thead>
        <tbody>
<?php
while($fetch_comments_not_seen = mysqli_fetch_assoc($res_comments_not_seen)){
    foreach($fetch_comments_not_seen as $k => $v){
        $$k = $fetch_comments_not_seen["$k"];
    }
    $res_product = mysqli_query($connect,"select * from products where id = ".$pr_id);
    $fetch_product = mysqli_fetch_assoc($res_product);
    $pr_name = $fetch_product["pr_eng_name"];


    $res_users = mysqli_query($connect,"select * from users where id = ".$user_id);
    $fetch_users= mysqli_fetch_assoc($res_users);
    $user_name = $fetch_users["username"];

    ?>
    <tr data-name="comment" data-id='<?php echo"$id"?>' style="background:lightblue;">
        <td style="color:red;"><?php echo "$user_name" ?></td>
        <td style="color:red;"><?php echo "$pr_name" ?></td>
        <td style="color:red;"><?php echo "$comment" ?></td>

        <td>
            <button type="button" class="btn btn-primary btn-lg btn-remove" data-name="comment" data-id='<?php echo"$id"?>' data-toggle="modal" data-target="#myModal-2">
                <span class="glyphicon glyphicon-remove"></span>
            </button>
        </td>
        <td>
            <button type="button" class="btn btn-primary let_on" data-name="comment" data-id='<?php echo"$id"?>'><?php if($yes_or_no == 'dismiss'){echo "let on";}elseif($yes_or_no == 'let on'){echo "dismiss";}?></button>
        </td>

    </tr>


    <?php
}

?>
<?php
while($fetch_comments_seen = mysqli_fetch_assoc($res_comments_seen)){
    foreach($fetch_comments_seen as $k => $v){
        $$k = $fetch_comments_seen["$k"];
    }
    $res_product = mysqli_query($connect,"select * from products where id = ".$pr_id);
    $fetch_product = mysqli_fetch_assoc($res_product);
    $pr_name = $fetch_product["pr_eng_name"];


    $res_users = mysqli_query($connect,"select * from users where id = ".$user_id);
    $fetch_users= mysqli_fetch_assoc($res_users);
    $user_name = $fetch_users["username"];

?>
    <tr data-name="comment" data-id='<?php echo"$id"?>'>
        <td><?php echo "$user_name" ?></td>
        <td><?php echo "$pr_name" ?></td>
        <td><?php echo "$comment" ?></td>

        <td>
            <button type="button" class="btn btn-primary btn-lg btn-remove" data-name="comment" data-id='<?php echo"$id"?>' data-toggle="modal" data-target="#myModal-2">
                <span class="glyphicon glyphicon-remove"></span>
            </button>
        </td>
        <td>
            <button type="button" class="btn btn-primary let_on" data-name="comment" data-id='<?php echo"$id"?>'><?php if($yes_or_no == 'dismiss'){echo "let on";}elseif($yes_or_no == 'let on'){echo "dismiss";}?></button>
        </td>

    </tr>


<?php
}
mysqli_query($connect,"UPDATE comments SET seen = 'yes' WHERE seen = 'no'");
?>
        </tbody>
    </table>
</div>
    <!-- Modal -remove-->
    <div class="modal fade" id="myModal-2" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">Remove</h4>
                </div>
                <div class="alert alert-warning">
                    <strong>Warning!</strong> Are you sure to remove <span class="cont"></span>
                </div>


                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary  remove" data-name="comment" data-id="<?php echo $id ;?>" data-dismiss="modal">Remove </button>
                </div>

            </div>
        </div>
    </div>

<?php
include "footer.php";
?>