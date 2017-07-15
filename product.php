<?php
include "header.php";

$pr_id = $_GET["pr_id"];
$res_pr = mysqli_query($connect,"select * from products where id = $pr_id");
$fetch_pr = mysqli_fetch_assoc($res_pr);
foreach($fetch_pr as $k => $v){
    $$k = $fetch_pr["$k"];
}
$num_pr = mysqli_num_rows($res_pr);
if($num_pr == 0){
    header("location:index.php");
}

$res_cat = mysqli_query($connect,"select * from categories where id = $category_id");
$fetch_cat = mysqli_fetch_assoc($res_cat);
$cat_eng_name = $fetch_cat["eng_name"];

?>


<div class="container">
    <div class="col-xs-4 col-xs-offset-4" >
        <div style="margin-bottom: 30px;"> <img src="uploads/<?php echo $cat_eng_name;?>/<?php echo $pr_eng_name;?>/<?php echo $pr_img;?>" width="150px" height="150px"></div>
        <div><span>Product Name :  </span><span><?php echo $pr_eng_name;?></span></div>
        <div><span>Quantity :      </span><span><?php echo $pr_quantity;?></span></div>
        <div><span>Price :         </span><span><?php echo $pr_price;?></span></div>
        <div><span>Saled Price :   </span><span><?php echo $pr_saled_price;?></span></div>
        <div><span>Description :   </span><span><?php echo $pr_description . "...";?></span></div>
        <div>
            <div><textarea class="comment" rows="4" cols="35"></textarea></div>
            <div class='alert alert-danger error_login display_none'>
                <strong>Error!</strong> please login your account!
            </div>
            <div class='alert alert-danger error_write display_none'>
                <strong>Error!</strong> please write comment !
            </div>
            <div class='alert alert-success comment_success display_none'>
                <strong>Success!</strong> Our admin will see your comment  !
            </div>
            <div> <button class="btn btn-default add_comment" data-id="<?php echo $id;?>" > ADD Comment</button></div>

            <?php
            $res_comment = mysqli_query($connect,"select * from comments where pr_id = ".$pr_id." and yes_or_no = 'let on'");
            if(mysqli_num_rows($res_comment) != 0){
                echo  "<div class='col-xs-10' style='border:1px solid #ccc;'>" ;
            }

            while( $fetch_comments = mysqli_fetch_assoc($res_comment)){
                $comment = $fetch_comments["comment"];
                $user_id = $fetch_comments["user_id"];
                $res_users = mysqli_query($connect,"select username from users where id = ".$user_id);
                $fetch_users = mysqli_fetch_assoc($res_users);
                $username = $fetch_users["username"];

                echo "<div>
                          <span> $username : </span>
                          <span>$comment </span>
                      </div>";

            }

            if(mysqli_num_rows($res_comment) != 0){
                echo  "</div>" ;
            }
            ?>




            </div>
        </div>
    </div>
</div>

<?php

include"footer.php";
?>

