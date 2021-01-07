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
    }
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
    <link rel="icon" type="image/x-ico" href="img/logo.ico" />
    <link rel="apple-touch-icon" sizes="180x180" href="/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/favicon-16x16.png">
    <link rel="manifest" href="/site.webmanifest">

    <meta name="viewport" content="width=device-width, initial-scale=1">  
    <script src="https://cdn.staticfile.org/jquery/2.1.1/jquery.min.js"></script>
    <link rel="stylesheet" href="https://cdn.staticfile.org/twitter-bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://cdn.staticfile.org/twitter-bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <title><?php echo $user_name?> - willcloudy</title>
    <script src="ajax/function.js"></script>

    <link rel="stylesheet" href="css/css.css">
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
            <div id='follow_button'>
                <?php
                if ($status == 1) {
                    echo "<a href='edit.php'><button class='editProfile'>编辑个人资料</button></a>";
                }elseif($status == 2){
                    $check_follow = "Select * from follow where follower_id = '$u_id' and user_id = '$user_id'";
                    $run_check = mysqli_query($con, $check_follow);
                    echo mysqli_error($con);
                    if (mysqli_num_rows($run_check) == 0) {
                        echo "<a><button  onclick='follow(this)' id='$user_id' class='follow_btn'><span id='$u_id'>关注</span></button></a>";
                    }else {
                        echo "<a><button onclick='unfollow(this)'  id='$user_id' class='btn-danger followed_btn'><span id='$u_id'>取消关注</span></button></a>";
                    }
                }elseif($status == 0){
                    echo "<a data-toggle='modal' data-target='#myModal'><button class='follow_btn'>关注他</button></a>";
                }
                ?>
            </div>
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
                <ul id="myTab" class="nav nav-tabs ">
                    <li class="active"><a href="#tw" data-toggle="tab">提问</a></li>
                    <li><a href="#wz" data-toggle="tab">文章
                        <?php
                            $post_num = "SELECT * FROM posts where user_id = '$user_id' and type='post'";
                            $run_post_query = mysqli_query($con, $post_num);
                            echo mysqli_error($con);
                            $result_post = mysqli_num_rows($run_post_query);
                            if ($result_post == 0 or $result_post == null) {
                                echo "<span style='border-radius:20px;background-color:#CCCC99;padding:1px;color:white;font-size:0.7em;'>0</span>";
                            }else {
                                echo "<span style='border-radius:20px;background-color:#CCCC99;padding:1px;color:white;font-size:0.7em;'>$result_post</span>";
                            }
                        ?>
                    </a></li>
                    <li><a href="#hd"data-toggle="tab">回答
                        <?php
                            $answer_num = "SELECT * FROM posts where user_id = '$user_id' and type='answer'";
                            $run_answer_query = mysqli_query($con, $answer_num);
                            echo mysqli_error($con);
                            $result_answer = mysqli_num_rows($run_answer_query);
                            if ($result_answer == 0 or $result_answer == null) {
                                echo "<span style='border-radius:20px;background-color:#CCCC99;padding:1px;color:white;font-size:0.7em;'>0</span>";
                            }else {
                                echo "<span style='border-radius:20px;background-color:#CCCC99;padding:1px;color:white;font-size:0.7em;'>$result_answer</span>";
                            }
                        ?>
                    </a></li>
                    <li><a href="#gz" data-toggle="tab">关注</a></li>
                    <li><a href='#fs' data-toggle='tab'>粉丝
                        <?php
                            $follower_num = "SELECT * FROM follow where user_id = '$writer_id'";
                            $run_follower_query = mysqli_query($con, $follower_num);
                            echo mysqli_error($con);
                            $result_follow = mysqli_num_rows($run_follower_query);
                            echo "<span style='border-radius:20px;background-color:#CCCC99;padding:1px;color:white;font-size:0.7em;'>$result_follow</span>";
                        ?>
                    </a></li>
                    <li><a href='#sc' data-toggle='tab'>收藏</a></li>
                </ul>
                <div id="myTabContent" class="tab-content" style='min-height:100px;'>
                    <div class="tab-pane fade in active" id="tw" style='min-height:500px;'>
                        <?php
                            include('include/get_post.php');
                            $get_qu = "select * from question where user_id = $user_id order by qu_date DESC";
                            mysqli_query($con, "set names 'utf8'");

                            $run_qu = mysqli_query($con, $get_qu);
                            if (mysqli_num_rows($run_qu) == 0) {
                                echo "<h5 style='text-align:center;margin-top:50px;font-weight:bold'>这里没有问题..<a href='question.php' style='color:green'>点此看看其他人的问题吧</a></h5>";
                            }else {
                                while ($row = mysqli_fetch_array($run_qu)) {
                                    echo mysqli_error($con);
                                    $qu_id = $row['qu_id'];
                                    $question = $row['question'];
                                    $qu_date = $row['qu_date'];
                                    $user_id = $row['user_id'];
                                    $is_answered = $row['is_answered'];
                                    if ($is_answered == 'no') {
                                        $qu_content = "暂无回答";
                                    }else {
                                        $answer = "select * from posts where post_title = '$question'";
                                        echo mysqli_error($con);

                                        $run_answer = mysqli_query($con, $answer);
                                        $row_answer = mysqli_num_rows($run_answer);
                                        echo mysqli_error($con);
                                        $qu_content = $row_answer.'个回答';
                                    }
                                    $post_date = wordTime($qu_date);
                                    $writer = "select * from users where user_id = '$user_id'";
                                    echo mysqli_error($con);

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
                                        <div class='col-md-12' id='$qu_id' style='padding:10px;padding-bottom:5px;border-top: 1px solid #f0f2f7;'>
                                            <div style='width:100%'>
                                        
                                                <a id='image' href='profile.php?u_id=$user_id' target='_blank' style='font-size:1em;'>
                                                    <img src='$user_image' class='img-circle' style='width:30px;border:1px solid #CCCC99;'> 
                                                </a>
                                    
                                                <a id='name' href='profile.php?u_id=$user_id' target='_blank'style='rgb(91, 112, 131);font-size:1em;font-weight:bold'>
                                                    $user_name  :
                                                </a>

                                                <a href='post.php?qu_id=$qu_id' target='_blank'>
                                                    <b style='line-height:1.4;font-size:1.3em;'>
                                                        $question
                                                    </b>
                                                </a>
                                            
                                                $post_date
                                                <br>
                                            </div>
                                            <div style='clear:both'></div>
                                        </div>
                                        
                                        <ul id='$user_id' class='article-function'>

                                            <li>
                                                <a href='post.php?qu_id=$qu_id'>
                                                    <button class='btn btn-primary'>
                                                        <svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='currentColor' class='bi bi-chat-dots' viewBox='0 0 16 16'>
                                                        <path fill-rule='evenodd' d='M2.678 11.894a1 1 0 0 1 .287.801 10.97 10.97 0 0 1-.398 2c1.395-.323 2.247-.697 2.634-.893a1 1 0 0 1 .71-.074A8.06 8.06 0 0 0 8 14c3.996 0 7-2.807 7-6 0-3.192-3.004-6-7-6S1 4.808 1 8c0 1.468.617 2.83 1.678 3.894zm-.493 3.905a21.682 21.682 0 0 1-.713.129c-.2.032-.352-.176-.273-.362a9.68 9.68 0 0 0 .244-.637l.003-.01c.248-.72.45-1.548.524-2.319C.743 11.37 0 9.76 0 8c0-3.866 3.582-7 8-7s8 3.134 8 7-3.582 7-8 7a9.06 9.06 0 0 1-2.347-.306c-.52.263-1.639.742-3.468 1.105z'/>
                                                        <path d='M5 8a1 1 0 1 1-2 0 1 1 0 0 1 2 0zm4 0a1 1 0 1 1-2 0 1 1 0 0 1 2 0zm4 0a1 1 0 1 1-2 0 1 1 0 0 1 2 0z'/>
                                                        </svg>
                                                        $qu_content 
                                                    </button>
                                                </a>
                                            </li>

                                            
                                    ";
                                    if ($status == 0){
                                        echo "<li>
                                                    <a data-toggle='modal' data-target='#myModal'>
                                                        <button class='btn btn-outline-success'>
                                                            <svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='currentColor' class='bi bi-cursor' viewBox='0 0 16 16'>
                                                                <path fill-rule='evenodd' d='M14.082 2.182a.5.5 0 0 1 .103.557L8.528 15.467a.5.5 0 0 1-.917-.007L5.57 10.694.803 8.652a.5.5 0 0 1-.006-.916l12.728-5.657a.5.5 0 0 1 .556.103zM2.25 8.184l3.897 1.67a.5.5 0 0 1 .262.263l1.67 3.897L12.743 3.52 2.25 8.184z'/>
                                                            </svg>
                                                            我来回答
                                                        </button>
                                                    </a>
                                                </li>
                                            </ul>
                                        <div style='clear:both'></div>";
                                    }elseif ($status == 1) {
                                        echo "<li>
                                                <a href='editPost.php?qu_id=$qu_id' target='_blank'>
                                                    <button class='btn btn-danger'>
                                                        <svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='currentColor' class='bi bi-cursor' viewBox='0 0 16 16'>
                                                            <path fill-rule='evenodd' d='M14.082 2.182a.5.5 0 0 1 .103.557L8.528 15.467a.5.5 0 0 1-.917-.007L5.57 10.694.803 8.652a.5.5 0 0 1-.006-.916l12.728-5.657a.5.5 0 0 1 .556.103zM2.25 8.184l3.897 1.67a.5.5 0 0 1 .262.263l1.67 3.897L12.743 3.52 2.25 8.184z'/>
                                                        </svg>
                                                        编辑问题
                                                    </button>
                                                </a>
                                                </li>
                                            </ul>
                                        <div style='clear:both'></div>";
                                    }else {
                                        echo "<li>
                                                <a href='post.php?qu_id=$qu_id' target='_blank'>
                                                    <button class='btn btn-outline-success'>
                                                        <svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='currentColor' class='bi bi-cursor' viewBox='0 0 16 16'>
                                                            <path fill-rule='evenodd' d='M14.082 2.182a.5.5 0 0 1 .103.557L8.528 15.467a.5.5 0 0 1-.917-.007L5.57 10.694.803 8.652a.5.5 0 0 1-.006-.916l12.728-5.657a.5.5 0 0 1 .556.103zM2.25 8.184l3.897 1.67a.5.5 0 0 1 .262.263l1.67 3.897L12.743 3.52 2.25 8.184z'/>
                                                        </svg>
                                                        我来回答
                                                    </button>
                                                </a>
                                                </li>
                                            </ul>
                                        <div style='clear:both'></div>";
                                    }
                                }
                            }
                        ?>
                    </div>

                    <div class="tab-pane fade" id="wz" style='min-height:500px;'>
                        <?php
                            $get_posts = "select * from posts where user_id = '$user_id' and type='post' order by post_date DESC";
                            mysqli_query($con, "set names 'utf8'");
                        
                            echo mysqli_error($con);
                            $run_posts = mysqli_query($con, $get_posts);
                            if (mysqli_num_rows($run_posts) == 0) {
                                echo "<h5 style='text-align:center;margin-top:50px;font-weight:bold'>这里没有文章..<a href='home.php' style='color:green'>点此看看其他人都在看什么吧</a></h5>";
                            }else {
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
                                        $post_content = mb_substr($post_content,0, 40)."..<a href='../post.php?post_id=$post_id' class='view_more' target='_blank'>查看全文</a>";
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
                                    <div id='$post_id' class='col-md-12' style='padding:10px;padding-bottom:5px;border-top: 1px solid #f0f2f7;'>
                                        <div id='post-img'style='float:right;'>
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
                                                <img src='../$user_image' class='img-circle' style='width:20px;border:1px solid #CCCC99;'> 
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
                                    </div>
                                    <div id='post$post_id'>";
                                        if ($status== 1) {
                                            echo "
                                            <ul class='article-function' >
                                            <li><a href='../post.php?post_id=$post_id' target='_blank'><button class='btn btn-outline-success'><svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='currentColor' class='bi bi-chat-dots' viewBox='0 0 16 16'><path fill-rule='evenodd' d='M2.678 11.894a1 1 0 0 1 .287.801 10.97 10.97 0 0 1-.398 2c1.395-.323 2.247-.697 2.634-.893a1 1 0 0 1 .71-.074A8.06 8.06 0 0 0 8 14c3.996 0 7-2.807 7-6 0-3.192-3.004-6-7-6S1 4.808 1 8c0 1.468.617 2.83 1.678 3.894zm-.493 3.905a21.682 21.682 0 0 1-.713.129c-.2.032-.352-.176-.273-.362a9.68 9.68 0 0 0 .244-.637l.003-.01c.248-.72.45-1.548.524-2.319C.743 11.37 0 9.76 0 8c0-3.866 3.582-7 8-7s8 3.134 8 7-3.582 7-8 7a9.06 9.06 0 0 1-2.347-.306c-.52.263-1.639.742-3.468 1.105z'/><path d='M5 8a1 1 0 1 1-2 0 1 1 0 0 1 2 0zm4 0a1 1 0 1 1-2 0 1 1 0 0 1 2 0zm4 0a1 1 0 1 1-2 0 1 1 0 0 1 2 0z'/></svg>查看评论</button></a></li>
                                            <li>
                                                <button class='btn btn-danger' onclick='comfirm_post(this)' id = '$post_id'>
                                                    <span id='$user_id'>删除文章</span>
                                                </button>
                                            </li>       
                                            <li>
                                                <a href='editPost.php?post_id=$post_id' target='_blank'>
                                                    <button class='btn btn-danger'>
                                                        编辑文章
                                                    </button>
                                                </a>
                                            </li>
                                            </ul>        
                                            <div style='clear:both'></div>
                                            </div>";
                                        }elseif ($status == 2) {
                                            echo "
                                            <ul class='article-function'>
                                            <li><a href='../post.php?post_id=$post_id' target='_blank'><button class='btn btn-outline-success'><svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='currentColor' class='bi bi-chat-dots' viewBox='0 0 16 16'><path fill-rule='evenodd' d='M2.678 11.894a1 1 0 0 1 .287.801 10.97 10.97 0 0 1-.398 2c1.395-.323 2.247-.697 2.634-.893a1 1 0 0 1 .71-.074A8.06 8.06 0 0 0 8 14c3.996 0 7-2.807 7-6 0-3.192-3.004-6-7-6S1 4.808 1 8c0 1.468.617 2.83 1.678 3.894zm-.493 3.905a21.682 21.682 0 0 1-.713.129c-.2.032-.352-.176-.273-.362a9.68 9.68 0 0 0 .244-.637l.003-.01c.248-.72.45-1.548.524-2.319C.743 11.37 0 9.76 0 8c0-3.866 3.582-7 8-7s8 3.134 8 7-3.582 7-8 7a9.06 9.06 0 0 1-2.347-.306c-.52.263-1.639.742-3.468 1.105z'/><path d='M5 8a1 1 0 1 1-2 0 1 1 0 0 1 2 0zm4 0a1 1 0 1 1-2 0 1 1 0 0 1 2 0zm4 0a1 1 0 1 1-2 0 1 1 0 0 1 2 0z'/></svg>评论</button></a></li>
                                            <li><a><button onclick='shoucang(this)' id='$post_id' class='btn btn-outline-success'><svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='currentColor' class='bi bi-star' viewBox='0 0 16 16'><path fill-rule='evenodd' d='M2.866 14.85c-.078.444.36.791.746.593l4.39-2.256 4.389 2.256c.386.198.824-.149.746-.592l-.83-4.73 3.523-3.356c.329-.314.158-.888-.283-.95l-4.898-.696L8.465.792a.513.513 0 0 0-.927 0L5.354 5.12l-4.898.696c-.441.062-.612.636-.283.95l3.523 3.356-.83 4.73zm4.905-2.767l-3.686 1.894.694-3.957a.565.565 0 0 0-.163-.505L1.71 6.745l4.052-.576a.525.525 0 0 0 .393-.288l1.847-3.658 1.846 3.658a.525.525 0 0 0 .393.288l4.052.575-2.906 2.77a.564.564 0 0 0-.163.506l.694 3.957-3.686-1.894a.503.503 0 0 0-.461 0z'/></svg><span class='$u_id'>收藏</span></button></a></li>
                                            </ul>
                                            <div style='clear:both'></div>
                                    </div>
                                            ";
                                        }else {
                                            echo "
                                            <ul class='article-function'>
                                            <li><a data-toggle='modal' data-target='#myModal'><button class='btn btn-outline-success'><svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='currentColor' class='bi bi-chat-dots' viewBox='0 0 16 16'><path fill-rule='evenodd' d='M2.678 11.894a1 1 0 0 1 .287.801 10.97 10.97 0 0 1-.398 2c1.395-.323 2.247-.697 2.634-.893a1 1 0 0 1 .71-.074A8.06 8.06 0 0 0 8 14c3.996 0 7-2.807 7-6 0-3.192-3.004-6-7-6S1 4.808 1 8c0 1.468.617 2.83 1.678 3.894zm-.493 3.905a21.682 21.682 0 0 1-.713.129c-.2.032-.352-.176-.273-.362a9.68 9.68 0 0 0 .244-.637l.003-.01c.248-.72.45-1.548.524-2.319C.743 11.37 0 9.76 0 8c0-3.866 3.582-7 8-7s8 3.134 8 7-3.582 7-8 7a9.06 9.06 0 0 1-2.347-.306c-.52.263-1.639.742-3.468 1.105z'/><path d='M5 8a1 1 0 1 1-2 0 1 1 0 0 1 2 0zm4 0a1 1 0 1 1-2 0 1 1 0 0 1 2 0zm4 0a1 1 0 1 1-2 0 1 1 0 0 1 2 0z'/></svg>评论</button></a></li>
                                            
                                                <li>
                                                <a data-toggle='modal' data-target='#myModal'>
                                                <button class='btn btn-outline-success'><svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='currentColor' class='bi bi-star' viewBox='0 0 16 16'><path fill-rule='evenodd' d='M2.866 14.85c-.078.444.36.791.746.593l4.39-2.256 4.389 2.256c.386.198.824-.149.746-.592l-.83-4.73 3.523-3.356c.329-.314.158-.888-.283-.95l-4.898-.696L8.465.792a.513.513 0 0 0-.927 0L5.354 5.12l-4.898.696c-.441.062-.612.636-.283.95l3.523 3.356-.83 4.73zm4.905-2.767l-3.686 1.894.694-3.957a.565.565 0 0 0-.163-.505L1.71 6.745l4.052-.576a.525.525 0 0 0 .393-.288l1.847-3.658 1.846 3.658a.525.525 0 0 0 .393.288l4.052.575-2.906 2.77a.564.564 0 0 0-.163.506l.694 3.957-3.686-1.894a.503.503 0 0 0-.461 0z'/></svg><span class='$u_id'>收藏</span></button>
                                                </a>
                                            </li>
                                            </ul>
                                                <div style='clear:both'></div>
                                            </div>";
                                        }
                                }
                            }
                        ?>
                    </div>

                    <div class="tab-pane fade" id="hd" style='min-height:500px;'>
                        <?php
                            $get_answer = "select * from posts where user_id = $user_id and type='answer' order by post_date DESC";
                            mysqli_query($con, "set names 'utf8'");

                            $run_answer = mysqli_query($con, $get_answer);
                            if (mysqli_num_rows($run_answer) == 0) {
                                echo "<h5 style='text-align:center;margin-top:50px;font-weight:bold'>这里还没有回答..<a href='question.php' style='color:green'>点此看看其他人的回答吧</a></h5>";
                            }else {
                                while ($row = mysqli_fetch_array($run_answer)) {
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
                                        $post_content = mb_substr($post_content,0, 40)."..<a href='../post.php?post_id=$post_id' class='view_more' target='_blank'>查看全文</a>";
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
                                    <div id='$post_id' class='col-md-12' style='padding:10px;padding-bottom:5px;border-top: 1px solid #f0f2f7;'>
                                        <div id='post-img'style='float:right;'>
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
                                                <img src='../$user_image' class='img-circle' style='width:20px;border:1px solid #CCCC99;'> 
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
                                    </div>
                                    <div id='answer$post_id'>";
                                        if ($status== 1) {
                                            echo "
                                            <ul class='article-function' >
                                            <li><a href='../post.php?post_id=$post_id' target='_blank'><button class='btn btn-outline-success'><svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='currentColor' class='bi bi-chat-dots' viewBox='0 0 16 16'><path fill-rule='evenodd' d='M2.678 11.894a1 1 0 0 1 .287.801 10.97 10.97 0 0 1-.398 2c1.395-.323 2.247-.697 2.634-.893a1 1 0 0 1 .71-.074A8.06 8.06 0 0 0 8 14c3.996 0 7-2.807 7-6 0-3.192-3.004-6-7-6S1 4.808 1 8c0 1.468.617 2.83 1.678 3.894zm-.493 3.905a21.682 21.682 0 0 1-.713.129c-.2.032-.352-.176-.273-.362a9.68 9.68 0 0 0 .244-.637l.003-.01c.248-.72.45-1.548.524-2.319C.743 11.37 0 9.76 0 8c0-3.866 3.582-7 8-7s8 3.134 8 7-3.582 7-8 7a9.06 9.06 0 0 1-2.347-.306c-.52.263-1.639.742-3.468 1.105z'/><path d='M5 8a1 1 0 1 1-2 0 1 1 0 0 1 2 0zm4 0a1 1 0 1 1-2 0 1 1 0 0 1 2 0zm4 0a1 1 0 1 1-2 0 1 1 0 0 1 2 0z'/></svg>查看评论</button></a></li>
                                            <li>
                                                <button class='btn btn-danger' onclick='comfirm_answer(this)' id = '$post_id'>
                                                    <span id='$user_id'>删除文章</span>
                                                </button>
                                            </li>       
                                            <li>
                                                <a href='editPost.php?post_id=$post_id' target='_blank'>
                                                    <button class='btn btn-danger'>
                                                        编辑回答
                                                    </button>
                                                </a>
                                                </li>
                                            </ul>        
                                            <div style='clear:both'></div>
                                            </div>";
                                        }elseif ($status == 2) {
                                            echo "
                                            <ul class='article-function'>
                                            <li><a href='../post.php?post_id=$post_id' target='_blank'><button class='btn btn-outline-success'><svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='currentColor' class='bi bi-chat-dots' viewBox='0 0 16 16'><path fill-rule='evenodd' d='M2.678 11.894a1 1 0 0 1 .287.801 10.97 10.97 0 0 1-.398 2c1.395-.323 2.247-.697 2.634-.893a1 1 0 0 1 .71-.074A8.06 8.06 0 0 0 8 14c3.996 0 7-2.807 7-6 0-3.192-3.004-6-7-6S1 4.808 1 8c0 1.468.617 2.83 1.678 3.894zm-.493 3.905a21.682 21.682 0 0 1-.713.129c-.2.032-.352-.176-.273-.362a9.68 9.68 0 0 0 .244-.637l.003-.01c.248-.72.45-1.548.524-2.319C.743 11.37 0 9.76 0 8c0-3.866 3.582-7 8-7s8 3.134 8 7-3.582 7-8 7a9.06 9.06 0 0 1-2.347-.306c-.52.263-1.639.742-3.468 1.105z'/><path d='M5 8a1 1 0 1 1-2 0 1 1 0 0 1 2 0zm4 0a1 1 0 1 1-2 0 1 1 0 0 1 2 0zm4 0a1 1 0 1 1-2 0 1 1 0 0 1 2 0z'/></svg>评论</button></a></li>
                                            <li><a><button onclick='shoucang(this)' id='$post_id' class='btn btn-outline-success'><svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='currentColor' class='bi bi-star' viewBox='0 0 16 16'><path fill-rule='evenodd' d='M2.866 14.85c-.078.444.36.791.746.593l4.39-2.256 4.389 2.256c.386.198.824-.149.746-.592l-.83-4.73 3.523-3.356c.329-.314.158-.888-.283-.95l-4.898-.696L8.465.792a.513.513 0 0 0-.927 0L5.354 5.12l-4.898.696c-.441.062-.612.636-.283.95l3.523 3.356-.83 4.73zm4.905-2.767l-3.686 1.894.694-3.957a.565.565 0 0 0-.163-.505L1.71 6.745l4.052-.576a.525.525 0 0 0 .393-.288l1.847-3.658 1.846 3.658a.525.525 0 0 0 .393.288l4.052.575-2.906 2.77a.564.564 0 0 0-.163.506l.694 3.957-3.686-1.894a.503.503 0 0 0-.461 0z'/></svg><span class='$u_id'>收藏</span></button></a></li>
                                            </ul>
                                            <div style='clear:both'></div>
                                    </div>
                                            ";
                                        }else {
                                            echo "
                                            <ul class='article-function'>
                                            <li><a data-toggle='modal' data-target='#myModal'><button class='btn btn-outline-success'><svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='currentColor' class='bi bi-chat-dots' viewBox='0 0 16 16'><path fill-rule='evenodd' d='M2.678 11.894a1 1 0 0 1 .287.801 10.97 10.97 0 0 1-.398 2c1.395-.323 2.247-.697 2.634-.893a1 1 0 0 1 .71-.074A8.06 8.06 0 0 0 8 14c3.996 0 7-2.807 7-6 0-3.192-3.004-6-7-6S1 4.808 1 8c0 1.468.617 2.83 1.678 3.894zm-.493 3.905a21.682 21.682 0 0 1-.713.129c-.2.032-.352-.176-.273-.362a9.68 9.68 0 0 0 .244-.637l.003-.01c.248-.72.45-1.548.524-2.319C.743 11.37 0 9.76 0 8c0-3.866 3.582-7 8-7s8 3.134 8 7-3.582 7-8 7a9.06 9.06 0 0 1-2.347-.306c-.52.263-1.639.742-3.468 1.105z'/><path d='M5 8a1 1 0 1 1-2 0 1 1 0 0 1 2 0zm4 0a1 1 0 1 1-2 0 1 1 0 0 1 2 0zm4 0a1 1 0 1 1-2 0 1 1 0 0 1 2 0z'/></svg>评论</button></a></li>
                                            
                                                <li>
                                                <a data-toggle='modal' data-target='#myModal'>
                                                <button class='btn btn-outline-success'><svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='currentColor' class='bi bi-star' viewBox='0 0 16 16'><path fill-rule='evenodd' d='M2.866 14.85c-.078.444.36.791.746.593l4.39-2.256 4.389 2.256c.386.198.824-.149.746-.592l-.83-4.73 3.523-3.356c.329-.314.158-.888-.283-.95l-4.898-.696L8.465.792a.513.513 0 0 0-.927 0L5.354 5.12l-4.898.696c-.441.062-.612.636-.283.95l3.523 3.356-.83 4.73zm4.905-2.767l-3.686 1.894.694-3.957a.565.565 0 0 0-.163-.505L1.71 6.745l4.052-.576a.525.525 0 0 0 .393-.288l1.847-3.658 1.846 3.658a.525.525 0 0 0 .393.288l4.052.575-2.906 2.77a.564.564 0 0 0-.163.506l.694 3.957-3.686-1.894a.503.503 0 0 0-.461 0z'/></svg><span class='$u_id'>收藏</span></button>
                                                </a>
                                            </li>
                                            </ul>
                                                <div style='clear:both'></div>
                                            </div>";
                                        }
                                }
                            }
                        ?>
                    </div>

                    <div class="tab-pane fade" id="gz" style='min-height:500px;'>
                        <?php
                            $follow_select = "SELECT * FROM `follow` WHERE `follower_id` = '$user_id'";
                            $run_follow = mysqli_query($con, $follow_select);

                            if (mysqli_num_rows($run_follow) < 1 ){
                                echo "<h5 style='text-align:center;margin-top:50px;font-weight:bold'>没有关注其他人..<a href='question.php' style='color:green'>点此看看其他人吧</a></h5>";
                            }elseif((mysqli_num_rows($run_follow) >= 1 )) {
                                while ($row_follow = mysqli_fetch_array($run_follow)) {
                                    $user_id = $row_follow['user_id'];
                                    $yh_select = "SELECT * FROM `users` WHERE `user_id` = '$user_id'";
                                    $run_yh = mysqli_query($con, $yh_select);
                                    
                                    echo mysqli_error($con);
                                    if (mysqli_num_rows($run_yh) < 1 ){
                                        echo "<h5 style='text-align:center;margin-top:50px;font-weight:bold'>没有关注其他人..<a href='question.php' style='color:green'>点此看看其他人吧</a></h5>";
                                    }elseif((mysqli_num_rows($run_yh) >= 1 )) {
                                            while ($row = mysqli_fetch_array($run_yh)) {
                                                $user_id = $row['user_id'];
                                                $user_name = $row['user_name'];
                                                $user_des = $row['user_des'];
                                                $user_image = $row['user_image'];
                                                $user_cover = $row['user_cover'];
                                                echo "
                                                <div class='col-md-12 user-info' style='padding:10px;border-bottom: 1px solid #f0f2f7;'>
                                                    <div style='float:left;margin-left:20px;'>
                                                        <a id='image' href='profile.php?u_id=$user_id' target='_blank'><span><img class='img-circle'src='$user_image' width='60px;border:1px solid #CCCC99;'></span></a>
                                                    </div>
                                                    <div style='float:left;margin-left:30px;margin-top:15px;'>
                                                        <a href='profile.php?u_id=$user_id' target='_blank'>
                                                            <b style='line-height:1.4;font-size:1.3em;color:black;'>
                                                                $user_name
                                                            </b>
                                                        </a>
                                                    </div>
                                                    <br>
                                                    <br>
                                                    <span style='margin-left:30px;margin-top:15px;'>
                                                        <small>$user_des</small>
                                                    </span>
                                                    <div style='clear:both'></div>
                                                </div>";
                                            }
                                    }
                                }
                            }
                        ?>
                    </div>


                    <div class="tab-pane fade" id="fs" style='min-height:500px;'>
                        <?php
                            $get_id = $_GET['u_id'];   
                            $follower_select = "SELECT * FROM `follow` WHERE `user_id` = '$get_id'";
                            $run_follower_select = mysqli_query($con, $follower_select);
                            if (mysqli_num_rows($run_follower_select) == 0 ){
                                echo "<h5 style='text-align:center;margin-top:50px;font-weight:bold'>没有粉丝..<a href='question.php' style='color:green'>点此看看其他人吧</a></h5>";
                            }elseif((mysqli_num_rows($run_follower_select) >= 1 )) {
                                while ($row_follower = mysqli_fetch_array($run_follower_select)) {
                                    $s_follower_id = $row_follower['follower_id'];
                                    if ($s_follower_id == $user_id) {
                                        continue;
                                    }
                                    $yh_select = "SELECT * FROM `users` WHERE `user_id` = '$s_follower_id'";
                                    $run_yh = mysqli_query($con, $yh_select);
                                    
                                    echo mysqli_error($con);
                                    if (mysqli_num_rows($run_yh) < 1 ){
                                        echo "<h5 style='text-align:center;margin-top:50px;font-weight:bold'>没有此用户</h5>";
                                    }elseif((mysqli_num_rows($run_yh) >= 1 )) {
                                            while ($row_user_follower = mysqli_fetch_array($run_yh)) {
                                                $user_id = $row_user_follower['user_id'];
                                                $user_name = $row_user_follower['user_name'];
                                                $user_des = $row_user_follower['user_des'];
                                                $user_image = $row_user_follower['user_image'];
                                                $user_cover = $row['user_cover'];
                                                echo "
                                                <div class='col-md-12 user-info' style='padding:10px;border-bottom: 1px solid #f0f2f7;'>
                                                    <div style='float:left;margin-left:20px;'>
                                                        <a id='image' href='profile.php?u_id=$user_id' target='_blank'><span><img class='img-circle'src='$user_image' width='60px;border:1px solid #CCCC99;'></span></a>
                                                    </div>
                                                    <div style='float:left;margin-left:30px;margin-top:15px;'>
                                                        <a href='profile.php?u_id=$user_id' target='_blank'>
                                                            <b style='line-height:1.4;font-size:1.3em;color:black;'>
                                                                $user_name
                                                            </b>
                                                        </a>
                                                    </div>
                                                    <br>
                                                    <br>
                                                    <span style='margin-left:30px;margin-top:15px;'>
                                                        <small>$user_des</small>
                                                    </span>
                                                    <div style='clear:both'></div>
                                                </div>";
                                            }
                                    }
                                }
                            }
                        ?>
                    </div>

                    <div class="tab-pane fade" id="sc">
                        <div class="container-fluid" style='min-height:500px;'>
                            <div class="accordion" id="accordion2">
                                <div class="accordion-group">
                                    <div class="accordion-heading">
                                        <a style='display:block' class="accordion-toggle" data-toggle="collapse" data-parent="#accordion2" href="#collapseOne">
                                            <div class='shou_list'>
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-file-text-fill" viewBox="0 0 16 16">
                                            <path fill-rule="evenodd" d="M12 0H4a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2zM5 4a.5.5 0 0 0 0 1h6a.5.5 0 0 0 0-1H5zm-.5 2.5A.5.5 0 0 1 5 6h6a.5.5 0 0 1 0 1H5a.5.5 0 0 1-.5-.5zM5 8a.5.5 0 0 0 0 1h6a.5.5 0 0 0 0-1H5zm0 2a.5.5 0 0 0 0 1h3a.5.5 0 0 0 0-1H5z"/>
                                            </svg>    
                                            文章
                                            <?php                                 
                                                $us_u_id = $_GET['$user_id'];
                                                $get_shou = "select * from shoucang where user_id = '$us_u_id' and type='post' order by date DESC";
                                                $run_shou = mysqli_query($con, $get_shou);
                                                echo mysqli_error($con);
                                                echo mysqli_num_rows($run_shou);
                                            ?>
                                            </div>
                                            <hr style='margin-bottom:0;'>
                                        </a>
                                    </div>
                                    <div id="collapseOne" class="accordion-body collapse" style="height:100%; ">
                                        <div class="accordion-inner" >
                                        <?php
                                            if (mysqli_num_rows($run_shou) == 0) {
                                                echo "<h5 style='text-align:center;margin:50px;font-weight:bold'>还没有收藏..<a href='home.php' style='color:green'>点此看看其他人的文章吧</a></h5>";
                                            }else {
                                                while ($row = mysqli_fetch_array($run_shou)) {
                                                    $post_id = $row['post_id'];

                                                    $get_shou_posts = "select * from posts where post_id = $post_id";
                                                    echo mysqli_error($con);

                                                    $run_shou_posts = mysqli_query($con, $get_shou_posts);
                                                    echo mysqli_error($con);
                                                    if (mysqli_num_rows($run_shou_posts) == 0) {
                                                        if ($status == 1) {
                                                            echo "
                                                            <div id='shou_post$post_id'class='col-md-12' style='padding:10px;padding-bottom:5px;border-bottom:1px solid #f0f2f7'>
                                                                <div style='width:100%;'>
                                                                    <a>
                                                                        <b style='line-height:4.5;font-size:1.1em;'>
                                                                            此文章已被作者删除
                                                                        </b>
                                                                    </a>
                                                                    <button class='btn btn-danger' style='font-size:2px;' onclick='comfirm_del_shou_post(this)' id ='$post_id'>
                                                                        <span id='$u_id'>删除记录</span>
                                                                    </button>   
                                                                </div>
                                                                <div style='clear:both'></div>
                                                            </div>";
                                                        }elseif ($status == 2 or $status == 0) {
                                                            echo "
                                                            <div class='col-md-12' style='padding:10px;padding-bottom:5px;border-bottom:1px solid #f0f2f7'>
                                                                <div style='width:100%;text-align:center;'>
                                                                    <a>
                                                                        <b style='line-height:4.5;font-size:1.1em;'>
                                                                            此文章已被作者删除
                                                                        </b>
                                                                    </a>
                                                                    
                                                                </div>
                                                                <div style='clear:both'></div>
                                                            </div>";
                                                        }
                                                        
                                                    } else {
                                                        $row_shou = mysqli_fetch_array($run_shou_posts);
                                                        $post_content = $row_shou['post_content'];

                                                        if(preg_match('/<\s*img\s+[^>]*?src\s*=\s*(\'|\")(.*?)\\1[^>]*?\/?\s*>/i',$post_content,$match)){
                                                            $post_img = $match[0];
                                                        }else {
                                                            $post_img = null;
                                                        }
                                                        $post_content = strip_tags($post_content);
                                                        if (strlen($post_content) > 50) {
                                                            $post_content = mb_substr($post_content,0, 40)."..<a href='../post.php?post_id=$post_id' class='view_more' target='_blank'>查看全文</a>";
                                                        }
                                                        $post_title = $row_shou['post_title'];
                                                        $post_date = $row_shou['post_date'];
                                                        $user_id = $row_shou['user_id'];
                                                        $post_like = $row_shou['post_like'];
                                                        $post_view = $row_shou['post_view'];
                                                        $post_date = wordTime($post_date);
                                                        $writer = "select * from users where user_id = '$user_id' AND posts ='yes'";
                                                        mysqli_query($con, "set names 'utf8'");
                                                        $run_writer = mysqli_query($con, $writer);
                                                        $row_writer = mysqli_fetch_array($run_writer);
                                                
                                                
                                                        $user_name = $row_writer['user_name'];
                                                        $user_image = $row_writer['user_image'];

                                                        echo "
                                                            <div id='shou_post$post_id' class='col-md-12' style='padding:10px;padding-bottom:5px;'>
                                                                <div id='post-img'style='float:right;'>
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
                                                            </div>
                                                            <div id='shou_post_li$post_id' style='border-bottom: 1px solid #f0f2f7;'>";
                                                                if ($status== 1) {
                                                                    echo "
                                                                    <ul class='article-function' >
                                                                    <li><a href='../post.php?post_id=$post_id' target='_blank'><button class='btn btn-outline-success'><svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='currentColor' class='bi bi-chat-dots' viewBox='0 0 16 16'><path fill-rule='evenodd' d='M2.678 11.894a1 1 0 0 1 .287.801 10.97 10.97 0 0 1-.398 2c1.395-.323 2.247-.697 2.634-.893a1 1 0 0 1 .71-.074A8.06 8.06 0 0 0 8 14c3.996 0 7-2.807 7-6 0-3.192-3.004-6-7-6S1 4.808 1 8c0 1.468.617 2.83 1.678 3.894zm-.493 3.905a21.682 21.682 0 0 1-.713.129c-.2.032-.352-.176-.273-.362a9.68 9.68 0 0 0 .244-.637l.003-.01c.248-.72.45-1.548.524-2.319C.743 11.37 0 9.76 0 8c0-3.866 3.582-7 8-7s8 3.134 8 7-3.582 7-8 7a9.06 9.06 0 0 1-2.347-.306c-.52.263-1.639.742-3.468 1.105z'/><path d='M5 8a1 1 0 1 1-2 0 1 1 0 0 1 2 0zm4 0a1 1 0 1 1-2 0 1 1 0 0 1 2 0zm4 0a1 1 0 1 1-2 0 1 1 0 0 1 2 0z'/></svg>查看评论</button></a></li>
                                                                    <li>
                                                                        <button class='btn btn-danger' onclick='comfirm_del_shou_post(this)' id = '$post_id'>
                                                                            <span id='$u_id'>删除收藏</span>
                                                                        </button>
                                                                    </li>     
                                                                    </ul>        
                                                                    <div style='clear:both'></div>
                                                                    </div>";
                                                                }elseif ($status == 2) {
                                                                    echo "
                                                                        <ul class='article-function'>
                                                                            <li><a href='../post.php?post_id=$post_id' target='_blank'><button class='btn btn-outline-success'><svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='currentColor' class='bi bi-chat-dots' viewBox='0 0 16 16'><path fill-rule='evenodd' d='M2.678 11.894a1 1 0 0 1 .287.801 10.97 10.97 0 0 1-.398 2c1.395-.323 2.247-.697 2.634-.893a1 1 0 0 1 .71-.074A8.06 8.06 0 0 0 8 14c3.996 0 7-2.807 7-6 0-3.192-3.004-6-7-6S1 4.808 1 8c0 1.468.617 2.83 1.678 3.894zm-.493 3.905a21.682 21.682 0 0 1-.713.129c-.2.032-.352-.176-.273-.362a9.68 9.68 0 0 0 .244-.637l.003-.01c.248-.72.45-1.548.524-2.319C.743 11.37 0 9.76 0 8c0-3.866 3.582-7 8-7s8 3.134 8 7-3.582 7-8 7a9.06 9.06 0 0 1-2.347-.306c-.52.263-1.639.742-3.468 1.105z'/><path d='M5 8a1 1 0 1 1-2 0 1 1 0 0 1 2 0zm4 0a1 1 0 1 1-2 0 1 1 0 0 1 2 0zm4 0a1 1 0 1 1-2 0 1 1 0 0 1 2 0z'/></svg>查看文章</button></a></li>
                                                                            <li><a><button onclick='shoucang(this)' id='$post_id' class='btn btn-outline-success'><svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='currentColor' class='bi bi-star' viewBox='0 0 16 16'><path fill-rule='evenodd' d='M2.866 14.85c-.078.444.36.791.746.593l4.39-2.256 4.389 2.256c.386.198.824-.149.746-.592l-.83-4.73 3.523-3.356c.329-.314.158-.888-.283-.95l-4.898-.696L8.465.792a.513.513 0 0 0-.927 0L5.354 5.12l-4.898.696c-.441.062-.612.636-.283.95l3.523 3.356-.83 4.73zm4.905-2.767l-3.686 1.894.694-3.957a.565.565 0 0 0-.163-.505L1.71 6.745l4.052-.576a.525.525 0 0 0 .393-.288l1.847-3.658 1.846 3.658a.525.525 0 0 0 .393.288l4.052.575-2.906 2.77a.564.564 0 0 0-.163.506l.694 3.957-3.686-1.894a.503.503 0 0 0-.461 0z'/></svg><span class='$u_id'>收藏</span></button></a></li>
                                                                        </ul>
                                                                        <div style='clear:both'></div>
                                                                        </div>
                                                                    ";
                                                                }else {
                                                                    echo "
                                                                    <ul class='article-function'style='border-bottom: 1px solid #f0f2f7;'>
                                                                    
                                                                    <li><a data-toggle='modal' data-target='#myModal'><button class='btn btn-outline-success'><svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='currentColor' class='bi bi-chat-dots' viewBox='0 0 16 16'><path fill-rule='evenodd' d='M2.678 11.894a1 1 0 0 1 .287.801 10.97 10.97 0 0 1-.398 2c1.395-.323 2.247-.697 2.634-.893a1 1 0 0 1 .71-.074A8.06 8.06 0 0 0 8 14c3.996 0 7-2.807 7-6 0-3.192-3.004-6-7-6S1 4.808 1 8c0 1.468.617 2.83 1.678 3.894zm-.493 3.905a21.682 21.682 0 0 1-.713.129c-.2.032-.352-.176-.273-.362a9.68 9.68 0 0 0 .244-.637l.003-.01c.248-.72.45-1.548.524-2.319C.743 11.37 0 9.76 0 8c0-3.866 3.582-7 8-7s8 3.134 8 7-3.582 7-8 7a9.06 9.06 0 0 1-2.347-.306c-.52.263-1.639.742-3.468 1.105z'/><path d='M5 8a1 1 0 1 1-2 0 1 1 0 0 1 2 0zm4 0a1 1 0 1 1-2 0 1 1 0 0 1 2 0zm4 0a1 1 0 1 1-2 0 1 1 0 0 1 2 0z'/></svg>评论</button></a></li>
                                                                    
                                                                        <li>
                                                                        <a data-toggle='modal' data-target='#myModal'>
                                                                        <button class='btn btn-outline-success'><svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='currentColor' class='bi bi-star' viewBox='0 0 16 16'><path fill-rule='evenodd' d='M2.866 14.85c-.078.444.36.791.746.593l4.39-2.256 4.389 2.256c.386.198.824-.149.746-.592l-.83-4.73 3.523-3.356c.329-.314.158-.888-.283-.95l-4.898-.696L8.465.792a.513.513 0 0 0-.927 0L5.354 5.12l-4.898.696c-.441.062-.612.636-.283.95l3.523 3.356-.83 4.73zm4.905-2.767l-3.686 1.894.694-3.957a.565.565 0 0 0-.163-.505L1.71 6.745l4.052-.576a.525.525 0 0 0 .393-.288l1.847-3.658 1.846 3.658a.525.525 0 0 0 .393.288l4.052.575-2.906 2.77a.564.564 0 0 0-.163.506l.694 3.957-3.686-1.894a.503.503 0 0 0-.461 0z'/></svg><span class='$u_id'>收藏</span></button>
                                                                        </a>
                                                                    </li>
                                                                    </ul>
                                                                        <div style='clear:both'></div>
                                                                    </div>";
                                                                }
                                                    }
                                                }
                                            }
                                        ?>
                                        </div>
                                    </div>
                                </div>
                                <div class="accordion-group">
                                    <div class="accordion-heading" >
                                        <a style='display:block'class="accordion-toggle" data-toggle="collapse" data-parent="#accordion2" href="#collapseTwo">
                                            <div class='shou_list'>
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-file-text-fill" viewBox="0 0 16 16">
                                            <path fill-rule="evenodd" d="M12 0H4a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2zM5 4a.5.5 0 0 0 0 1h6a.5.5 0 0 0 0-1H5zm-.5 2.5A.5.5 0 0 1 5 6h6a.5.5 0 0 1 0 1H5a.5.5 0 0 1-.5-.5zM5 8a.5.5 0 0 0 0 1h6a.5.5 0 0 0 0-1H5zm0 2a.5.5 0 0 0 0 1h3a.5.5 0 0 0 0-1H5z"/>
                                            </svg>
                                            问题
                                            <?php
                                                $us_u_id = $_GET['$user_id'];
                                                echo $us_u_id;
                                                $get_shou_qu = "select * from shoucang where user_id = '$us_u_id' and type='question' order by date DESC";
                                                $run_shou_qu = mysqli_query($con, $get_shou_qu);
                                                echo mysqli_num_rows($run_shou_qu);
                                            ?>
                                            </div>
                                            <hr>
                                        </a>
                                    </div>
                                    <div id="collapseTwo" class="accordion-body collapse" >
                                        <div class="accordion-inner">
                                        <?php
                                            if (mysqli_num_rows($run_shou_qu) == 0) {
                                                echo "<h5 style='text-align:center;margin:50px;font-weight:bold'>还没有收藏..<a href='home.php' style='color:green'>点此看看其他人的文章吧</a></h5>";
                                            }else {
                                                while ($row_qu = mysqli_fetch_array($run_shou_qu)) {

                                                    $qu_id = $row_qu['post_id'];

                                                    $get_shou_qu = "select * from question where qu_id = '$qu_id'";
                                                    echo mysqli_error($con);
                                                    $run_shou_qu = mysqli_query($con, $get_shou_qu);
                                                    
                                                    $row_shou_qu = mysqli_fetch_array($run_shou_qu);
                                                    $qu_id = $row_shou_qu['qu_id'];
                                                    $question = $row_shou_qu['question'];
                                                    $qu_date = $row_shou_qu['qu_date'];
                                                    $user_id = $row_shou_qu['user_id'];
                                                    $is_answered = $row_shou_qu['is_answered'];
                                                    if ($is_answered == 'no') {
                                                        $qu_content = "暂无回答";
                                                    }else {
                                                        $answer = "select * from posts where post_title = '$question'";
                                                        echo mysqli_error($con);

                                                        $run_answer = mysqli_query($con, $answer);
                                                        $row_answer = mysqli_num_rows($run_answer);
                                                        echo mysqli_error($con);
                                                        $qu_content = $row_answer.'个回答';
                                                    }
                                                    $post_date = wordTime($qu_date);
                                                    $writer = "select * from users where user_id = '$user_id'";
                                                    echo mysqli_error($con);

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
                                                            <div class='col-md-12' id='shou_qu$qu_id' style='padding:10px;padding-bottom:5px;'>
                                                                <div style='width:100%'>
                                                            
                                                                    <a id='image' href='profile.php?u_id=$user_id' target='_blank' style='font-size:1em;'>
                                                                        <img src='$user_image' class='img-circle' style='width:30px;border:1px solid #CCCC99;'> 
                                                                    </a>
                                                        
                                                                    <a id='name' href='profile.php?u_id=$user_id' target='_blank'style='rgb(91, 112, 131);font-size:1em;font-weight:bold'>
                                                                        $user_name  :
                                                                    </a>

                                                                    <a href='post.php?qu_id=$qu_id' target='_blank'>
                                                                        <b style='line-height:1.4;font-size:1.3em;'>
                                                                            $question
                                                                        </b>
                                                                    </a>
                                                                
                                                                    $post_date
                                                                    <br>
                                                                </div>
                                                                <div style='clear:both'></div>
                                                            </div>
                                                            
                                                            <ul id='shou_qu_li$qu_id'class='article-function'>

                                                                <li>
                                                                    <a href='post.php?qu_id=$qu_id'>
                                                                        <button class='btn btn-primary'>
                                                                            <svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='currentColor' class='bi bi-chat-dots' viewBox='0 0 16 16'>
                                                                            <path fill-rule='evenodd' d='M2.678 11.894a1 1 0 0 1 .287.801 10.97 10.97 0 0 1-.398 2c1.395-.323 2.247-.697 2.634-.893a1 1 0 0 1 .71-.074A8.06 8.06 0 0 0 8 14c3.996 0 7-2.807 7-6 0-3.192-3.004-6-7-6S1 4.808 1 8c0 1.468.617 2.83 1.678 3.894zm-.493 3.905a21.682 21.682 0 0 1-.713.129c-.2.032-.352-.176-.273-.362a9.68 9.68 0 0 0 .244-.637l.003-.01c.248-.72.45-1.548.524-2.319C.743 11.37 0 9.76 0 8c0-3.866 3.582-7 8-7s8 3.134 8 7-3.582 7-8 7a9.06 9.06 0 0 1-2.347-.306c-.52.263-1.639.742-3.468 1.105z'/>
                                                                            <path d='M5 8a1 1 0 1 1-2 0 1 1 0 0 1 2 0zm4 0a1 1 0 1 1-2 0 1 1 0 0 1 2 0zm4 0a1 1 0 1 1-2 0 1 1 0 0 1 2 0z'/>
                                                                            </svg>
                                                                            $qu_content 
                                                                        </button>
                                                                    </a>
                                                                </li>

                                                                <li>
                                                                    <a href='post.php?qu_id=$qu_id' target='_blank'>
                                                                        <button class='btn btn-outline-success'>
                                                                            <svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='currentColor' class='bi bi-cursor' viewBox='0 0 16 16'>
                                                                                <path fill-rule='evenodd' d='M14.082 2.182a.5.5 0 0 1 .103.557L8.528 15.467a.5.5 0 0 1-.917-.007L5.57 10.694.803 8.652a.5.5 0 0 1-.006-.916l12.728-5.657a.5.5 0 0 1 .556.103zM2.25 8.184l3.897 1.67a.5.5 0 0 1 .262.263l1.67 3.897L12.743 3.52 2.25 8.184z'/>
                                                                            </svg>
                                                                            我来回答
                                                                        </button>
                                                                    </a>
                                                                </li>"; 
                                                    if ($status == 1) {
                                                        echo "
                                                        <li>
                                                            <button class='btn btn-danger' onclick='comfirm_del_shou_qu(this)' id = '$qu_id'>
                                                                <span id='$u_id'>删除收藏</span>
                                                            </button>
                                                        </li>  
                                                        ";
                                                        echo "</ul>
                                                        <div style='clear:both'></div>
                                                        <hr style='margin:5px;'>";
                                                    }else {
                                                        echo "</ul>
                                                        <div style='clear:both'></div>
                                                        <hr style='margin:5px;'>";
                                                    } 
                                                }
                                            }
                                            
                                        ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
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
    

</script>