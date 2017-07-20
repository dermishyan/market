$(document).ready(function(){
    $('.error').hide();
    $(".go-btn").click(function(){
        login = $(".user").val();
        password = $(".pass").val();
        $.ajax({
            type: 'post',
            url: 'admincheck.php',
            data: {user:login,pass:password},
            success: function(num){
                if(num == 1){

                    window.location.href = 'admin.php';

                }
                else if(num == 0){
                    $('.error').show();
                    $('.pass').val('');
                }
            }
        })
    });
    //$(".logout").click(function(){
    //
    //});
    $(".btn-edit").click(function(){

        val1 =  $(this).parent().parent().children("td:nth-child(1)").text();
        val2 =  $(this).parent().parent().children("td:nth-child(2)").text();
         id = $(this).data("id");

        $(".edit-inp-eng").val(val1);
        $(".edit-inp-arm").val(val2);
        $(".hidden-inp").val(id);

    });

    $(".btn-remove").click(function(){
        eng =  $(this).parent().parent().children("td:nth-child(1)").text();

        arm =  $(this).parent().parent().children("td:nth-child(2)").text();
        id = $(this).data("id");
        name_first = $(this).data("name");

        if(name_first == 'slider_image'){
            id = '';
        }
        $(".cont").text(name);



    });

    $(".remove").click(function(){
        if(name_first == "slider_image"){
            name = "slider_image";

        }else{
            name = $(this).data("name");
        }

        if(name == 'image'){
            img_id = [];
            $("input[class='imgcheck']:checked").each(function(){
                var $this = $(this);
                if($this.is(":checked")){
                    img_id.push($this.attr("data-id"));
                }

            });
        }else if(name == 'slider_image'){
            img_id = [];
            $("input[class='imgcheck']:checked").each(function(){
                var $this = $(this);
                if($this.is(":checked")){
                    img_id.push($this.attr("data-id"));
                }

            });
        }
        else{
            img_id = "";
        }

        console.log(name);
        console.log(id);

        $.ajax({ type: 'post',
                 url: 'remove.php',
                 data: {name:name,id:id,img_array:img_id},
                 success:function(response){

                     if(response == 1){
                         $("tr[data-id=" + id + "]").remove();

                     }
                     if(response == 2){

                         $("tr[data-id=" + id + "][data-name=" + name + "]").remove();

                     }
                     if(response == "images deleted") {



                       for(i = 0 ; i < img_id.length; i++ ){
                           $("div[data-id=" + img_id[i] + "].imgs").remove();


                       }
                     }
                     if(response == "slider images deleted") {



                       for(i = 0 ; i < img_id.length; i++ ){

                           $("div[data-id=" + img_id[i] + "].slider_imgs").remove();

                       }
                     }
                     if(response == "comment deleted"){
                         $("tr[data-id=" + id + "][data-name=" + name + "]").remove();
                     }

                 }
        })

    });

    $(".btn-show").click(function(){
        cat_eng_name =  $(this).parent().parent().parent().children("td:nth-child(1)").text();
        cat_id = $(this).data("id");
        //console.log();
        $.ajax({ type: 'post',
            url: 'products.php',
            data: {eng_name:cat_eng_name,row_id:cat_id},
            success:""
        });

        $(this).parent().attr("href","products.php?cat_eng_name="+cat_eng_name+"&cat_id="+cat_id)

    });
    $(".btn-edit-product").click(function(){



        val1 =  $(this).parent().parent().parent().children("td:nth-child(1)").text();
        val2 =  $(this).parent().parent().parent().children("td:nth-child(2)").text();
        val3 =  $(this).parent().parent().parent().children("td:nth-child(3)").text();
        val4 =  $(this).parent().parent().parent().children("td:nth-child(4)").text();
        val5 =  $(this).parent().parent().parent().children("td:nth-child(5)").text();
        val6 =  $(this).parent().parent().parent().children("td:nth-child(6)").text();

    });

    $(".let_on").click(function(){

        var toggle =  $(this).text();
        var comment_id = $(this).data("id");

        if(toggle == "let on"){
            $(this).text("dismiss");
        }
        else if(toggle == "dismiss"){
            $(this).text("let on");
        }

        $.ajax({
            type: 'post',
            url: 'commentcheck.php',
            data: {toggle:toggle,id:comment_id}


        })


    });
    setInterval(function(){
        toggle="check";
        comment_id="";

        $.ajax({
            type: 'post',
            url: 'commentcheck.php',
            data: {toggle:toggle,id:comment_id},
            success:function(response){

                $(".num_comments").text(response);
                if(response != 0){
                    $(".num_comments").css("color", "red","font-size","22px");
                }
            }

        })
    },8000);







});