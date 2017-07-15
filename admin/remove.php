<?php
include "connect.php";
include "filter.php";


$name = $_POST["name"];
$id = $_POST["id"];
$images = $_POST["img_array"];

if($name == "category"){
    $res_cat =  mysqli_query($connect,"select eng_name from categories where id ="."$id");
    $fetch_cat = mysqli_fetch_assoc($res_cat);
    $cat_eng_name = $fetch_cat["eng_name"];

    $res_pr =  mysqli_query($connect,"select * from products where category_id ="."$id");
    while( $fetch_pr = mysqli_fetch_assoc($res_pr)){
    $pr_id = $fetch_pr["id"];
    $pr_eng_name = $fetch_pr["pr_eng_name"];
    $pr_img = $fetch_pr["pr_img"];
    $res_img = mysqli_query($connect, "select img_name from images where pr_id =" . "$pr_id");

        while ($fetch_img = mysqli_fetch_assoc($res_img)) {
                $img_name = $fetch_img["img_name"];
                unlink("../uploads/$cat_eng_name/$pr_eng_name/$img_name");

        }
        unlink("../uploads/$cat_eng_name/$pr_eng_name/$pr_img");
        rmdir("../uploads/$cat_eng_name/$pr_eng_name");
    }
    rmdir("../uploads/$cat_eng_name");
    mysqli_query($connect,"DELETE FROM images WHERE cat_id ="."$id");
    mysqli_query($connect,"DELETE FROM products WHERE category_id ="."$id");
    mysqli_query($connect,"DELETE FROM categories WHERE id ="."$id");
    echo 1;

}
if($name == "products"){

    $res_pr =  mysqli_query($connect,"select * from products where id ="."$id");
    $fetch_pr = mysqli_fetch_assoc($res_pr);
    $pr_eng_name = $fetch_pr["pr_eng_name"];
    $pr_img = $fetch_pr["pr_img"];
    $cat_id = $fetch_pr["category_id"];

    $res_cat =  mysqli_query($connect,"select eng_name from categories where id ="."$cat_id");
    $fetch_cat = mysqli_fetch_assoc($res_cat);
    $cat_eng_name = $fetch_cat["eng_name"];

    $res_img = mysqli_query($connect, "select img_name from images where pr_id =" . "$id");
    while ($fetch_img = mysqli_fetch_assoc($res_img)) {
        $img_name = $fetch_img["img_name"];

        unlink("../uploads/$cat_eng_name/$pr_eng_name/$img_name");

    }
    unlink("../uploads/$cat_eng_name/$pr_eng_name/$pr_img");
    rmdir("../uploads/$cat_eng_name/$pr_eng_name");


    mysqli_query($connect,"DELETE FROM images WHERE pr_id ="."$id");
    mysqli_query($connect,"DELETE FROM products WHERE id ="."$id");

    echo 2;

}
if($name == "image"){
    for($i = 0;$i < count($images);$i++){
    $res_img = mysqli_query($connect, "select * from images where id =" . "$images[$i]");
    $fetch_img = mysqli_fetch_assoc($res_img);
    $img_name = $fetch_img["img_name"];
    $cat_id = $fetch_img["cat_id"];
    $pr_id = $fetch_img["pr_id"];


    $res_cat =  mysqli_query($connect,"select eng_name from categories where id ="."$cat_id");
    $fetch_cat = mysqli_fetch_assoc($res_cat);
    $cat_eng_name = $fetch_cat["eng_name"];


    $res_pr =  mysqli_query($connect,"select pr_eng_name from products where id ="."$pr_id");
    $fetch_pr = mysqli_fetch_assoc($res_pr);
    $pr_eng_name = $fetch_pr["pr_eng_name"];


        unlink("../uploads/$cat_eng_name/$pr_eng_name/$img_name");

        $res_img = mysqli_query($connect, "delete from images where id = $images[$i]");
    }

    echo "images deleted";
//
}

if($name == "slider_image"){


    for($i =0 ;$i < count($images);$i++){
        $res_img = mysqli_query($connect, "select * from slider where id =" . " $images[$i]");
        $fetch_img = mysqli_fetch_assoc($res_img);
        $img_name = $fetch_img["img_name"];
        unlink("../uploads/slider/$img_name");
       mysqli_query($connect, "delete from slider where id = $images[$i]");
    }

    echo "slider images deleted";

}

if($name == "comment"){
    mysqli_query($connect,"delete from comments where id = ".$id);

    echo "comment deleted";
}


?>