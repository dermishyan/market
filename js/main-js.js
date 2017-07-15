$(document).ready(function(){
    $(".close_login").click(function(){
        $(".login_user").hide();
        $(".login_small").show();
    });
    $(".login_small").click(function() {
        $(".login_user").show();
        $(".login_small").hide();
    });


    $(".add_comment").click(function(){
        var comment = $(".comment").val();

        $(".comment").val("");
        var id = $(".add_comment").data("id");
        if(comment == ""){
            $(".error_write").show();
            $(".comment_success").hide();
        }
        else{
            $.ajax({ type: 'post',
                url: 'usercheck.php',
                data: {pr_id:id,comment:comment},
                success:function(response){
                    if(response == "no"){
                        $(".error_login").show();
                        $(".error_write").hide();
                        $(".comment_success").hide();
                    }
                    else if(response == "empty") {
                        $(".error_write").show();
                        $(".comment_success").hide();
                        $(".error_login").hide();
                    }
                    else if(response == "yes"){
                        $(".comment_success").show();
                        $(".error_write").hide();
                        $(".error_login").hide();
                    }
                }
            });
        }

    });





});