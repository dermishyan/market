<?php
include "header.php";
$error = "";
if(isset($_SESSION["user_id"])){
    header("location:index.php");
}
if(isset($_POST["registration"])){
    $reg_username = $_POST["reg_username"];
    $reg_password = $_POST["reg_password"];

    $res_users = mysqli_query($connect,"select * from users where username = "."'$reg_username'");
    if(mysqli_num_rows($res_users) == 1){
        $error = "<div class='alert alert-danger'>
                    <strong>Error!</strong> please change username !!
                  </div>";
    }
    elseif($reg_username == "" || $reg_password == ""){
        $error = "<div class='alert alert-danger'>
                    <strong>Error!</strong> please feel all fields  !!
                  </div>";
    }
    else{
        mysqli_query($connect,"INSERT INTO users(username, password) VALUES ('$reg_username','$reg_password')");
        $error = "<div class='alert alert-success'>
                    <strong>Success</strong> You are registered!!!
                  </div>";
    }
}

?>
<div class="col-xs-4 col-xs-offset-4">
    <form action="" method="post" style="padding:30px 30px 0 30px;">
        <h2 class="modal-title" id="myModalLabel">Registration</h2>
        <div class="form-group">
            <label for="username">Username:</label>
            <input type="text" class="form-control" id="username" name="reg_username">
        </div>
        <div class="form-group">
            <label for="password">Password:</label>
            <input type="password" class="form-control" id="password" name="reg_password">
        </div>
        <?php echo $error;?>
        <div class="modal-footer">

            <button type="submit" class="btn btn-primary  " name="registration">Registration </button>
        </div>

    </form>
</div>
<?php

include"footer.php";
?>