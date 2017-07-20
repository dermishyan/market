<?php
include"header.php";

include "admin/filter.php";


$res_cat = mysqli_query($connect,"select * from categories ");

$res_slider = mysqli_query($connect,"select img_name from slider ");

$res_user_voice = mysqli_query($connect,"select * from users where voice_id != 0");
$num_users_voice = mysqli_num_rows($res_user_voice);
?>
<div class="container" style="margin-bottom:50px; ;">
    <div class="col-xs-4 col-xs-offset-4" style="text-align:center ;">
        <div class='alert alert-danger error_login_vote display_none'>
            <strong>Error!</strong> please login your account!
        </div>
        <?php
        $res_voices = mysqli_query($connect,"select * from voices");

        while($fetch_voices = mysqli_fetch_assoc($res_voices)){
            $num_voice = $fetch_voices["num_voice"];
            $procent = $num_voice * 100 / $num_users_voice ;


            ?>
            <div class="col-xs-12">
                <div class="col-xs-4"><?php echo $fetch_voices["pr_name"]?> </div>
                <div class="col-xs-4"> <input type="radio" class="vote" name="vote" data-id="<?php echo $fetch_voices["id"]?> "></div>
                <div class="col-xs-4">
                    <div class="progress">
                        <div class="progress-bar prog" data-num="<?php echo $fetch_voices["id"]?>" role="progressbar" aria-valuenow="<?php echo $procent?>" aria-valuemin="0" aria-valuemax="100" style="width: <?php echo $procent?>%;">

                        </div>
                    </div>
                </div>
            </div>
        <?php
        }
        ?>
        <button class="btn btn-default button-vote"> VOTE</button>

    </div>
</div>
<div class="container">
    <div id="carousel-example-generic" class="carousel slide" data-ride="carousel">
<!--        <!-- Indicators -->
        <ol class="carousel-indicators">
            <li data-target="#carousel-example-generic" data-slide-to="0" class="active"></li>
        <?php
        while($fetch_slider = mysqli_fetch_assoc($res_slider)){
        ?>
            <li data-target="#carousel-example-generic" data-slide-to="1"><?php $fetch_slider['img_name'] ?></li>


        <?php }
        mysqli_data_seek($res_slider,0);
        $fetch_slider = mysqli_fetch_assoc($res_slider);
        ?>

        </ol>

        <!-- Wrapper for slides -->
        <div class="carousel-inner" role="listbox">
            <div class="item active">
                <img src="uploads/slider/<?php  echo $fetch_slider['img_name'] ?>" alt="..." style="height:150px;margin:0 auto;">
                <div class="carousel-caption">
                    ...
                </div>
            </div>
            <?php

            while($fetch_slider = mysqli_fetch_assoc($res_slider)){

                ?>
            <div class="item ">
                <img src="uploads/slider/<?php echo $fetch_slider['img_name'] ?>" alt="..." style="height:150px;margin:0 auto;">
                <div class="carousel-caption">
                    ...
                </div>
            </div>
            <?php } ?>



            <!-- Controls -->
            <a class="left carousel-control" href="#carousel-example-generic" role="button" data-slide="prev">
                <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
                <span class="sr-only">Previous</span>
            </a>
            <a class="right carousel-control" href="#carousel-example-generic" role="button" data-slide="next">
                <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
                <span class="sr-only">Next</span>
            </a>
        </div>
    </div>
</div>

<div class="container" style="padding-top:30px;">
<?php

while($fetch_cat = mysqli_fetch_assoc($res_cat)){
    $cat_name = $fetch_cat["eng_name"];
    $cat_id = $fetch_cat["id"];

    ?>

        <div class="row" style="margin-bottom: 10px">
            <div class="panel panel-default">
                <div class="panel-heading" style='text-align: center'>
                    <h2>
                        <a href="category.php?cat_id=<?php echo $cat_id?>&page=1">
                        <?php echo $cat_name?>
                        </a>
                    </h2>
                </div>
                <div class="panel-body">
                    <?php
                    $res_pr = mysqli_query($connect,"select * from products where category_id = ".$fetch_cat['id'] ."  order by id desc limit 3");

                    while( $fetch_pr = mysqli_fetch_assoc($res_pr)){

                        echo "<div class='col-xs-4' style='text-align: center;border:2px solid darkred;padding:10px;'>
                                <a href='product.php?pr_id=$fetch_pr[id]'>
                                    <div>  <span>$fetch_pr[pr_eng_name]</span></div>
                                    <div>  <img src='uploads/$fetch_cat[eng_name]/$fetch_pr[pr_eng_name]/$fetch_pr[pr_img]' width='70px' height='50px'></div>
                                </a>
                              </div>";

                       }
                    ?>
                </div>
            </div>
        </div>


<?php

}

?>

</div>

<?php

include"footer.php";
?>

