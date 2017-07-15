<?php
include "connect.php";

include "header.php";
include "filter.php";
$error = "";
$warning = "";

$cat_id = $_GET['cat_id'];
$cat_eng_name = $_GET['cat_eng_name'];
$pr_id = $_GET["pr_id"];

$res_for_get = mysqli_query($connect,"select * from categories where id ="."$cat_id"." and eng_name ="."'$cat_eng_name'");
$num_for_get = mysqli_num_rows($res_for_get);
if($num_for_get == 0){
    header("location:products.php");
}

$res_for_gets = mysqli_query($connect,"select * from products where id ="."$pr_id"." and category_id = "."$cat_id");
$num_for_gets = mysqli_num_rows($res_for_gets);
if($num_for_gets == 0){
    header("location:products.php");
}

$pr_res = mysqli_query($connect,"select * from products where  id = "."$pr_id");
$pr_fetch = mysqli_fetch_assoc($pr_res);

foreach($pr_fetch as $k => $v){
    $$k = $pr_fetch[$k];
}

////////////////////////////////////////             UPDATE PRODUCT       //////////////////////////////////////////////////
if(isset($_POST["pr_update"])) {
    $number = (array)$_POST;
    $toggle = true;

    foreach ($number as $k => $v) {
        $$k = $number[$k];

        if ($_POST[$k] == "") {
            $warning = $warning . " " . $k;
            $error = " <div class='alert alert-danger'>
                           <strong>error!</strong>please fell all fields (" . $warning . ")!!!!!
                         </div>";
            $toggle = false;

        }
    }
        $pr_res_up = mysqli_query($connect, "select * from products where (pr_eng_name = " . "'$up_pr_eng_name'" . " or pr_arm_name = " . "'$up_pr_arm_name'" . ") and id <> " . "$pr_id");
        $pr_num_up = mysqli_num_rows($pr_res_up);

        if ($pr_num_up == 1) {
            $error = "     <div class='alert alert-danger'>
                             <strong>error!</strong>please change names!!!!!
                         </div>";
            $toggle = false;
        }

        if ($toggle == true) {
            mysqli_query($connect, "UPDATE products SET pr_eng_name = " . "'$up_pr_eng_name'" . ",pr_arm_name = " . "'$up_pr_arm_name'" . ",pr_quantity = " . "$up_pr_quantity" . ",pr_price = " . "$up_pr_price" . ",pr_saled_price = " . "$up_pr_saled_price" . ",pr_description = " . "'$up_pr_description'" . "WHERE id = " . "$pr_id");
            $old_file_name = "../uploads/$cat_eng_name/$pr_eng_name";
            $new_file_name = "../uploads/$cat_eng_name/$up_pr_eng_name";

            rename($old_file_name, $new_file_name);
            $error = "<div class='alert alert-success'>
                       <strong>Success!</strong> product updated !!!!!
                     </div>";
        }
//////////////////////////////////////////        update avatar image             /////////////////////////////////////////////////////////

        $pr_img = $_FILES["filesToUpload"]["name"];
        if ($pr_img != "") {
            $my_array = upload_img($pr_img, $toggle, $up_pr_eng_name, $cat_eng_name, $error);
            if ($my_array[3] == true) {

                mysqli_query($connect, "UPDATE products SET pr_img =" . "'$my_array[1]'" . "WHERE id = " . $pr_id);

            }
        }

////////////////////////////////////////            / UPDATE PRODUCT       //////////////////////////////////////////////////

}
///////////////////////////////////////          MULTI UPLOAD         ///////////////////////////////////////////////////////
    if (isset($_POST["upload_img"])) {

        $toggle = true;
        $names = $_FILES["filesToUpload"]["name"];
        $names_length = count($names);

        $my_array = upload_img($names, $toggle, $pr_eng_name, $cat_eng_name, $error);

        if ($toggle == true) {
            for ($i = 0; $i < $names_length; $i++) {
                $img_only_name = $names[$i];
                mysqli_query($connect, "insert into images ( cat_id,pr_id,img_name) values('$cat_id','$pr_id','$img_only_name')");

            }
        }
    }
///////////////////////////////////////         / MULTI UPLOAD         ///////////////////////////////////////////////////////

$pr_res = mysqli_query($connect, "select * from products where  id = " . "$pr_id");
$pr_num = mysqli_fetch_assoc($pr_res);
foreach($pr_num as $k => $v){
    $$k = $pr_num[$k];
}





?>
    <div class="container">
        <div class="row">
            <div class="col_lg_2 col_lg_offset_1">
                <a href="products.php?cat_id=<?php echo$cat_id?>&cat_eng_name=<?php echo$cat_eng_name?>">
                    <button type="button" class="btn btn-primary " >
                        <span> Back to Products</span>
                    </button>
                </a>
            </div>
            <div class="col-lg-6 col-lg-offset-3 col-xs-8 col-xs-offset-2">
                <div style="text-align: center">
                    <?php echo  "<img src='../uploads/$cat_eng_name/$pr_eng_name/$pr_img' style='width:50px;height: 50px;'>"?>

                </div>
                <form action="" method="post" enctype="multipart/form-data">
                    <div class="form-group">
                        <input type="file" name="filesToUpload">
                    </div>

                    <div class="form-group">
                        <label for="edit_pr_eng_name">Eng Name</label>
                        <input type="text" class="form-control edit_pr_eng_name" name="up_pr_eng_name" id="edit_pr_eng_name" value="<?php echo $pr_eng_name;?>">
                    </div>
                    <div class="form-group">
                        <label for="edit_pr_arm_name">Arm Name</label>
                        <input type="text" class="form-control edit_pr_arm_name" name="up_pr_arm_name" id="edit_pr_arm_name" value="<?php echo $pr_arm_name;?>">
                    </div>
                    <div class="form-group">
                        <label for="edit_pr_quantity">Quantity</label>
                        <input type="number" class="form-control edit_pr_quantity" name="up_pr_quantity" id="edit_pr_quantity" value="<?php echo $pr_quantity;?>">
                    </div>

                    <div class="form-group">
                        <label for="edit_pr_price">Price</label>
                        <input type="number" class="form-control edit_pr_price" name="up_pr_price" id="edit_pr_price" value="<?php echo $pr_price;?>">
                    </div>
                    <div class="form-group">
                        <label for="edit_pr_saled_price">Saled Price</label>
                        <input type="number" class="form-control edit_pr_saled_price" name="up_pr_saled_price" id="edit_pr_saled_price" value="<?php echo $pr_saled_price;?>">
                    </div>
                    <div class="form-group">
                        <label for="edit_pr_description">Description</label>
                        <input type="text" class="form-control edit_pr_description" name="up_pr_description" id="edit_pr_description" value="<?php echo $pr_description;?>">
                    </div>

                    <button type="submit" name="pr_update" class="btn btn-default" value="pr_update">Update Product</button>

                </form>

                <?php
                echo $error;

                ?>
            </div>
        </div>

        <div class="row">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <form action="" method="post" enctype="multipart/form-data">

                        <input type="file" name="filesToUpload[]" id="fileToUpload" multiple>
                        <input type="submit" value="Upload Images" name="upload_img">
                    </form>
                </div>
                <div class="panel-body">
                    <div class='row'>
                    <?php
                    $res_for_img = mysqli_query($connect,"select * from images where pr_id = $pr_id");
                    $num_for_btn = mysqli_num_rows($res_for_img);
                    while($array_for_img = mysqli_fetch_assoc($res_for_img)){
//
                            echo " <div class='col-xs-2 imgs' data-id='$array_for_img[id]'>
                                          <div style='text-align: center;'> <img src='../uploads/$cat_eng_name/$pr_eng_name/$array_for_img[img_name]' style='width:100px;height:100px;'></div>
                                          <div style='text-align: center;'> <input type='checkbox' class='imgcheck' data-id="."$array_for_img[id]"."></div>
                                      </div> ";
//
                    }
                    ?>
                    </div>
                    <?php
                    if($num_for_btn != 0){
                    echo  " <div class='row' style='margin-top:20px; text-align:center;'>
                           <button type='button' class='btn btn-primary btn-lg btn-remove' data-name='image' data-id='$pr_id' data-toggle='modal' data-target='#myModal-2'>
                                DELETE
                           </button>
                       </div>";
                    }

                    if (isset($_POST["upload_img"])) {
                        echo $my_array[2];
                    }

                    ?>

                </div>
            </div>

         </div>
    </div>

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
                <button type="button" class="btn btn-primary  remove" data-name="image" data-id="<?php echo $pr_id ;?>" data-dismiss="modal">Remove </button>
            </div>

        </div>
    </div>
</div>


<?php
include "footer.php";
?>