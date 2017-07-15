<?php
require"connect.php";

$comment_id = $_POST["id"] ;
$toggle = $_POST["toggle"];

if($toggle == "let on"){
    mysqli_query($connect,"UPDATE comments SET yes_or_no = 'let on' WHERE id = ".$comment_id);
}
elseif($toggle == "dismiss"){
    mysqli_query($connect,"UPDATE comments SET yes_or_no = 'dismiss' WHERE id = ".$comment_id);
}


if($toggle == "check"){
    $check_res = mysqli_query($connect,"select * from comments where seen = 'no'");
    $num_check = mysqli_num_rows($check_res);
    echo $num_check;
}
