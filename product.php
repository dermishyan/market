<?php
include "header.php";

$pr_id = $_GET["pr_id"];
$res_pr = mysqli_query($connect,"select * from products where id = $pr_id");
$num_pr = mysqli_num_rows($res_pr);
if($num_pr == 0){
    header("location:index.php");
}
$fetch_pr = mysqli_fetch_assoc($res_pr);
foreach($fetch_pr as $k => $v){
    $$k = $fetch_pr["$k"];
}
if(isset($_SESSION["user_id"])){
    $user_id = $_SESSION["user_id"];

}
else{
    $user_id = "";
}

$res_cat = mysqli_query($connect,"select * from categories where id = $category_id");
$fetch_cat = mysqli_fetch_assoc($res_cat);
$cat_eng_name = $fetch_cat["eng_name"];


$res_likes = mysqli_query($connect,"select likes_count from likes where pr_id = ".$pr_id ." order by id desc limit 1");
$num_likes = mysqli_num_rows($res_likes);
if($num_likes == 0){
    $number = 0;
}
else{
    $fetch_likes = mysqli_fetch_assoc($res_likes);
    $number = $fetch_likes["likes_count"];
}

$res_likes_color = mysqli_query($connect,"select * from likes where pr_id = ".$pr_id." and user_id = "."'$user_id'" );
if(mysqli_num_rows($res_likes_color) == 0){
    $num_for_color = 5;
}
else{
    $fetch_like_color = mysqli_fetch_assoc($res_likes_color);
    $num_for_color = $fetch_like_color["like_dislike"];
}




?>


<div class="container">
    <div class="col-xs-4 col-xs-offset-4" >
        <div style="margin-bottom: 10px;"> <img src="uploads/<?php echo $cat_eng_name;?>/<?php echo $pr_eng_name;?>/<?php echo $pr_img;?>" width="150px" height="150px"></div>
        <div class="col-xs-12" style="margin-bottom: 20px;margin-left: 20px;">
            <button class="btn btn-default like" style="background:<?php if($num_for_color == 1){echo "#34f2e6";}else{echo "#fff";};?>" data-main="like" data-userid="<?php echo $user_id ;?>" data-prid="<?php echo $id ;?>"><span class="glyphicon glyphicon-thumbs-up"></span> </button>
            <button class="btn btn-default  dislike" style="background:<?php if($num_for_color == 0){echo "#34f2e6";}else{echo "#fff";};?>" data-main="dislike" data-userid="<?php echo $user_id ;?>" data-prid="<?php echo $id ;?>"><span class="glyphicon glyphicon-thumbs-down"></span> </button>
            <span class="number"><?php echo $number ?></span>
        </div>

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

