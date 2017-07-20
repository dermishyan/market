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


    $(".button-vote").click(function(){
        var voice_pr_id = $("input[class='vote']:checked").data("id");
        var parent = $("input[class='vote']:checked").parent().parent();

        $.ajax({
            type: 'post',
            url: 'vote.php',
            data: {id:voice_pr_id},
            success:function(response){
                if(response == "error"){
                    $(".error_login_vote").show();
                }
                else{

                  var procents = JSON.parse(response);

                    for(i = 0; i < procents.length; i++){
                       var num = i+1;
                        //console.log($("div[data-num=" + num + "]"));
                        $("div[data-num=" + num + "]").css("width",procents[i]+"%");
                    }
                    $(".error_login_vote").hide();
                }


            }

        })
    });

    $(".like").click(function(){
        var pr_id = $(this).data("prid");
        var user_id = $(this).data("userid");
        var main = $(this).data("main");
        $(".dislike").css("background","#fff");
        $(".like").css("background","#34f2e6");
        if(user_id == ""){

            $(".error_login").show();
        }
        else{
            $.ajax({
                type: 'post',
                url: 'likes.php',
                data: {id:pr_id,user_id:user_id,main:main},
                success:function(response){

                    if(response == "error"){

                        $(".like").css("background","red");
                    }
                    else{
                        var number = response;
                        $(".number").text(number);
                    }
                }
            })

        }
    });
    $(".dislike").click(function(){
        var pr_id = $(this).data("prid");
        var user_id = $(this).data("userid");
        var main = $(this).data("main");
        $(".like").css("background","#fff");
        $(".dislike").css("background","#34f2e6");
        if(user_id == ""){

            $(".error_login").show();
        }
        else{
            $.ajax({
                type: 'post',
                url: 'likes.php',
                data: {id:pr_id,user_id:user_id,main:main},
                success:function(response){

                    if(response == "error"){

                        $(".dislike").css("background","red");
                    }
                    else{
                        var number = response;
                        $(".number").text(number);
                    }
                }
            })

        }
    })






});