<?php
    session_start();
    include('../include/connection.php');
    $webpage = 2;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    
    <meta name="viewport" content="width=device-width, initial-scale=1">  
    <script src="https://cdn.staticfile.org/jquery/2.1.1/jquery.min.js"></script>
    <link rel="stylesheet" href="https://cdn.staticfile.org/twitter-bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://cdn.staticfile.org/twitter-bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <title>热榜 - willcloudy</title>
    <link rel="stylesheet" href="../css/css.css">
    <style>
        .col-md-12 #content:hover{
            text-decoration: none;
            color:#646464;
        }
        .like button{
            margin-left:10px;
            padding:0;
            background-color:transparent;
            border:none;
        }
        .like button:hover{
            color:#068ab6;
        }
        .like span button:focus{
            outline:0;
        }
        #content{
            font-size:1em;
        }
        #myTab{
            padding:0;
            text-align:center;
        }
        #myTab li{
        }
        #myTab li a{
        }
        @media(max-width:992px)
        {
            #post-img img{
                display:none;
            }
            #content{
                font-size:0.9em;
            }
            #myTab li a{
                font-size:0.5em;
            }
        }
    </style>
</head>
<body>
    <div class="container">
            <?php 
                if (isset($_SESSION['user_email'])) {
                    $user = $_SESSION['user_email'];
                    $get_user = "select * from users where user_email = '$user'";
                    mysqli_query($con, "set names 'utf8'");
                    $run_user = mysqli_query($con, $get_user);
                    $row = mysqli_fetch_array($run_user);
                    $u_name = $row['user_name'];
                    $u_image = $row['user_image'];
                    $u_id = $row['user_id'];
                    require('../include/leftbar.php');
                    echo "
                        <script>
                            var profile = document.getElementById('profile');
                            profile.style.display='block';
                            document.getElementById('sign').style.display='none' 
                        </script>";
                }else {
                    require('../include/leftbar.php');
                    echo "<script>
                    document.getElementById('sign').style.display='block' </script>";
                }
            ?>
            <div class="col-md-6 midbar" style='padding:0'id='mid'>
                <div class="box">
                    <form action="../result.php" method="POST">
                        <span>
                            <input style='margin:2% 3%;width:90%;margin-bottom: 0px;'class='form-control search' type="text" name='searchcontent' autocomplete="off" placeholder="关于留学的问题？" required='required'>
                        </span>
                            <span class="glyphicon glyphicon-search glyphicon-search-explore"></span>
                            <a href="result.php"><button class='form-control search-btn btn btn-primary'type='submit'></button></a>
                        
                    </form>
                    <div>
                        <ul id="myTab" class="nav nav-tabs ">
                            <li class="active"><a href="#rb" data-toggle="tab">#热榜</a></li>
                            <li><a href="lastest.php">#最新</a></li>
                            <li><a href="oversealife.php">#海外生活</a></li>
                            <li><a href="question.php">#留学问答</a></li>
                        </ul>
                        <div id="myTabContent" class="tab-content">
                            <div class="tab-pane fade in active" id="rb">
                                <?php
                                    include('../include/get_post.php');
                                    $per_page = 15;
                                
                                    if (isset($_GET['page'])) {
                                        $page = $_GET['page'];
                                    }else {
                                        $page=1;
                                    }
                                    $start_from = ($page-1) * $per_page;
                                
                                    $get_posts = "select * from posts order by post_like DESC LIMIT $start_from, $per_page";
                                    mysqli_query($con, "set names 'utf8'");
                                
                                    echo mysqli_error($con);
                                    $run_posts = mysqli_query($con, $get_posts);
                                    mysqli_query($con, "set names 'utf8'");
                                    echo mysqli_error($con);
                                    while ($row = mysqli_fetch_array($run_posts)) {
                                        echo mysqli_error($con); 
                                        $post_id = $row['post_id'];
                                        $post_content = $row['post_content'];
                                        if(preg_match('/<\s*img\s+[^>]*?src\s*=\s*(\'|\")(.*?)\\1[^>]*?\/?\s*>/i',$post_content,$match)){
                                        $post_img = $match[0];
                                        }else {
                                            $post_img = null;
                                        }
                                        $post_content = strip_tags($post_content);
                                        if (strlen($post_content) > 50) {
                                            $post_content = mb_substr($post_content,0, 60)."..<a href='../post.php?post_id=$post_id' class='view_more' target='_blank'>查看全文</a>";
                                        }
                                
                                        $post_title = $row['post_title'];
                                        $post_date = $row['post_date'];
                                        $user_id = $row['user_id'];
                                        $post_like = $row['post_like'];
                                        $post_view = $row['post_view'];
                                        $post_date = wordTime($post_date);
                                        $writer = "select * from users where user_id = '$user_id' AND posts ='yes'";
                                        mysqli_query($con, "set names 'utf8'");
                                        $run_writer = mysqli_query($con, $writer);
                                        $row_writer = mysqli_fetch_array($run_writer);
                                
                                
                                        $user_name = $row_writer['user_name'];
                                        $user_image = $row_writer['user_image'];
                                
                                        echo "
                                        <div class='col-md-12' style='padding:10px;padding-bottom:5px;border-top: 1px solid #f0f2f7;'>
                                            <div id='post-img'style='float:left;'>
                                                <a id='post_img'href='../post.php?post_id=$post_id' target='_blank'><span>$post_img</span></a>
                                            </div>
                                            <div style='width:100%'>
                                                <a href='../post.php?post_id=$post_id' target='_blank'>
                                                    <b style='line-height:1.4;font-size:1.3em;'>
                                                        $post_title
                                                    </b>
                                                </a>
                                                $post_date
                                                <br>
                                                <a id='image' href='../profile.php?u_id=$user_id' target='_blank' style='font-size:1em;'>
                                                    <img src='../$user_image' class='img-circle' style='width:20px;'> 
                                                </a>
                                                <a id='name' href='../profile.php?u_id=$user_id' target='_blank'style='font-size:1.1em;color:rgb(91, 112, 131)'>
                                                    $user_name  
                                                </a>
                                                :
                                                <a id='content' href='../post.php?post_id=$post_id' target='_blank'>
                                                    $post_content
                                                </a>
                                            </div>
                                            <div style='clear:both'></div>
                                        </div>";
                                        if (isset($u_id)) {
                                            $is_liked = "SELECT * from like_post where user_id ='$u_id' and post_id='$post_id'";
                                            $run_liked = mysqli_query($con,$is_liked);
                                            if (mysqli_num_rows($run_liked) !== 0) {
                                                echo "
                                                <ul class='article-function'>
                                                <li>
                                                    <button id='$post_id' name='$post_id'  style='color:red;background-color:white;' class='btn btn-primary liked_post'>
                                                        <svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='currentColor' class='bi bi-heart-fill' viewBox='0 0 16 16'>
                                                        <path fill-rule='evenodd' d='M8 1.314C12.438-3.248 23.534 4.735 8 15-7.534 4.736 3.562-3.248 8 1.314z'></path>
                                                        </svg>
                                                        <span id=$user_id>
                                                        $post_like
                                                        </span>
                                                    </button>
                                                </li>
                                                <li><a href='../post.php?post_id=$post_id' target='_blank'><button class='btn btn-outline-success'><svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='currentColor' class='bi bi-chat-dots' viewBox='0 0 16 16'><path fill-rule='evenodd' d='M2.678 11.894a1 1 0 0 1 .287.801 10.97 10.97 0 0 1-.398 2c1.395-.323 2.247-.697 2.634-.893a1 1 0 0 1 .71-.074A8.06 8.06 0 0 0 8 14c3.996 0 7-2.807 7-6 0-3.192-3.004-6-7-6S1 4.808 1 8c0 1.468.617 2.83 1.678 3.894zm-.493 3.905a21.682 21.682 0 0 1-.713.129c-.2.032-.352-.176-.273-.362a9.68 9.68 0 0 0 .244-.637l.003-.01c.248-.72.45-1.548.524-2.319C.743 11.37 0 9.76 0 8c0-3.866 3.582-7 8-7s8 3.134 8 7-3.582 7-8 7a9.06 9.06 0 0 1-2.347-.306c-.52.263-1.639.742-3.468 1.105z'/><path d='M5 8a1 1 0 1 1-2 0 1 1 0 0 1 2 0zm4 0a1 1 0 1 1-2 0 1 1 0 0 1 2 0zm4 0a1 1 0 1 1-2 0 1 1 0 0 1 2 0z'/></svg>评论</button></a></li>
                                                <li><a><button class='btn btn-outline-success'><svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='currentColor' class='bi bi-star' viewBox='0 0 16 16'><path fill-rule='evenodd' d='M2.866 14.85c-.078.444.36.791.746.593l4.39-2.256 4.389 2.256c.386.198.824-.149.746-.592l-.83-4.73 3.523-3.356c.329-.314.158-.888-.283-.95l-4.898-.696L8.465.792a.513.513 0 0 0-.927 0L5.354 5.12l-4.898.696c-.441.062-.612.636-.283.95l3.523 3.356-.83 4.73zm4.905-2.767l-3.686 1.894.694-3.957a.565.565 0 0 0-.163-.505L1.71 6.745l4.052-.576a.525.525 0 0 0 .393-.288l1.847-3.658 1.846 3.658a.525.525 0 0 0 .393.288l4.052.575-2.906 2.77a.564.564 0 0 0-.163.506l.694 3.957-3.686-1.894a.503.503 0 0 0-.461 0z'/></svg>收藏</button></a></li>
                                                
                                                    </ul>
                                                    <span style='float:right;margin-right:8%;margin-top:1%;font-size:0.1em;color:rgb(91, 112, 131);'><svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='currentColor' class='bi bi-eye' viewBox='0 -2 16 16'>
                                                        <path fill-rule='evenodd' d='M16 8s-3-5.5-8-5.5S0 8 0 8s3 5.5 8 5.5S16 8 16 8zM1.173 8a13.134 13.134 0 0 0 1.66 2.043C4.12 11.332 5.88 12.5 8 12.5c2.12 0 3.879-1.168 5.168-2.457A13.134 13.134 0 0 0 14.828 8a13.133 13.133 0 0 0-1.66-2.043C11.879 4.668 10.119 3.5 8 3.5c-2.12 0-3.879 1.168-5.168 2.457A13.133 13.133 0 0 0 1.172 8z'/>
                                                        <path fill-rule='evenodd' d='M8 5.5a2.5 2.5 0 1 0 0 5 2.5 2.5 0 0 0 0-5zM4.5 8a3.5 3.5 0 1 1 7 0 3.5 3.5 0 0 1-7 0z'/>
                                                        </svg>&nbsp;&nbsp;<span>$post_view</span>
                                                    </span>
                                                    <div style='clear:both'></div>
                                                ";
                                            }else{
                                                echo "
                                                <ul class='article-function'>
                                                <li>
                                                    <button id='$post_id' name='$post_id'  class='btn btn-primary like_post'>
                                                        <svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='currentColor' class='bi bi-heart-fill' viewBox='0 0 16 16'>
                                                        <path fill-rule='evenodd' d='M8 1.314C12.438-3.248 23.534 4.735 8 15-7.534 4.736 3.562-3.248 8 1.314z'></path>
                                                        </svg>
                                                        <span id=$u_id>";
                                                        if ($post_like == null or $post_like == 0) {
                                                            echo "点赞";
                                                        }else {
                                                            echo '  '.$post_like;
                                                        }           
                                                                
                                                        echo  "
                                                        </span>
                                                    </button>
                                                </li>
                                                        <li><a href='../post.php?post_id=$post_id' target='_blank'><button class='btn btn-outline-success'><svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='currentColor' class='bi bi-chat-dots' viewBox='0 0 16 16'><path fill-rule='evenodd' d='M2.678 11.894a1 1 0 0 1 .287.801 10.97 10.97 0 0 1-.398 2c1.395-.323 2.247-.697 2.634-.893a1 1 0 0 1 .71-.074A8.06 8.06 0 0 0 8 14c3.996 0 7-2.807 7-6 0-3.192-3.004-6-7-6S1 4.808 1 8c0 1.468.617 2.83 1.678 3.894zm-.493 3.905a21.682 21.682 0 0 1-.713.129c-.2.032-.352-.176-.273-.362a9.68 9.68 0 0 0 .244-.637l.003-.01c.248-.72.45-1.548.524-2.319C.743 11.37 0 9.76 0 8c0-3.866 3.582-7 8-7s8 3.134 8 7-3.582 7-8 7a9.06 9.06 0 0 1-2.347-.306c-.52.263-1.639.742-3.468 1.105z'/><path d='M5 8a1 1 0 1 1-2 0 1 1 0 0 1 2 0zm4 0a1 1 0 1 1-2 0 1 1 0 0 1 2 0zm4 0a1 1 0 1 1-2 0 1 1 0 0 1 2 0z'/></svg>评论</button></a></li>
                                                        <li><a><button class='btn btn-outline-success'><svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='currentColor' class='bi bi-star' viewBox='0 0 16 16'><path fill-rule='evenodd' d='M2.866 14.85c-.078.444.36.791.746.593l4.39-2.256 4.389 2.256c.386.198.824-.149.746-.592l-.83-4.73 3.523-3.356c.329-.314.158-.888-.283-.95l-4.898-.696L8.465.792a.513.513 0 0 0-.927 0L5.354 5.12l-4.898.696c-.441.062-.612.636-.283.95l3.523 3.356-.83 4.73zm4.905-2.767l-3.686 1.894.694-3.957a.565.565 0 0 0-.163-.505L1.71 6.745l4.052-.576a.525.525 0 0 0 .393-.288l1.847-3.658 1.846 3.658a.525.525 0 0 0 .393.288l4.052.575-2.906 2.77a.564.564 0 0 0-.163.506l.694 3.957-3.686-1.894a.503.503 0 0 0-.461 0z'/></svg>收藏</button></a></li>
                                                        
                                                            </ul>
                                                            <span style='float:right;margin-right:8%;margin-top:1%;font-size:0.1em;color:rgb(91, 112, 131);'><svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='currentColor' class='bi bi-eye' viewBox='0 -2 16 16'>
                                                                <path fill-rule='evenodd' d='M16 8s-3-5.5-8-5.5S0 8 0 8s3 5.5 8 5.5S16 8 16 8zM1.173 8a13.134 13.134 0 0 0 1.66 2.043C4.12 11.332 5.88 12.5 8 12.5c2.12 0 3.879-1.168 5.168-2.457A13.134 13.134 0 0 0 14.828 8a13.133 13.133 0 0 0-1.66-2.043C11.879 4.668 10.119 3.5 8 3.5c-2.12 0-3.879 1.168-5.168 2.457A13.133 13.133 0 0 0 1.172 8z'/>
                                                                <path fill-rule='evenodd' d='M8 5.5a2.5 2.5 0 1 0 0 5 2.5 2.5 0 0 0 0-5zM4.5 8a3.5 3.5 0 1 1 7 0 3.5 3.5 0 0 1-7 0z'/>
                                                                </svg>&nbsp;&nbsp;<span>$post_view</span>
                                                            </span>
                                                            <div style='clear:both'></div>
                                                        ";
                                                }
                                        }else{
                                            echo "<br>";
                                            }
                                        }
                                    $query = "select * from posts";
                                    mysqli_query($con, "set names 'utf8'");
                                    $result = mysqli_query($con, $query);
                                
                                    $total_posts = mysqli_num_rows($result);
                                
                                    $total_pages = ceil($total_posts / $per_page);
                                    if ($total_pages == 1 or $total_pages == 0) {
                                        # code...
                                    }else {
                                        
                                    echo "
                                    <center>
                                        <div class='pagination'>
                                        <a href='hot.php?page=1'>首页</a>
                                    ";
                                    if ($page == 1) {
                                        for ($i=1; $i <= 3; $i++) { 
                                            if ($i == $page) {
                                                echo "<a href='hot.php?page=$i' style='color:#198754'>$i</a>";
                                            }else {
                                                echo "<a href='hot.php?page=$i'>$i</a>";
                                            }
                                        if ($i == $total_pages) {
                                            break;
                                        }
                                    }
                                    }elseif ($page == 2) {
                                        echo "<a href='hot.php?page=1'>1</a>";
                                        for ($i=2; $i < 5; $i++) { 
                                            if ($i == $page) {
                                                echo "<a href='hot.php?page=$i' style='color:#198754'>$i</a>";
                                            }else {
                                                echo "<a href='hot.php?page=$i'>$i</a>";
                                            }
                                            
                                            if ($i == $total_pages) {
                                                break;
                                            }
                                        }
                                    }elseif ($page == $total_pages) {
                                        $pre2 = $page - 2;
                                        $pre1 = $page - 1;
                                        echo "<a href='hot.php?page=$pre2' >$pre2</a>";
                                        echo "<a href='hot.php?page=$pre1' >$pre1</a>";
                                        echo "<a style='color:#198754'>$page</a>";
                                    }
                                    else {
                                        $bac1 = $page + 1;
                                        $pre2 = $page - 2;
                                        $pre1 = $page - 1;
                                        echo "<a href='hot.php?page=$pre2' >$pre2</a>";
                                        echo "<a href='hot.php?page=$pre1' >$pre1</a>";
                                        echo "<a style='color:#198754'>$page</a>";
                                        echo "<a href='hot.php?page=$bac1' >$bac1</a>";
                                    }
                                    
                                    
                                    echo "<a href='hot.php?page=$total_pages'>尾页</a>";
                                    echo "<a>共 $total_pages 页</a>
                                    </div>";
                                }
                                ?>
                            </div>
                        </div>
                    </div>
                </div>  
            </div>
            <?php
                require('../include/rightbar.php');
            ?>
            
    </div>
</body>
</html>
<script>
    
    var ele = document.getElementById("search");
    ele.href="javascript:void(0);";
    //ele.style.backgroundColor = "rgb(181,212,213)";
    ele.style.color ="#198754";
    ele.onmouseover =  function () {
    this.style.backgroundColor = "white";
    }

    var rightbar = document.getElementById('topic');
    rightbar.style.display='block';
    document.getElementById('other').style.display='none'
    document.getElementById('topic').style.marginTop= "70px"
    document.getElementById('search-small').style.display='none'

    $('.liked_post').click(function(){
        var clickBtnValue = $(this).attr("name"); 
        var userId = $(this).children('span').attr("id"); 
        var change = $(this).attr("id");
        $.ajax({
            type:"GET",
            url: "../include/dislike.php", 
            dataType:"JSON",
            contentType:"application/json",
            async:true,
            data:{id:clickBtnValue,userid:userId}, 
            success: function(status){
                $('#'+change).css("color","white");
                $('#'+change).css("backgroundColor","#198754");
                buttonval = Number($('#'+change).val())*1 - 1
                console.log(buttonval);
                like_num = $('#'+change).children('span').text();
                like_num = Number(like_num) - 1;
                $('#'+change).children('span').html(like_num);
                parent.location.reload()
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
    });

    $('.like_post').click(function(){
        var clickBtnValue = $(this).attr("name"); 
        var userId = $(this).children('span').attr("id"); 
        var change = $(this).attr("id");
        $.ajax({
            type:"GET",
            url: "../include/like.php", 
            dataType:"JSON",
            contentType:"application/json",
            async:true,
            data:{id:clickBtnValue,userid:userId}, 
            success: function(status){
                $('#'+change).css("color","red");
                $('#'+change).css("backgroundColor","white");
                like_num = $('#'+change).children('span').text();
                console.log(like_num);
                like_num = Number(like_num) + 1;
                $('#'+change).children('span').html(like_num);
                parent.location.reload()
            },
            error:function(XMLHttpRequest, textStatus, errorThrown){
                // 状态码
                console.log(XMLHttpRequest.status);
                // 状态
                console.log(XMLHttpRequest.readyState);
                // 错误信息
                console.log(textStatus);
                alert("点赞失败");


            }
        }); 
    }); 
    

</script>