<?php
include "header.php";

$cat_id= $_GET['cat_id'];
$page = $_GET['page'];

$seek = ($page - 1) * 3;
$limit = 3;


$res_cat = mysqli_query($connect,"select eng_name from categories where id = "."'$cat_id'");
$num_cat = mysqli_num_rows($res_cat);
$fetch_cat = mysqli_fetch_assoc($res_cat);
$cat_name = $fetch_cat['eng_name'];
if($num_cat == 0){
    header("location:index.php");
}

$res_pr = mysqli_query($connect,"select * from products where category_id = "."'$cat_id'"."limit $seek,$limit");

?>

<div class="container">
    <div class="row">
<?php
while($fetch_pr = mysqli_fetch_assoc($res_pr)) {
    foreach($fetch_pr as $k => $v){
        $$k = $fetch_pr["$k"];
    }

?>
            <div class="col-xs-4" style="text-align: center;border:1px solid #ccc;">
                <a href="product.php?pr_id=<?php echo $id;?>">
                    <div class="col-xs-12"><?php echo $pr_eng_name;?></div>
                    <div class="col-xs-12"><img src="uploads/<?php echo $cat_name;?>/<?php echo $pr_eng_name;?>/<?php echo $pr_img;?>" width="70px" height="70px"></div>
                    <div class="col-xs-12"><?php echo $pr_description."...";?></div>
                </a>
            </div>
<?php
}
$result_pr = mysqli_query($connect,"select * from products where category_id = ".$cat_id);
$num_pr = mysqli_num_rows($result_pr);

$count = ceil($num_pr / 3);


?>

</div>
    <div class="row" style="text-align: center;">
        <div class="pagination ">
            <a href="#">&laquo;</a>
<?php
for($i = 0;$i <= $count;$i++){
    if($i != 0){
?>
    <a href="category.php?cat_id=<?php echo $cat_id?>&page=<?php echo $i ;?>"><?php echo $i ;?></a>
<?php
    }
}
?>
            <a href="#">&raquo;</a>
        </div>
    </div>
</div>

<?php

include"footer.php";
?>

