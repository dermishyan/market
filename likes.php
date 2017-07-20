<?php
include "admin/connect.php";
$pr_id = $_POST["id"];
$user_id = $_POST["user_id"];
$main = $_POST["main"];

if($main == "like"){

    $res_likes = mysqli_query($connect,"select * from likes where pr_id = ".$pr_id." and user_id = "."'$user_id'"." and like_dislike = 1");
    $num_likes = mysqli_num_rows($res_likes);
    if($num_likes != 0){
        echo "error" ;
    }
    else{
        $res_likes_new = mysqli_query($connect,"select likes_count from likes where pr_id = ".$pr_id ." order by id desc limit 1");
        $num_likes_new = mysqli_num_rows($res_likes_new);

        if($num_likes_new == 0){
            mysqli_query($connect,"INSERT INTO likes(pr_id, user_id, likes_count,like_dislike) VALUES ($pr_id,'$user_id',1,1)");
            echo 1;

        }
        else{
            $fetch_likes = mysqli_fetch_assoc($res_likes_new);
            $number_likes = $fetch_likes["likes_count"];

            $new_number = $number_likes + 1;
            mysqli_query($connect,"INSERT INTO likes(pr_id, user_id, likes_count,like_dislike) VALUES ($pr_id,'$user_id',$new_number,1)");

            $res_likes = mysqli_query($connect,"select * from likes where pr_id = ".$pr_id." and user_id = "."'$user_id'"." and like_dislike = 0");
            $num_likes = mysqli_num_rows($res_likes);
            if($num_likes != 0){
                mysqli_query($connect,"DELETE FROM likes WHERE pr_id = ".$pr_id." and user_id = "."'$user_id'"." and like_dislike = 0");
            }

            echo  $new_number ;
        }


    }
}
elseif($main == "dislike"){
    $res_likes = mysqli_query($connect,"select * from likes where pr_id = ".$pr_id." and user_id = "."'$user_id'"." and like_dislike = 0");
    $num_likes = mysqli_num_rows($res_likes);
    if($num_likes != 0){
        echo "error" ;
    }
    else{
        $res_likes_new = mysqli_query($connect,"select likes_count from likes where pr_id = ".$pr_id ." order by id desc limit 1");
        $num_likes_new = mysqli_num_rows($res_likes_new);

        if($num_likes_new == 0){
            mysqli_query($connect,"INSERT INTO likes(pr_id, user_id, likes_count,like_dislike) VALUES ($pr_id,'$user_id',-1,0)");

            echo -1;

        }
        else{
            $fetch_likes = mysqli_fetch_assoc($res_likes_new);
            $number_likes = $fetch_likes["likes_count"];

            $new_number = $number_likes - 1;
            mysqli_query($connect,"INSERT INTO likes(pr_id, user_id, likes_count,like_dislike) VALUES ($pr_id,'$user_id',$new_number,0)");

            $res_likes = mysqli_query($connect,"select * from likes where pr_id = ".$pr_id." and user_id = "."'$user_id'"." and like_dislike = 1");
            $num_likes = mysqli_num_rows($res_likes);
            if($num_likes != 0){
                mysqli_query($connect,"DELETE FROM likes WHERE pr_id = ".$pr_id." and user_id = "."'$user_id'"." and like_dislike = 1");
            }

            echo  $new_number ;
        }


    }
}

