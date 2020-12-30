<?php
    session_start();
    $webpage = 1;
    include('include/connection.php');
    if (isset($_SESSION['user_email'])) {
        $user = $_SESSION['user_email'];
        $get_user = "select * from users where user_email = '$user'";
        mysqli_query($con, "set names 'utf8'");
        $run_user = mysqli_query($con, $get_user);
        $row = mysqli_fetch_array($run_user);
        $u_id = $row['user_id'];
        $u_image = $row['user_image'];
        $u_name = $row['user_name'];
    }//else {
       //header('location:home.php?from=login');
    //}
    if (!empty($_GET['u_id'])) {
        $user_id = $_GET['u_id'];
        $get1_user = "select * from users where user_id = '$user_id'";
        mysqli_query($con, "set names 'utf8'");
        $run1_user = mysqli_query($con, $get1_user);
        $row1 = mysqli_fetch_array($run1_user);
        $user_name = $row1['user_name'];
        if (empty($user_name)) {
            echo "<script>alert('用户不存在')</script>";
            echo "<script>window.open('home.php', '_self')</script>";
        }
        $user_image = $row1['user_image'];
        $user_cover = $row1['user_cover'];
        $user_des = $row1['user_des'];
        $user_id = $row1['user_id'];
        $user_country = $row1['user_country'];
        $user_gender = $row1['user_gender'];
        if ($user_gender == 1) {
            $user_gender ='男';
        }elseif ($user_gender == 2) {
            $user_gender = '保密';
        }elseif($user_gender == 0)  {
            $user_gender = '女';
        }
    }else{
        header('location:home.php');
    }
    if (!empty($u_id)) {
        if ($u_id == $user_id) {
            $status = 1;
        }else {
            $status = 2;
        }
    }else {
        $status = 0;
    }
        
    
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">  
    <script src="https://cdn.staticfile.org/jquery/2.1.1/jquery.min.js"></script>
    <link rel="stylesheet" href="https://cdn.staticfile.org/twitter-bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://cdn.staticfile.org/twitter-bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <title><?php echo $user_name?> - willcloudy</title>
    <link rel="stylesheet" href="css/css.css">
    <style>
        .avatar{
            margin:0px;
            padding:0px;
            position:absolute;
            top:47px;
            left:20px;
            border:2px solid white;
        }
        .info{
            color:black;
            font-weight: bold;
            font-size:2em;
            margin-left:25%;
        }
        .des{
            color:grey;
            font-weight:normal;
            font-size:1em;
            position:relative;
        }
        a .editProfile{
            position:absolute;
            top:60%;
            left:80%;
            font-weight:bold;
            color: #198754;
            border:1px solid #198754;
            border-radius: 2px;
            background:white;
        }
        a .follow_btn{
            position:absolute;
            top:60%;
            left:88%;
            font-weight:bold;
            color: #198754;
            border:1px solid #198754;
            border-radius: 2px;
            background:white;
        }
        a .editProfile:focus, a .follow_btn:focus{
            outline:none;
        }
        a .editProfile:hover, a .follow_btn:hover{
            background:#198754;
            color:white;
            border:1px solid white;
            border-radius: 2px;
        }
        #userFunction{
            font-size:1em;
            font-weight:bold;
            padding:0px;
        }
        #userFunction li{
            text-decoration: none;  /*去掉前面的圆点*/
			list-style: none;
			border: 1px solid #FFFFFF;
            display: inline-block;
            width:10%;
            text-align:center;
            padding:0px;
            height:10px;
        }
        #userFunction li a{
            color:#040404;
			text-decoration: none;
			margin:0px;
			height:10%; 
			line-height:40px; 
            padding:0px;
        }
        #userFunction li:hover{
			background-color: ;
		}
        #col-moredes,#col-closedes{
            background-color:white;
            outline: none;
            border:none;
        }
        #col-closedes{
            display:none;
        }
        .more{
            margin-left:24%;
        }
        @media(max-width:992px)
        {
            a .editProfile{
                top:5%;
                left:68%;
            }
            .avatar{
                top: 60px;
                left: 10px;
                width:75px;
            }
            .info{
                font-size:1.5em;
            }
        }
    </style>
</head>
<body>
<div class="container">
    <?php
        require('include/leftbar.php');
        if ($status == 2 or $status == 1) {
            echo "
            <script>
                var profile = document.getElementById('profile');
                profile.style.display='block';
                document.getElementById('sign').style.display='none';
            </script>";
        }else {
            echo "<script>
            document.getElementById('sign').style.display='block' </script>";
        }
       
    ?>
    <div class="col-md-6 midbar" style='padding:0;'>
        <div class="box" style='margin-top:0;position:relative'>
            <img src="<?php echo $user_cover;?>" alt="cover" width='100%' height='100px'style='margin:0;padding:0;border-radius:10px 10px 0px 0px'>
            <script>
            function click() {
                window.location.href='edit.php'
            }
            </script>
            <?php
            if ($status == 1) {
                echo "<a href='edit.php'><button class='editProfile'>编辑个人资料</button></a>";
            }elseif($status == 2){
                echo "<a><button class='follow_btn'>关注</button></a>";
            }elseif($status == 0){
                echo "<a href='home.php'><button class='follow_btn'>关注他</button></a>";
            }
            ?>
            <img src="<?php echo $user_image;?>" alt="avatar" width='19%' class='img-circle avatar'>
            <div>
                <span class='info'><?php echo $user_name;?></span>
                <br>
                <span class="des" style='margin-left:25%;'><?php echo $user_des;?></span>
                <br>
                <div class='more'>
                    <button data-toggle="collapse" data-target="#moredes" id='col-moredes'>
                        <svg id='down-arrow' width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-caret-down-fill" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                            <path d="M7.247 11.14L2.451 5.658C1.885 5.013 2.345 4 3.204 4h9.592a1 1 0 0 1 .753 1.659l-4.796 5.48a1 1 0 0 1-1.506 0z"/>
                        </svg>
                        <span id='zk'>展开更多资料</span>
                    </button>
                    <button data-toggle="collapse" data-target="#moredes" id='col-closedes'>
                        <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-caret-up-fill" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                            <path d="M7.247 4.86l-4.796 5.481c-.566.647-.106 1.659.753 1.659h9.592a1 1 0 0 0 .753-1.659l-4.796-5.48a1 1 0 0 0-1.506 0z"/>
                        </svg>
                        <span id='zk'>收起更多资料</span>
                    </button>
                    <div id="moredes" style='margin-top:10px;' class="collapse">
                        <span style='font-weight:bold;'>居住地: <?php echo $user_country;?></span>
                        <!-- <span style='margin:10%;font-weight:bold;'>教育经历: <?php //echo @$user_uni;?></span> --><br><br>
                        <span style='font-weight:bold;'>性别: <?php echo $user_gender;?></span>
                    </div>
                    <script>
                        window.onload = function(){
                        var sm_open = document.getElementById("col-moredes");//展开操作详情按钮 
                        var sm_close = document.getElementById("col-closedes");//关闭操作详情按钮
                        //操作详情表的展开和收起
                            sm_open.onclick = function(){
                                sm_close.style.display = "block";
                                sm_open.style.display = "none";
                            };
                            sm_close.onclick = function(){
                                sm_close.style.display = "none";
                                sm_open.style.display = "block";
                            };
                        };
                        
                    </script>
                </div>
            </div>
            <br>
            <hr class='hrmargin'>

            <div class="col-md-12" style='padding:0px;margin:0px;'>
                <!-- <nav>
                    <ul id='userFunction'>
                        <li><a href="">动态</a></li>
                        <li><a href="">回答</a></li>
                        <li><a href="">文章</a></li>
                        <li><a href="">收藏</a></li>
                        <li><a href="">关注</a></li>
                        <li><a href="">粉丝</a></li>
                    </ul>
                </nav> -->
                <ul id="myTab" class="nav nav-tabs ">
                    <li class="active"><a href="#dt" data-toggle="tab">提问</a></li>
                    <li><a href="#wz" data-toggle="tab">文章</a></li>
                    <li><a href="#hd"data-toggle="tab">回答</a></li>
                    <li><a href="#gz" data-toggle="tab">关注</a></li>
                    <li><a href='#fs' data-toggle='tab'>粉丝</a></li>
                    <li><a href='#sc' data-toggle='tab'>收藏</a></li>
                </ul>
                <div id="myTabContent" class="tab-content" style='min-height:265px;'>
                    <div class="tab-pane fade in active" id="dt">
                    <?php
                        include('include/get_post.php');
                        $get_posts = "select * from question where user_id = $user_id order by qu_date DESC";
                        mysqli_query($con, "set names 'utf8'");

                        $run_posts = mysqli_query($con, $get_posts);
                        while ($row = mysqli_fetch_array($run_posts)) {
                            $qu_id = $row['qu_id'];
                            $question = $row['question'];
                            
                            $qu_date = $row['qu_date'];
                            $user_id = $row['user_id'];
                            $is_answered = $row['is_answered'];
                            if ($is_answered == 'no') {
                                $qu_content = "暂无回答";
                            }
                            $post_date = wordTime($qu_date);
                            $writer = "select * from users where user_id = '$user_id'";
                            mysqli_query($con, "set names 'utf8'");
                            $run_writer = mysqli_query($con, $writer);
                            $row_writer = mysqli_fetch_array($run_writer);

                            if (!empty($row_writer['user_name'])) {
                                $user_name = $row_writer['user_name'];
                            }
                            if (!empty($row_writer['user_image'])) {
                                $user_image = $row_writer['user_image'];
                            }
                    

                        echo "
                        <div id='delete$qu_id'>
                        <div class='col-md-12' style='padding:10px;padding-bottom:5px;border-top: 1px solid #f0f2f7;'>
                            <div style='width:100%'>
                            
                                <a id='image' href='../profile.php?u_id=$user_id' target='_blank' style='font-size:1em;'>
                                    <img src='../$user_image' class='img-circle' style='width:30px;'> 
                                </a>
                        
                                <a id='name' href='../profile.php?u_id=$user_id' target='_blank'style='font-size:1.2em;'>
                                    $user_name  :
                                </a>

                                <a href='../post.php?qu_id=$qu_id' target='_blank'>
                                    <b style='line-height:1.4;font-size:1.3em;'>
                                        $question
                                    </b>
                                </a>
                                
                                $post_date
                                <br>
                            </div>
                            <div style='clear:both'></div>
                        </div>
                        <ul class='article-function'>
                            <li>
                            <a >
                                <button type='button' class='btn btn-primary' style='color:white;'>
                                    <svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='currentColor' class='bi bi-chat-dots' viewBox='0 0 16 16'>
                                        <path fill-rule='evenodd' d='M2.678 11.894a1 1 0 0 1 .287.801 10.97 10.97 0 0 1-.398 2c1.395-.323 2.247-.697 2.634-.893a1 1 0 0 1 .71-.074A8.06 8.06 0 0 0 8 14c3.996 0 7-2.807 7-6 0-3.192-3.004-6-7-6S1 4.808 1 8c0 1.468.617 2.83 1.678 3.894zm-.493 3.905a21.682 21.682 0 0 1-.713.129c-.2.032-.352-.176-.273-.362a9.68 9.68 0 0 0 .244-.637l.003-.01c.248-.72.45-1.548.524-2.319C.743 11.37 0 9.76 0 8c0-3.866 3.582-7 8-7s8 3.134 8 7-3.582 7-8 7a9.06 9.06 0 0 1-2.347-.306c-.52.263-1.639.742-3.468 1.105z'/>
                                        <path d='M5 8a1 1 0 1 1-2 0 1 1 0 0 1 2 0zm4 0a1 1 0 1 1-2 0 1 1 0 0 1 2 0zm4 0a1 1 0 1 1-2 0 1 1 0 0 1 2 0z'/>
                                    </svg>
                                ";
                                if ($is_answered == 'no') {
                                    echo $qu_content."
                                    </button>
                                    </a>";
                                }else {
                                    $sql = "Select * from answer where qu_id = $qu_id";
                                    mysqli_query($con, "set names 'utf8'");
                                    $result = mysqli_query($con,$sql);
                                    if ($result) {
                                        $num = mysqli_num_rows($result);
                                        echo    "查看回答
                                            </button>
                                            </a>
                                        </li>
                                        <li>
                                            <button id='click_like'>
                                                <svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='currentColor' class='bi bi-menu-up' viewBox='0 0 16 16'>
                                                    <path fill-rule='evenodd' d='M15 3.207v9a1 1 0 0 1-1 1h-3.586A2 2 0 0 0 9 13.793l-1 1-1-1a2 2 0 0 0-1.414-.586H2a1 1 0 0 1-1-1v-9a1 1 0 0 1 1-1h12a1 1 0 0 1 1 1zm-13 11a2 2 0 0 1-2-2v-9a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v9a2 2 0 0 1-2 2h-3.586a1 1 0 0 0-.707.293l-1.353 1.354a.5.5 0 0 1-.708 0L6.293 14.5a1 1 0 0 0-.707-.293H2z'/>
                                                    <path fill-rule='evenodd' d='M15 5.207H1v1h14v-1zm0 4H1v1h14v-1zm-13-5.5a.5.5 0 0 0 .5.5h6a.5.5 0 1 0 0-1h-6a.5.5 0 0 0-.5.5zm0 4a.5.5 0 0 0 .5.5h11a.5.5 0 0 0 0-1h-11a.5.5 0 0 0-.5.5zm0 4a.5.5 0 0 0 .5.5h8a.5.5 0 0 0 0-1h-8a.5.5 0 0 0-.5.5z'/>
                                                </svg>
                                                回答$num
                                            </button>
                                        </li>";
                                    }
                                }   
                                echo "<li>
                                <a href='../post.php?qu_id=$qu_id' target='_blank'>
                                    <button class='btn btn-outline-success'>
                                        
                                            <svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='currentColor' class='bi bi-cursor' viewBox='0 0 16 16'>
                                                <path fill-rule='evenodd' d='M14.082 2.182a.5.5 0 0 1 .103.557L8.528 15.467a.5.5 0 0 1-.917-.007L5.57 10.694.803 8.652a.5.5 0 0 1-.006-.916l12.728-5.657a.5.5 0 0 1 .556.103zM2.25 8.184l3.897 1.67a.5.5 0 0 1 .262.263l1.67 3.897L12.743 3.52 2.25 8.184z'/>
                                            </svg>
                                            我来回答
                                        
                                    </button>
                                    </a>
                                </li>
                            ";
                            if ($status == 1) {
                                ?>
                                    <li>
                                        <button class='btn btn-danger' id='delete_post'>
                                     删除问题
                                        </button>
                                    </li>
                                </ul>
                                <div style='clear:both'></div>
                                </div>
                            <?php
                            }else {
                                echo "
                                
                            </ul>
                                
                                <div style='clear:both'></div>
                                </div>";
                            }
                            }
                        ?>
                    </div>

                    <div class="tab-pane fade" id="wz">
                        <?php
                            $get_posts = "select * from posts where user_id = $user_id order by post_date DESC";
                            mysqli_query($con, "set names 'utf8'");
                            echo mysqli_error($con);
                            $run_posts = mysqli_query($con, $get_posts);
                            echo mysqli_error($con);
                            while ($row = mysqli_fetch_array($run_posts)){
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
                                    $post_content = mb_substr($post_content,0, 60)."..<a href='../post.php?post_id=$post_id' target='_blank'>查看全文</a>";
                                }
                        
                                $post_title = $row['post_title'];
                                $post_date = $row['post_date'];
                                $post_like = $row['post_like'];
                                $post_date = wordTime($post_date);
                                $post_view = $row['post_view'];
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
                                        <a id='name' href='../profile.php?u_id=$user_id' target='_blank'style='font-size:1.1em;'>
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
                                        ";           
                                            if ($status == 1) {
                                                echo "<li>
                                                <button class='btn btn-danger' id='delete_post'>
                                             删除文章
                                                </button>
                                            </li>";
                                            }else {
                                                echo "<li><a><button class='btn btn-outline-success'><svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='currentColor' class='bi bi-star' viewBox='0 0 16 16'><path fill-rule='evenodd' d='M2.866 14.85c-.078.444.36.791.746.593l4.39-2.256 4.389 2.256c.386.198.824-.149.746-.592l-.83-4.73 3.523-3.356c.329-.314.158-.888-.283-.95l-4.898-.696L8.465.792a.513.513 0 0 0-.927 0L5.354 5.12l-4.898.696c-.441.062-.612.636-.283.95l3.523 3.356-.83 4.73zm4.905-2.767l-3.686 1.894.694-3.957a.565.565 0 0 0-.163-.505L1.71 6.745l4.052-.576a.525.525 0 0 0 .393-.288l1.847-3.658 1.846 3.658a.525.525 0 0 0 .393.288l4.052.575-2.906 2.77a.564.564 0 0 0-.163.506l.694 3.957-3.686-1.894a.503.503 0 0 0-.461 0z'/></svg>收藏</button></a></li>";
                                            }                                
                                        echo    "</ul>
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
                                            <button id='post$post_id' name='$post_id'  class='btn btn-primary like_post'>
                                                <svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='currentColor' class='bi bi-heart-fill' viewBox='0 0 16 16'>
                                                <path fill-rule='evenodd' d='M8 1.314C12.438-3.248 23.534 4.735 8 15-7.534 4.736 3.562-3.248 8 1.314z'></path>
                                                </svg>
                                                <span id=$user_id>";
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
                        ?>
                    </div>

                    <div class="tab-pane fade" id="hd">

                    </div>

                    <div class="tab-pane fade" id="gz">
                        
                    </div>


                    <div class="tab-pane fade" id="fs">
                        
                    </div>

                    <div class="tab-pane fade" id="sc">
                        
                    </div>
                </div>
            </div>
        </div>  
    </div>
    <?php
        require('include/rightbar.php');
    ?>
</div>
</body>
<?php include_once("baidu_js_push.php") ?>
</html>
<?php
if ($status ==1) {
    echo "<script>
            document.getElementById('profileA').href = 'javascript:void(0);';
            var ele = document.getElementById('profileA');
            ele.style.color ='#198754';
            ele.onmouseover =  function () {
            this.style.backgroundColor = 'white';
            }
        </script>";
    }
?>

<?php
    if (isset($_GET['from'])) {
        if ($_GET['from'] == "login") {
            echo "<script>document.getElementById('sign').click()</script>";
        }
    }
?>
 
<script>
    $('.liked_post').click(function(){
        var clickBtnValue = $(this).attr("name"); 
        var userId = $(this).children('span').attr("id"); 
        var change = $(this).attr("id");
        $.ajax({
            type:"GET",
            url: "include/dislike.php", 
            dataType:"JSON",
            contentType:"application/json",
            async:true,
            data:{id:clickBtnValue,userid:userId},
            success: function(status){
                $('#'+change).css("color","white");
                $('#'+change).css("backgroundColor","#198754");
                buttonval = Number($('#'+change).val()) - 1
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
            url: "include/like.php", 
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