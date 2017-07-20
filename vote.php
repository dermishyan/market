<?php
include "admin/connect.php";
session_start();
if(!isset($_SESSION["user_id"])){
    echo "error";
}
else{
    $user_id = $_SESSION["user_id"];
    $voice_pr_id = $_POST{"id"};

    $error = "";
    $new_tag = "";
    $old_tag = "";

    $res_user = mysqli_query($connect,"select * from users where id = ".$user_id);
    $fetch_voice = mysqli_fetch_assoc($res_user) ;
    $id_voice = $fetch_voice["voice_id"];
    if($id_voice == 0){

        $res_voice = mysqli_query($connect,"select * from voices where id = "."$voice_pr_id");
        $fetch_voice = mysqli_fetch_assoc($res_voice);
        $num_voices = $fetch_voice["num_voice"];

        $new_num_voices = $num_voices + 1;

        mysqli_query($connect,"update voices set num_voice = ".$new_num_voices ." where id = "."$voice_pr_id" );
        mysqli_query($connect,"update users set voice_id = ".$voice_pr_id ." where id = "."$user_id" );

    }
    else{
        $res_voice_new = mysqli_query($connect,"select * from voices where id = "."'$voice_pr_id'");
        $fetch_voice_new = mysqli_fetch_assoc($res_voice_new);
        $num_voices = $fetch_voice_new["num_voice"];

        $new_num_voices = $num_voices + 1;
        mysqli_query($connect,"update voices set num_voice = ".$new_num_voices ." where id = "."$voice_pr_id" );


        $res_voice_old = mysqli_query($connect,"select * from voices where id = "."$id_voice");
        $fetch_voice_old = mysqli_fetch_assoc($res_voice_old);
        $old_num_voice = $fetch_voice_old["num_voice"];

        $old_num_voices = $old_num_voice - 1;
        mysqli_query($connect,"update voices set num_voice = ".$old_num_voices ." where id = "."$id_voice" );
        mysqli_query($connect,"update users set voice_id = ".$voice_pr_id ." where id = "."$user_id" );

    }

    $res_user_voice = mysqli_query($connect,"select * from users where voice_id != 0");
    $num_users_voice = mysqli_num_rows($res_user_voice);


    $res_voices = mysqli_query($connect,"select * from voices ");
    $response = [];
    while($fetch_voices = mysqli_fetch_assoc($res_voices)){

        $num_voice = $fetch_voices["num_voice"];

        $procent = $num_voice * 100 / $num_users_voice ;


      array_push($response,$procent);
    }

    echo  json_encode($response);
}



