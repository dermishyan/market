<?php

function filter($x,$connect){
    $x = mysqli_real_escape_string($connect,$x);
    $x = htmlspecialchars($x);
    $x = trim($x);

    return $x;
};

function upload_img($x,$toggle,$pr_eng_name,$cat_eng_name,$error){
    $img_name = "";
    if($x == ""){
        $error = " <div class='alert alert-danger'>
                               <strong>error!</strong>please fell all fields !!!!!
                             </div>";
        $toggle = false;
    }

    if(count($x) > 1){
        for ($i = 0; $i < count($x); $i++) {

            $exploded_names = explode(".", $x[$i]);
            $formats = end($exploded_names);
            $all_formats = ["jpg", "jpeg", "JPEG", "png", "gif","GIF"];

            if (!in_array($formats, $all_formats)) {
                echo "false images or image format";
                $toggle = false;
            }

        }
    }
    else{
        $exploded_name = explode(".", $x);
        $formats = end($exploded_name);
        $all_formats = ["jpg", "jpeg", "JPEG", "png", "gif"];

        if (!in_array($formats, $all_formats)) {
            $error = "     <div class='alert alert-danger'>
                               <strong>error!</strong>  no choosen img or false img format !!!!!
                           </div>";
            $toggle = false;
        }
    }
    if(count($x) > 1){
        for ($i = 0; $i < count($x); $i++) {

            $img_only_name = $x[$i];
            $target_files = "../uploads/$cat_eng_name/$pr_eng_name/$img_only_name";

            if (!file_exists("../uploads/$cat_eng_name/$pr_eng_name")) {
                mkdir("../uploads/$cat_eng_name/$pr_eng_name", 0700);
            }

            move_uploaded_file($_FILES["filesToUpload"]["tmp_name"][$i], $target_files);

        }
    }
    else{
        if ($toggle == true) {

            $img_name = $pr_eng_name.".".$formats;
            $target_file = "../uploads/" . $cat_eng_name."/".$pr_eng_name."/" . $img_name ;
            if (!file_exists("../uploads/" . $cat_eng_name )) {
                mkdir("../uploads/".$cat_eng_name , 0777);
            }
            if (!file_exists("../uploads/$cat_eng_name/$pr_eng_name")) {
                mkdir("../uploads/$cat_eng_name/$pr_eng_name",0777);
            }


            move_uploaded_file($_FILES["filesToUpload"]["tmp_name"], $target_file);
        }
    }



    $array = [$x,$img_name,$error,$toggle];
    return $array;

}
?>