
        function zan(value){
            var postId = $(value).attr("id"); 
            var userId = $(value).children('span').attr("id"); 
            $.ajax({  
                type:"POST",  
                url:"ajax/like.php",  
                dataType:"text",
                data:{'postId': postId ,'userId': userId},  
                success:function(text){  
                    $("#"+postId).html(text);  
                },
                error:function(XMLHttpRequest, textStatus, errorThrown){
                    // 状态码
                    console.log(XMLHttpRequest.status);
                    // 状态
                    console.log(XMLHttpRequest.readyState);
                    // 错误信息
                    console.log(textStatus);
                }
            });  
        
    }  

    function zanDel(value){ 
        var postId = $(value).attr('id'); 
        var userId = $(value).children('span').attr('id'); 
        $.ajax({  
            type:"POST",  
            url:"ajax/dislike.php",
            dataType:"text",
            data:{'postId': postId ,'userId': userId},  
            success:function(text){  
                $("#"+postId).html(text);  
            },
            error:function(XMLHttpRequest, textStatus, errorThrown){
                // 状态码
                console.log(XMLHttpRequest.status);
                // 状态
                console.log(XMLHttpRequest.readyState);
                // 错误信息
                console.log(textStatus);
                alert("取消失败");
            }  
        });  
      
    }  