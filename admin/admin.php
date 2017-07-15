<?php

include "connect.php";
include "header.php";
include "filter.php";
$error = "";
$warning = "";
if (isset($_POST['add'])) {
    $toggle = true;

    $eng_name = $_POST['eng_name'];
    $arm_name = $_POST['arm_name'];

    $eng_name = filter($eng_name,$connect);
    $arm_name = filter($arm_name,$connect);

    $number = (array)$_POST;

    $result = mysqli_query($connect, "select * from categories where eng_name = '$eng_name' or arm_name = '$arm_name'");
    $num = mysqli_num_rows($result);
    foreach ($number as $k => $v) {

        if ($_POST[$k] == "") {
            $warning = $warning . " " . $k;
            $error = " <div class='alert alert-danger'>
                           <strong>error!</strong>please fell all fields (" . $warning . ")!!!!!
                         </div>";
            $toggle = false;
        }
    }
    if ($num == 1) {
        $error = " <div class='alert alert-danger'>
                       <strong>error!</strong>please change Categori!!!!!
                     </div>";
        $toggle = false;
    }
    if($toggle == true){
        mysqli_query($connect, "INSERT INTO categories(eng_name, arm_name) VALUES ('$eng_name','$arm_name')");
        mkdir("../uploads/$eng_name",0777);
    }

}
////////////////////////////////////////////      EDIT UPDATE      /////////////////////////////////////////////////////////////////
if (isset($_POST['edit-update'])) {

    $update_eng_name = $_POST['edit-inp-eng'];
    $update_arm_name = $_POST['edit-inp-arm'];
    $row_id = $_POST['edit-inp-id'];
    $res_for_name = mysqli_query($connect,"select * from categories where  id = "."$row_id");
    $array = mysqli_fetch_assoc($res_for_name);
    $eng_name = $array["eng_name"];

    $res_for_update = mysqli_query($connect,"select * from categories where (eng_name = "."'$update_eng_name'"." or arm_name = "."'$update_arm_name'".") and id <> "."$row_id");

    $num_for_update = mysqli_num_rows($res_for_update);

    if($num_for_update == 0){
        mysqli_query($connect,"UPDATE categories SET eng_name = "."'$update_eng_name'".",arm_name = "."'$update_arm_name'"."WHERE id = "."$row_id") ;
        $old_file_name = "../uploads/$eng_name";
        $new_file_name = "../uploads/$update_eng_name";

        rename($old_file_name,$new_file_name);
    }
    else{
        $error = "<div class='alert alert-danger'>
                       <strong>error!</strong>please change eng-name or arm-name!!!!!
                     </div>";
    }
}
///////////////////////////////////////     Slider images  UPLOAD         ///////////////////////////////////////////////////////
if (isset($_POST["slider_images"])) {

    $toggle = true;
    $names = $_FILES["filesToUpload"]["name"];
    $names_length = count($names);

    for ($i = 0; $i < $names_length; $i++) {

        $exploded_names = explode(".", $names[$i]);
        $formats = end($exploded_names);
        $all_formats = ["jpg", "jpeg", "JPEG", "png", "gif","GIF"];

        if (!in_array($formats, $all_formats)) {
            echo "false images or image format";
            $toggle = false;
        }
    }
    for ($i = 0; $i < $names_length; $i++) {

        $img_only_name = $names[$i];
        $target_files = "../uploads/slider/$img_only_name";

        if (!file_exists("../uploads/slider")) {
            mkdir("../uploads/slider", 0700);
        }
        if ($toggle == true) {
            move_uploaded_file($_FILES["filesToUpload"]["tmp_name"][$i], $target_files);
            mysqli_query($connect, "insert into slider (img_name) values('$img_only_name')");
        }
    }

}
///////////////////////////////////////         / MULTI UPLOAD         ///////////////////////////////////////////////////////

$res_tbl = mysqli_query($connect, "select * from categories");
$res_comments =  mysqli_query($connect, "select * from comments where seen = 'no'");
$num_comments = mysqli_num_rows($res_comments);
?>
<div class="row">

    <div class="col-xs-1 col-xs-offset-1">
        <a href="comments.php">
             <button type="button"  class="btn btn-default" >
                 Comments  <span class="num_comments" <?php if($num_comments != 0){echo "style='color:red;font-size:22px;'";}?> ><?php echo $num_comments ;?></span>
             </button>
        </a>
    </div>
    <div class="col-xs-4 col-xs-offset-2">
        <form method="post" action="">
            <div class="form-group">
                <label for="eng_name">Eng Name</label>
                <input type="text" class="form-control" name="eng_name" id="eng_name">
            </div>
            <div class="form-group">
                <label for="arm_name">Arm Name</label>
                <input type="text" class="form-control" name="arm_name" id="arm_name">
            </div>

            <button type="submit" name="add" class="btn btn-default" value="add">ADD</button>
        </form>

        <?php
        if (isset($_POST['add'])) {
            echo "$error" ;
        }?>
    </div>
</div>

<?php if (isset($_POST['edit-update'])) {
    echo "$error";
}
?>

<div class="container">
    <h2>Categories</h2>

    <table class="table table-bordered">
        <thead>
        <tr>
            <th>Eng Name</th>
            <th>Arm Name</th>
            <th>Edit</th>
            <th>Delete</th>
            <th>Show</th>
        </tr>
        </thead>
        <tbody>
        <?php while ($tbl_val = mysqli_fetch_assoc($res_tbl)) {
            $cat_eng_name = $tbl_val['eng_name'];
            $cat_arm_name = $tbl_val['arm_name'];
            $id = $tbl_val['id'];

            ?>
            <tr class="tbl-tr" data-name="category" data-id='<?php echo"$id"?>'>
                <td><?php echo "$cat_eng_name" ?></td>
                <td><?php echo "$cat_arm_name" ?></td>
                <td>
                    <button type="button" class="btn btn-primary btn-lg btn-edit" data-id='<?php echo"$id"?>' data-toggle="modal" data-target="#myModal-1">
                        <span class="glyphicon glyphicon-pencil"></span>
                    </button>
                </td>
                <td>
                    <button type="button" class="btn btn-primary btn-lg btn-remove" data-name="category" data-id='<?php echo"$id"?>' data-toggle="modal" data-target="#myModal-2">
                        <span class="glyphicon glyphicon-remove"></span>
                    </button>
                </td>
                <td>
                    <a href="products.php?cat_eng_name=<?php echo $cat_eng_name?>&cat_id=<?php echo $id?>">
                        <button type="button" class="btn btn-primary btn-lg btn-show" data-id='<?php echo"$id"?>' >
                            <span class="glyphicon glyphicon-eye-open"></span>
                        </button>
                    </a>
                </td>
            </tr>
        <?php   } ?>
        </tbody>
    </table>
</div>
<!--///////////////////////////////////    slider images     ////////////////////////////////////////////////////////////-->
<div class="row">
    <div class="panel panel-default">
        <div class="panel-heading">
            <h2 style="text-align: center">SLIDER IMAGES</h2>
            <form action="" method="post" enctype="multipart/form-data">

                <input type="file" name="filesToUpload[]" id="fileToUpload" multiple>
                <input type="submit" value="ADD SLIDER IMAGES" name="slider_images">
            </form>
        </div>
        <div class="panel-body">
            <div class='row'>
                <?php
                $res_for_slider = mysqli_query($connect,"select * from slider");

                $num_for_btn = mysqli_num_rows($res_for_slider);
                while($array_for_img = mysqli_fetch_assoc($res_for_slider)){
//
                    echo " <div class='col-xs-2 slider_imgs' data-id='$array_for_img[id]'>
                              <div style='text-align: center;'> <img src='../uploads/slider/$array_for_img[img_name]' style='width:100px;height:100px;'></div>
                              <div style='text-align: center;'> <input type='checkbox' class='imgcheck' data-id="."$array_for_img[id]"."></div>
                          </div> ";
                } ?>
            </div>
            <?php
            if($num_for_btn != 0){
                echo  " <div class='row' style='margin-top:20px; text-align:center;'>
                           <button type='button' class='btn btn-primary btn-lg btn-remove' data-name='slider_image' data-toggle='modal' data-target='#myModal-2'>
                                DELETE
                           </button>
                       </div>";
            } ?>
        </div>
    </div>

</div>


<!-- Modal -editt-->
<div class="modal fade" id="myModal-1" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Edit</h4>
            </div>
            <form action="" method="post">
                <div class="modal-body">
                    <label for="edit-arm-name">Eng Name</label>
                    <input type="text" class="edit-inp-eng" name="edit-inp-eng" id="edit-arm-name"/>

                    <label for="edit-eng-name">Arm Name</label>
                    <input type="text" class="edit-inp-arm" name="edit-inp-arm"  id="edit-eng-name"/>

                    <input type="hidden" class="hidden-inp" name="edit-inp-id"  value="<?php echo"";?>"/>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary edit-update" name="edit-update">Update Values</button>
                </div>
            </form>
        </div>
    </div>
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
                <button type="button" class="btn btn-primary  remove" data-name="category" data-id="<?php echo $id ;?>" data-dismiss="modal">Remove </button>
            </div>

        </div>
    </div>
</div>




<?php
include "footer.php"
?>
