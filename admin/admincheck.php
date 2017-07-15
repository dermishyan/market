<?php
include "connect.php";
session_start();

    if(isset ( $_POST['user'])){
        $user = $_POST['user'];
        $pass = $_POST['pass'];

        $result = mysqli_query($connect,"select * from admins where user = '$user' and password = '$pass'");
        $num = mysqli_num_rows($result);
        $id = mysqli_fetch_assoc($result);

        if($num == 0){
            echo 0;
        }
        else{
            $_SESSION["admin_id"] = $id["id"];
            echo 1;

        }
    }else{
        header('Location: index.php');
    }

?>