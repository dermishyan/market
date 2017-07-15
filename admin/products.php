<?php
include "connect.php";

include "header.php";
include "filter.php";

$error = "";
$cat_id = $_GET['cat_id'];
$cat_eng_name = $_GET['cat_eng_name'];
///////////////////////////////////////      chech for get      /////////////////////////////////////
$res_for_get = mysqli_query($connect,"select * from categories where id ="."$cat_id"." and eng_name ="."'$cat_eng_name'");
$num_for_get = mysqli_num_rows($res_for_get);
if($num_for_get == 0){
    header("location:admin.php");
}

//             //////////////////////  product form controler and add /////////////////////////////////////////


if(isset($_POST['pr_add'])){
    $num = (array)$_POST;
    $toggle = true;

    foreach($num as $k => $v){

        $$k = $_POST[$k] ;

        if($_POST[$k] == ""){
            $error = " <div class='alert alert-danger'>
                               <strong>error!</strong>please fell all fields !!!!!
                             </div>";
            $toggle = false;
        }
    }
    $pr_res = mysqli_query($connect,"select * from products where pr_eng_name ="."'$pr_eng_name'"." or pr_arm_name ="."'$pr_arm_name'");
    $pr_num = mysqli_num_rows($pr_res);

        if($pr_num == 1){
            $error = "     <div class='alert alert-danger'>
                               <strong>error!</strong>please change names!!!!!
                           </div>";
            $toggle = false;
        }


    $pr_img = $_FILES["filesToUpload"]["name"];
    $my_array = upload_img($pr_img,$toggle,$pr_eng_name,$cat_eng_name,$error);

    if ($toggle == true) {

        mysqli_query($connect,"insert into products (category_id,pr_eng_name, pr_arm_name, pr_quantity, pr_price, pr_saled_price, pr_description,pr_img ) VALUES ($cat_id,'$pr_eng_name','$pr_arm_name',$pr_quantity,$pr_price,$pr_saled_price,'$pr_description','$my_array[1]')");
    }
}

$res_tbl = mysqli_query($connect, "select * from products where category_id = $cat_id");

//      //////////////////////          / product form controler and add    /////////////////////////////////////////////
?>
<div class="container">
    <div class="col_lg_2 col_lg_offset_1">
        <a href="admin.php">
            <button type="button" class="btn btn-primary " >
                <span> Back to Categories</span>
            </button>
        </a>
    </div>
    <div class="col-lg-6 col-lg-offset-3 col-xs-8 col-xs-offset-2">
        <form action="" method="post" enctype="multipart/form-data">
            <div class="form-group">
                <label for="pr_eng_name">Eng Name</label>
                <input type="text" class="form-control" name="pr_eng_name" id="pr_eng_name">
            </div>
            <div class="form-group">
                <label for="pr_arm_name">Arm Name</label>
                <input type="text" class="form-control" name="pr_arm_name" id="pr_arm_name">
            </div>
            <div class="form-group">
                <label for="pr_quantity">Quantity</label>
                <input type="number" class="form-control" name="pr_quantity" id="pr_quantity">
            </div>

            <div class="form-group">
                <label for="pr_price">Price</label>
                <input type="number" class="form-control" name="pr_price" id="pr_price">
            </div>
            <div class="form-group">
                <label for="pr_saled_price">Saled Price</label>
                <input type="number" class="form-control" name="pr_saled_price" id="pr_saled_price">
            </div>
            <div class="form-group">
                <label for="pr_description">Description</label>
                <input type="text" class="form-control" name="pr_description" id="pr_description">
            </div>
            <div class="form-group">

                <input type="file" name="filesToUpload" id="fileToUpload">
            </div>

            <button type="submit" name="pr_add" class="btn btn-default" value="add" >ADD</button>

        </form>
        <?php if(isset($_POST['pr_add'])){
          echo "$error";
        }

    ?>
    </div>
</div>





<div class="container">
    <h2>Products in category <?php echo "$cat_eng_name"?></h2>

    <table class="table table-bordered">
        <thead>
        <tr>
            <th>Eng Name</th>
            <th>Arm Name</th>
            <th>Quantity</th>
            <th>Price</th>
            <th>Saled Price</th>
            <th>Description</th>
            <th>Picture</th>
            <th>Delete</th>
            <th>Edit</th>
        </tr>
        </thead>
        <tbody>
            <?php while ($pr_tbl_val = mysqli_fetch_assoc($res_tbl)) {
                foreach($pr_tbl_val as $k => $v){
                    $$k = $pr_tbl_val["$k"];
                }
                  $pr_id = $pr_tbl_val["id"];
                ?>
            <tr data-name="products" data-id='<?php echo"$pr_id"?>'>
                <td><?php echo "$pr_eng_name" ?></td>
                <td><?php echo "$pr_arm_name" ?></td>
                <td><?php echo "$pr_quantity" ?></td>
                <td><?php echo "$pr_price" ?></td>
                <td><?php echo "$pr_saled_price" ?></td>
                <td><?php echo "$pr_description" ?></td>
                <td><?php echo "<img src='../uploads/$cat_eng_name/$pr_eng_name/$pr_img' width='40px' height='40px'>"; ?></td>
                <td>
                     <button type="button" class="btn btn-primary btn-lg btn-remove" data-name="products" data-id='<?php echo"$pr_id"?>' data-toggle="modal" data-target="#myModal-2">
                         <span class="glyphicon glyphicon-remove"></span>
                    </button>
                </td>
                <td>
                    <a href="editproduct.php?pr_id=<?php echo $pr_id ?>&cat_id=<?php echo $cat_id ?>&cat_eng_name=<?php echo $cat_eng_name ?>">
                        <button type="button" class="btn btn-primary btn-edit-product" data-id='<?php echo"$pr_id"?>' data-catname='<?php echo"$cat_eng_name"?>' data-catid='<?php echo"$cat_id"?>' >
                            <span class="glyphicon glyphicon-pencil"></span>
                        </button>
                    </a>
                </td>

            </tr>
            <?php }?>
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
                <button type="button" class="btn btn-primary  remove" data-name="products" data-id="<?php echo $pr_id ;?>" data-dismiss="modal">Remove </button>
            </div>

        </div>
    </div>
</div>





<?php
include "footer.php"
?>