<?php
session_start();
include "admin/connect.php";
include "admin/filter.php";
if(!isset($_SESSION["user_id"])){
    echo "no";
}
else{

    $user_id = $_SESSION["user_id"];
    $pr_id = filter($_POST["pr_id"],$connect);
    $comment = filter($_POST["comment"],$connect);


    if($comment != ""){
        mysqli_query($connect,"INSERT INTO comments(user_id, pr_id, comment,yes_or_no,seen) VALUES ($user_id,$pr_id,'$comment','dismiss','no')");
        echo "yes";
    }
    else{
        echo "empty";
    }


}



?>