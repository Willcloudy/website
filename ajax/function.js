        function zan(value){
            var postId = $(value).attr("id"); 
            var userId = $(value).children('span').attr("id"); 
            $.ajax({  
                type:"POST",  
                url:"ajax/like.php",  
                dataType:"text",
                async:false, 
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
            async:false, 
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

    function shoucang(value){ 
        var postId = $(value).attr('id'); 
        var userId = $(value).children('span').attr('class'); 
        $.ajax({  
            type:"POST",  
            url:"ajax/shou.php",
            dataType:"text",
            data:{'postId': postId ,'userId': userId},  
            success:function(text){ 
                alert(text);
            },
            error:function(XMLHttpRequest, textStatus, errorThrown){
                // 状态码
                console.log(XMLHttpRequest.status);
                // 状态
                console.log(XMLHttpRequest.readyState);
                // 错误信息
                console.log(textStatus);
                alert("收藏失败");
            }  
        });  
      
    }  

    function shouW(value){ 
        var quId = $(value).attr('id'); 
        var userId = $(value).children('span').attr('class'); 
        $.ajax({  
            type:"POST",  
            url:"ajax/shouW.php",
            dataType:"text",
            data:{'quId': quId ,'userId': userId},  
            success:function(text){ 
                alert(text);
            },
            error:function(XMLHttpRequest, textStatus, errorThrown){
                // 状态码
                console.log(XMLHttpRequest.status);
                // 状态
                console.log(XMLHttpRequest.readyState);
                // 错误信息
                console.log(textStatus);
                alert("收藏失败");
            }  
        });  
      
    }  

    function delete_qu(value){ 
        var quId = $(value).attr('id'); 
        var userId = $(value).children('span').attr('id'); 
        $.ajax({  
            type:"POST",  
            url:"ajax/delete_qu.php",
            dataType:"text",
            data:{'quId': quId ,'userId': userId},  
            success:function(text){ 
                $("#"+quId).delay(100).fadeOut(300);
                $("#"+quId).animate({
                    "opacity" : "0",},{
                    "complete" : function() {
                        $("#"+quId).remove();
                    }
                });
                $("#"+userId).delay(100).fadeOut(300);
                $("#"+userId).animate({
                    "opacity" : "0",},{
                    "complete" : function() {
                        $("#"+userId).remove();
                    }
                });
            },
            error:function(XMLHttpRequest, textStatus, errorThrown){
                // 状态码
                console.log(XMLHttpRequest.status);
                // 状态
                console.log(XMLHttpRequest.readyState);
                // 错误信息
                console.log(textStatus);
                alert("收藏失败");
            }  
        });  
      
    }
    function delete_post(value){ 
        var postId = $(value).attr('id'); 
        var userId = $(value).children('span').attr('id'); 
        $.ajax({  
            type:"POST",  
            url:"ajax/delete_post.php",
            dataType:"text",
            data:{'postId': postId ,'userId': userId},  
            success:function(){ 
                $("#"+postId).delay(100).fadeOut(300);
                $("#"+postId).animate({
                    "opacity" : "0",},{
                    "complete" : function() {
                        $("#"+postId).remove();
                    }
                });
                $("#post"+postId).delay(100).fadeOut(300);
                $("#post"+postId).animate({
                    "opacity" : "0",},{
                    "complete" : function() {
                        $("#post"+postId).remove();
                    }
                });
            },
            error:function(XMLHttpRequest, textStatus, errorThrown){
                // 状态码
                console.log(XMLHttpRequest.status);
                // 状态
                console.log(XMLHttpRequest.readyState);
                // 错误信息
                console.log(textStatus);
                alert("收藏失败");
            }  
        });  
      
    }    

    function delete_answer(value){ 
        var postId = $(value).attr('id'); 
        var userId = $(value).children('span').attr('id'); 
        $.ajax({  
            type:"POST",  
            url:"ajax/delete_post.php",
            dataType:"text",
            data:{'postId': postId ,'userId': userId},  
            success:function(){ 
                $("#"+postId).delay(100).fadeOut(300);
                $("#"+postId).animate({
                    "opacity" : "0",},{
                    "complete" : function() {
                        $("#"+postId).remove();
                    }
                });
                $("#answer"+postId).delay(100).fadeOut(300);
                $("#answer"+postId).animate({
                    "opacity" : "0",},{
                    "complete" : function() {
                        $("#answer"+postId).remove();
                    }
                });
            },
            error:function(XMLHttpRequest, textStatus, errorThrown){
                // 状态码
                console.log(XMLHttpRequest.status);
                // 状态
                console.log(XMLHttpRequest.readyState);
                // 错误信息
                console.log(textStatus);
                alert("收藏失败");
            }  
        });  
      
    } 
    
    function delete_post(value){ 
        var postId = $(value).attr('id'); 
        var userId = $(value).children('span').attr('id'); 
        $.ajax({  
            type:"POST",  
            url:"ajax/delete_post.php",
            dataType:"text",
            data:{'postId': postId ,'userId': userId},  
            success:function(){ 
                $("#"+postId).delay(100).fadeOut(300);
                $("#"+postId).animate({
                    "opacity" : "0",},{
                    "complete" : function() {
                        $("#"+postId).remove();
                    }
                });
                $("#post"+postId).delay(100).fadeOut(300);
                $("#post"+postId).animate({
                    "opacity" : "0",},{
                    "complete" : function() {
                        $("#post"+postId).remove();
                    }
                });
            },
            error:function(XMLHttpRequest, textStatus, errorThrown){
                // 状态码
                console.log(XMLHttpRequest.status);
                // 状态
                console.log(XMLHttpRequest.readyState);
                // 错误信息
                console.log(textStatus);
                alert("收藏失败");
            }  
        });  
      
    }    

    function comfirm_post(value){
        if(confirm("真的要删除你的文章吗？"))
        {delete_post(value)}
    }

    function comfirm_answer(value){
        if(confirm("真的要删除你的回答吗？"))
        {delete_answer(value)}
    }

    
    function comfirm_del_shou_qu(value){
        if(confirm("确定要删除这条收藏吗？"))
        {delete_shou_qu(value)}
    }
    function comfirm_del_shou_post(value){
        if(confirm("确定要删除这条收藏吗？"))
        {delete_shou_post(value)}
    }
    function delete_shou_post(value){
        var postId = $(value).attr('id'); 
        var userId = $(value).children('span').attr('id'); 
        $.ajax({  
            type:"POST",  
            url:"ajax/delete_shou_post.php",
            dataType:"text",
            data:{'postId': postId ,'userId': userId},  
            success:function(text){ 
                alert(text);
                $("#shou_post"+postId).delay(100).fadeOut(300);
                $("#shou_post"+postId).animate({
                    "opacity" : "0",},{
                    "complete" : function() {
                        $("#shou_post"+postId).remove();
                    }
                });
                $("#shou_post_li"+postId).delay(100).fadeOut(300);
                $("#shou_post_li"+postId).animate({
                    "opacity" : "0",},{
                    "complete" : function() {
                        $("#shou_post_li"+postId).remove();
                    }
                });
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
    function delete_shou_qu(value){
        debugger
        var postId = $(value).attr('id'); 
        var userId = $(value).children('span').attr('id'); 
        $.ajax({  
            type:"POST",  
            url:"ajax/delete_shou_qu.php",
            dataType:"text",
            data:{'postId': postId ,'userId': userId},  
            success:function(text){ 
                alert(text);
                $("#shou_qu"+postId).delay(100).fadeOut(300);
                $("#shou_qu"+postId).animate({
                    "opacity" : "0",},{
                    "complete" : function() {
                        $("#shou_qu"+postId).remove();
                    }
                });
                $("#shou_qu_li"+postId).delay(100).fadeOut(300);
                $("#shou_qu_li"+postId).animate({
                    "opacity" : "0",},{
                    "complete" : function() {
                        $("#shou_qu_li"+postId).remove();
                    }
                });
            },
            error:function(XMLHttpRequest, textStatus, errorThrown){
                // 状态码
                console.log(XMLHttpRequest.status);
                // 状态
                console.log(XMLHttpRequest.readyState);
                // 错误信息
                console.log(textStatus);
                alert("收藏失败");
            }  
        });  

    }

    function shoucang(value){ 
        var postId = $(value).attr('id'); 
        var userId = $(value).children('span').attr('class'); 
        $.ajax({  
            type:"POST",  
            url:"ajax/shou.php",
            dataType:"text",
            data:{'postId': postId ,'userId': userId},  
            success:function(text){ 
                alert(text);
            },
            error:function(XMLHttpRequest, textStatus, errorThrown){
                // 状态码
                console.log(XMLHttpRequest.status);
                // 状态
                console.log(XMLHttpRequest.readyState);
                // 错误信息
                console.log(textStatus);
                alert("收藏失败");
            }  
        });  
      
    }  

    function shoucang(value){ 
        var postId = $(value).attr('id'); 
        var userId = $(value).children('span').attr('class'); 
        $.ajax({  
            type:"POST",  
            url:"ajax/shou.php",
            dataType:"text",
            data:{'postId': postId ,'userId': userId},  
            success:function(text){ 
                alert(text);
            },
            error:function(XMLHttpRequest, textStatus, errorThrown){
                // 状态码
                console.log(XMLHttpRequest.status);
                // 状态
                console.log(XMLHttpRequest.readyState);
                // 错误信息
                console.log(textStatus);
                alert("收藏失败");
            }  
        });  
      
    }  

    function follow(value){ 
        var userId = $(value).attr('id'); 
        var follower = $(value).children('span').attr('id'); 
        $.ajax({  
            type:"POST",  
            url:"ajax/follow.php",
            dataType:"text",
            data:{'follower': follower ,'userId': userId},  
            success:function(text){ 
                $("#follow_button").delay(100).fadeTo(300);
                $('#follow_button').html("<a><button onclick='unfollow(this)' class='btn-danger followed_btn'>取消关注</button></a>")
            },
            error:function(XMLHttpRequest, textStatus, errorThrown){
                // 状态码
                console.log(XMLHttpRequest.status);
                // 状态
                console.log(XMLHttpRequest.readyState);
                // 错误信息
                console.log(textStatus);
                alert("收藏失败");
            }  
        });  
      
    }  
    function unfollow(value){ 
        var userId = $(value).attr('id'); 
        var follower = $(value).children('span').attr('id'); 
        $.ajax({  
            type:"POST",  
            url:"ajax/unfollow.php",
            dataType:"text",
            data:{'follower': follower ,'userId': userId},  
            success:function(text){ 
                $("#follow_button").delay(100).fadeTo(300);
                $('#follow_button').html("<a><button onclick='follow(this)' class='follow_btn'>关注</button></a>")
            },
            error:function(XMLHttpRequest, textStatus, errorThrown){
                // 状态码
                console.log(XMLHttpRequest.status);
                // 状态
                console.log(XMLHttpRequest.readyState);
                // 错误信息
                console.log(textStatus);
                alert("收藏失败");
            }  
        });  
      
    }  