<?php
    session_start();
    include('include/connection.php');
    function wordTime($time) {
        $Stime = strtotime($time);
        $int = time() - (int)$Stime;
        $str = '';
        if ($int <= 2){
        $str = sprintf('刚刚', $int);
        }elseif ($int < 60){
        $str = sprintf('%d秒前', $int);
        }elseif ($int < 3600){
        $str = sprintf('%d分钟前', floor($int / 60));
        }elseif ($int < 86400){
        $str = sprintf('%d小时前', floor($int / 3600));
        }elseif ($int < 2592000){
        $str = sprintf('%d天前', floor($int / 86400));
        }else{
        $str = $time;
        }
        return $str;
    }
    if (isset($_SESSION['user_email'])) {
        $user = $_SESSION['user_email'];
        $get_user = "select * from users where user_email = '$user'";
        mysqli_query($con, "set names 'utf8'");
        $run_user = mysqli_query($con, $get_user);
        $row = mysqli_fetch_array($run_user);
        $u_name = $row['user_name'];
        $u_image = $row['user_image'];
        $u_id = $row['user_id'];
        $login = 1;
    }else {
        $login=0;
    }
    if (isset($_GET['post_id'])) {
        $get_id = $_GET['post_id'];

        $get_posts = "select * from posts where post_id='$get_id'";
        mysqli_query($con, "set names 'utf8'");

        $run_posts = mysqli_query($con, $get_posts);
        
        $row_posts = mysqli_fetch_array($run_posts);

        $post_id = $row_posts['post_id'];
        $user_id = $row_posts['user_id'];
        $writer_id = $row_posts['user_id'];
        $content = $row_posts['post_content'];
        if (empty($row_posts['post_content'])) {
            echo "<script>alert('文章已删除')</script>";
            echo "<script>window.open('home.php','_self')</script>";
        }else {
        $title = $row_posts['post_title'];
        $post_date = $row_posts['post_date'];
        $keyword = $row_posts['post_title'];
        $post_view = $row_posts['post_view'];
        $post_like = $row_posts['post_like'];
        $writer = "select * from users where user_id = '$user_id' AND posts ='yes'";
        mysqli_query($con, "set names 'utf8'");

        $run_writer = mysqli_query($con, $writer);
        $row_writer = mysqli_fetch_array($run_writer);
        $writer_name = $row_writer['user_name'];
        $user_image =$row_writer['user_image'];
        $user_des = $row_writer['user_des'];
        $post_date = wordTime($post_date);
        $post_type = $row_posts['type'];
        if ($post_type == 'answer') {

            $get_question = "select * from question where question='$title'";

            $run_question = mysqli_query($con, $get_question);
            echo mysqli_error($con);

            $row_question = mysqli_fetch_array($run_question);

            $qu_id = $row_question['qu_id'];
            $answer_link = "<a href='post.php?qu_id=$qu_id' style='color:white;'>回答</a>";
        }else{
            $answer_link = "<a style='color:white;'>文章</a>";
        }
        $type='post';
        $cookieVistor = "visittimeforpost".$post_id;
        if(empty($_COOKIE[$cookieVistor])){
            $updated_view = $post_view + 1;
            setcookie($cookieVistor,date("y-m-d H:i:s"));

            $posted_view = "UPDATE `posts` SET `post_view` = $updated_view WHERE post_id = $post_id";

            $update_view1 = mysqli_query($con,$posted_view);

            echo mysqli_error($con);
        }
    }
    }elseif (isset($_GET['qu_id'])) {
        $get_id = $_GET['qu_id'];

        $get_question = "select * from question where qu_id='$get_id'";
        mysqli_query($con, "set names 'utf8'");

        $run_question = mysqli_query($con, $get_question);

        $row_question = mysqli_fetch_array($run_question);

        $user_id = $row_question['user_id'];
        $question = $row_question['question'];
        $keyword = $row_question['question'];
        
        $qu_des = $row_question['qu_des'];
        mysqli_query($con, "set names 'utf8'");

        $post_date = $row_question['qu_date'];
        $question_view = $row_question['qu_view'];
    
        $post_date = date('Y-m-d',strtotime($post_date));

        $writer = "select * from users where user_id = '$user_id'";
        mysqli_query($con, "set names 'utf8'");

        $run_writer = mysqli_query($con, $writer);
        $row_writer = mysqli_fetch_array($run_writer);
        $user_name = $row_writer['user_name'];
        $user_image =$row_writer['user_image'];
        $user_des = $row_writer['user_des'];
        $post_date = wordTime($post_date);
        $type='question';
        $updated_view = $question_view + 1;

        $cookieVistorqu = "visittimeforquestion".$get_id;
        if(empty($_COOKIE[$cookieVistorqu])){ 
            setcookie($cookieVistorqu,date("y-m-d H:i:s"));
            setcookie("visitcount",1);
            $updated_view = "UPDATE `question` SET `qu_view` = '$updated_view' WHERE qu_id = '$get_id'";
            $update_view = mysqli_query($con,$updated_view);
            echo mysqli_error($con);
        }
    }else {
        header('location:home.php');
    }
    if (!empty($u_id)) {
        if ($u_id == $writer_id) {
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
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1"/>  
    <meta name="description" content=<?php echo $keyword;?> />
    <meta name="keywords" content=<?php echo $keyword;?> />
    <script src="https://cdn.staticfile.org/jquery/2.1.1/jquery.min.js"></script>
    <link rel="stylesheet" href="https://cdn.staticfile.org/twitter-bootstrap/3.3.7/css/bootstrap.min.css"/>
    <script src="https://cdn.staticfile.org/twitter-bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <title><?php echo "$keyword - willcloudy" ?></title>
    <link rel="stylesheet" href="css/css.css">
    <link rel="icon" type="image/x-ico" href="img/logo.ico" />
    <link rel="apple-touch-icon" sizes="180x180" href="/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/favicon-16x16.png">
    <link rel="manifest" href="/site.webmanifest">
    <script src="ajax/function.js"></script>
    <style>
        p{  
            font-size:1em;
            margin-top:5%;
            margin:10px;
        }
        blockquote {
            display: block;
            border-left: 8px solid #d0e5f2;
            padding: 5px 10px;
            margin: 10px 0;
            line-height: 1.4;
            font-size: 100%;
            background-color: #f1f1f1;
        }
        h1,h2,h3,h4,h5,h6{
            font-weight:bold;
        }
        h1{
            font-size:25px;
        }
        #posted_img img{
            width:100%;
        }
        /* @media(max-width:992px)
        {
            img{
                max-width:300px;
            }
        } */
    </style> 
</head>
<body>
    <div class="container">
       <?php
            if ($login == 1) {
                require('include/leftbar.php');
                echo "
                <script>
                    var profile = document.getElementById('profile');
                    profile.style.display='block';
                    document.getElementById('sign').style.display='none'; 
                    var profileA = document.getElementById('profileA');
                    profileA.style.display='block';
                </script>";
            }elseif ($login == 0) {
                require('include/leftbar.php');
                echo "<script>document.getElementById('sign').style.display='block' </script>";
            }
       ?> 
       <?php
            if ($type=='post') {
                echo "
                    <div class='col-md-6 midbar' style='padding:0 10px;'>
                        <div class='content'>
                            <h3 style='font-weight:bold;margin-left:1%;padding:8px'>$title <sup style='padding:5px;border-radius:10px;background-color:#29b473;font-size:0.3em;'>$answer_link<sup></h3>
                            <hr margin:10px;> 
                            <div id='posted_img' style='min-height:200px;margin:20px;'>
                                $content
                            </div>
                            <span style='float:left;margin-left:20px;font-size:0.1em;color:rgb(91, 112, 131);'><small>编辑于: $post_date</small></span>
                        </div>
                        <div style='clear:both'></div>";
                        if (isset($u_id)) {
                            $count= mysqli_query($con, "SELECT post_like FROM posts WHERE post_id=$post_id "); 
                            echo mysqli_error($con); 
                            $countResult=mysqli_fetch_array($count);  
                            $count_like=$countResult['post_like'];  
                
                
                            $is_liked = "SELECT * from like_post where user_id ='$u_id' and post_id='$post_id'";
                            $run_liked = mysqli_query($con, $is_liked);
                            $liked= mysqli_fetch_row($run_liked); 
                            if (isset($liked)) {
                                $showZan= "
                                <ul class='article-function'>
                                <li>
                                    <button id='$post_id' name='$post_id' onclick='zanDel(this)' style='color:red;background-color:white;' class='btn btn-primary liked_post'>
                                        <svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='currentColor' class='bi bi-heart-fill' viewBox='0 0 16 16'>
                                        <path fill-rule='evenodd' d='M8 1.314C12.438-3.248 23.534 4.735 8 15-7.534 4.736 3.562-3.248 8 1.314z'></path>
                                        </svg>
                                        <span id=$u_id>
                                        $post_like
                                        </span>
                                    </button>
                                </li>
                                <li><a href='../post.php?post_id=$post_id' target='_blank'><button class='btn btn-outline-success'><svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='currentColor' class='bi bi-chat-dots' viewBox='0 0 16 16'><path fill-rule='evenodd' d='M2.678 11.894a1 1 0 0 1 .287.801 10.97 10.97 0 0 1-.398 2c1.395-.323 2.247-.697 2.634-.893a1 1 0 0 1 .71-.074A8.06 8.06 0 0 0 8 14c3.996 0 7-2.807 7-6 0-3.192-3.004-6-7-6S1 4.808 1 8c0 1.468.617 2.83 1.678 3.894zm-.493 3.905a21.682 21.682 0 0 1-.713.129c-.2.032-.352-.176-.273-.362a9.68 9.68 0 0 0 .244-.637l.003-.01c.248-.72.45-1.548.524-2.319C.743 11.37 0 9.76 0 8c0-3.866 3.582-7 8-7s8 3.134 8 7-3.582 7-8 7a9.06 9.06 0 0 1-2.347-.306c-.52.263-1.639.742-3.468 1.105z'/><path d='M5 8a1 1 0 1 1-2 0 1 1 0 0 1 2 0zm4 0a1 1 0 1 1-2 0 1 1 0 0 1 2 0zm4 0a1 1 0 1 1-2 0 1 1 0 0 1 2 0z'/></svg>评论</button></a></li>
                                <li><a>
                                    <button onclick='shoucang(this)' class='btn btn-outline-success' id='$post_id'>
                                        <svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='currentColor' class='bi bi-star' viewBox='0 0 16 16'><path fill-rule='evenodd' d='M2.866 14.85c-.078.444.36.791.746.593l4.39-2.256 4.389 2.256c.386.198.824-.149.746-.592l-.83-4.73 3.523-3.356c.329-.314.158-.888-.283-.95l-4.898-.696L8.465.792a.513.513 0 0 0-.927 0L5.354 5.12l-4.898.696c-.441.062-.612.636-.283.95l3.523 3.356-.83 4.73zm4.905-2.767l-3.686 1.894.694-3.957a.565.565 0 0 0-.163-.505L1.71 6.745l4.052-.576a.525.525 0 0 0 .393-.288l1.847-3.658 1.846 3.658a.525.525 0 0 0 .393.288l4.052.575-2.906 2.77a.564.564 0 0 0-.163.506l.694 3.957-3.686-1.894a.503.503 0 0 0-.461 0z'/></svg>
                                        <span class='$u_id'>
                                        收藏
                                        </span>
                                    </button>
                                    </a>
                                </li>
                                
                                    </ul>
                                    <span style='float:right;margin-right:7%;margin-top:1%;font-size:0.1em;color:rgb(91, 112, 131);'><svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='currentColor' class='bi bi-eye' viewBox='0 -2 16 16'>
                                        <path fill-rule='evenodd' d='M16 8s-3-5.5-8-5.5S0 8 0 8s3 5.5 8 5.5S16 8 16 8zM1.173 8a13.134 13.134 0 0 0 1.66 2.043C4.12 11.332 5.88 12.5 8 12.5c2.12 0 3.879-1.168 5.168-2.457A13.134 13.134 0 0 0 14.828 8a13.133 13.133 0 0 0-1.66-2.043C11.879 4.668 10.119 3.5 8 3.5c-2.12 0-3.879 1.168-5.168 2.457A13.133 13.133 0 0 0 1.172 8z'/>
                                        <path fill-rule='evenodd' d='M8 5.5a2.5 2.5 0 1 0 0 5 2.5 2.5 0 0 0 0-5zM4.5 8a3.5 3.5 0 1 1 7 0 3.5 3.5 0 0 1-7 0z'/>
                                        </svg>&nbsp;&nbsp;<span>$post_view</span>
                                    </span>
                                    <div style='clear:both'></div>
                                ";
                            }else{
                                $showZan="
                                <ul class='article-function'>
                                    <li>
                                        <button onclick='zan(this)' id='$post_id' name='$post_id'  class='btn btn-primary like_post'>
                                            <svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='currentColor' class='bi bi-heart-fill' viewBox='0 0 16 16'>
                                            <path fill-rule='evenodd' d='M8 1.314C12.438-3.248 23.534 4.735 8 15-7.534 4.736 3.562-3.248 8 1.314z'></path>
                                            </svg>
                                            <span id=$u_id>
                                                $post_like
                                            </span>
                                        </button>
                                    </li>
                                    
                                    <li>
                                        <a href='post.php?post_id=$post_id' target='_blank'>
                                            <button class='btn btn-outline-success'>
                                                <svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='currentColor' class='bi bi-chat-dots' viewBox='0 0 16 16'><path fill-rule='evenodd' d='M2.678 11.894a1 1 0 0 1 .287.801 10.97 10.97 0 0 1-.398 2c1.395-.323 2.247-.697 2.634-.893a1 1 0 0 1 .71-.074A8.06 8.06 0 0 0 8 14c3.996 0 7-2.807 7-6 0-3.192-3.004-6-7-6S1 4.808 1 8c0 1.468.617 2.83 1.678 3.894zm-.493 3.905a21.682 21.682 0 0 1-.713.129c-.2.032-.352-.176-.273-.362a9.68 9.68 0 0 0 .244-.637l.003-.01c.248-.72.45-1.548.524-2.319C.743 11.37 0 9.76 0 8c0-3.866 3.582-7 8-7s8 3.134 8 7-3.582 7-8 7a9.06 9.06 0 0 1-2.347-.306c-.52.263-1.639.742-3.468 1.105z'/><path d='M5 8a1 1 0 1 1-2 0 1 1 0 0 1 2 0zm4 0a1 1 0 1 1-2 0 1 1 0 0 1 2 0zm4 0a1 1 0 1 1-2 0 1 1 0 0 1 2 0z'/></svg>
                                                评论
                                            </button>
                                        </a>
                                    </li>
                
                                    <li>
                                        <a>
                                            <button  onclick='shoucang(this)' id='$post_id'  class='btn btn-outline-success'>
                                                <svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='currentColor' class='bi bi-star' viewBox='0 0 16 16'><path fill-rule='evenodd' d='M2.866 14.85c-.078.444.36.791.746.593l4.39-2.256 4.389 2.256c.386.198.824-.149.746-.592l-.83-4.73 3.523-3.356c.329-.314.158-.888-.283-.95l-4.898-.696L8.465.792a.513.513 0 0 0-.927 0L5.354 5.12l-4.898.696c-.441.062-.612.636-.283.95l3.523 3.356-.83 4.73zm4.905-2.767l-3.686 1.894.694-3.957a.565.565 0 0 0-.163-.505L1.71 6.745l4.052-.576a.525.525 0 0 0 .393-.288l1.847-3.658 1.846 3.658a.525.525 0 0 0 .393.288l4.052.575-2.906 2.77a.564.564 0 0 0-.163.506l.694 3.957-3.686-1.894a.503.503 0 0 0-.461 0z'/></svg>
                                                <span class='$u_id'>
                                                收藏
                                                </span>
                                            </button>
                                        </a>
                                    </li>
                                    
                                </ul>
                
                                <span style='float:right;margin-right:7%;margin-top:1%;font-size:0.1em;color:rgb(91, 112, 131);'><svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='currentColor' class='bi bi-eye' viewBox='0 -2 16 16'>
                                    <path fill-rule='evenodd' d='M16 8s-3-5.5-8-5.5S0 8 0 8s3 5.5 8 5.5S16 8 16 8zM1.173 8a13.134 13.134 0 0 0 1.66 2.043C4.12 11.332 5.88 12.5 8 12.5c2.12 0 3.879-1.168 5.168-2.457A13.134 13.134 0 0 0 14.828 8a13.133 13.133 0 0 0-1.66-2.043C11.879 4.668 10.119 3.5 8 3.5c-2.12 0-3.879 1.168-5.168 2.457A13.133 13.133 0 0 0 1.172 8z'/>
                                    <path fill-rule='evenodd' d='M8 5.5a2.5 2.5 0 1 0 0 5 2.5 2.5 0 0 0 0-5zM4.5 8a3.5 3.5 0 1 1 7 0 3.5 3.5 0 0 1-7 0z'/>
                                    </svg>&nbsp;&nbsp;<span>$post_view</span>
                                </span>
                
                                <div style='clear:both'></div>
                                ";
                            }
                        }else{
                            $showZan = "
                            <ul class='article-function'>
                                <li>
                                    <button data-toggle='modal' data-target='#myModal' id='$post_id' name='$post_id'  class='btn btn-primary like_post'>
                                        <svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='currentColor' class='bi bi-heart-fill' viewBox='0 0 16 16'>
                                        <path fill-rule='evenodd' d='M8 1.314C12.438-3.248 23.534 4.735 8 15-7.534 4.736 3.562-3.248 8 1.314z'></path>
                                        </svg>
                                        <span>
                                            $post_like
                                        </span>
                                    </button>
                                </li>
                                
                                <li>
                                    <a data-toggle='modal' data-target='#myModal' href='post.php?post_id=$post_id' target='_blank'>
                                        <button class='btn btn-outline-success'>
                                            <svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='currentColor' class='bi bi-chat-dots' viewBox='0 0 16 16'><path fill-rule='evenodd' d='M2.678 11.894a1 1 0 0 1 .287.801 10.97 10.97 0 0 1-.398 2c1.395-.323 2.247-.697 2.634-.893a1 1 0 0 1 .71-.074A8.06 8.06 0 0 0 8 14c3.996 0 7-2.807 7-6 0-3.192-3.004-6-7-6S1 4.808 1 8c0 1.468.617 2.83 1.678 3.894zm-.493 3.905a21.682 21.682 0 0 1-.713.129c-.2.032-.352-.176-.273-.362a9.68 9.68 0 0 0 .244-.637l.003-.01c.248-.72.45-1.548.524-2.319C.743 11.37 0 9.76 0 8c0-3.866 3.582-7 8-7s8 3.134 8 7-3.582 7-8 7a9.06 9.06 0 0 1-2.347-.306c-.52.263-1.639.742-3.468 1.105z'/><path d='M5 8a1 1 0 1 1-2 0 1 1 0 0 1 2 0zm4 0a1 1 0 1 1-2 0 1 1 0 0 1 2 0zm4 0a1 1 0 1 1-2 0 1 1 0 0 1 2 0z'/></svg>
                                            评论
                                        </button>
                                    </a>
                                </li>
                
                                <li>
                                    <a>
                                        <button data-toggle='modal' data-target='#myModal'class='btn btn-outline-success'>
                                            <svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='currentColor' class='bi bi-star' viewBox='0 0 16 16'><path fill-rule='evenodd' d='M2.866 14.85c-.078.444.36.791.746.593l4.39-2.256 4.389 2.256c.386.198.824-.149.746-.592l-.83-4.73 3.523-3.356c.329-.314.158-.888-.283-.95l-4.898-.696L8.465.792a.513.513 0 0 0-.927 0L5.354 5.12l-4.898.696c-.441.062-.612.636-.283.95l3.523 3.356-.83 4.73zm4.905-2.767l-3.686 1.894.694-3.957a.565.565 0 0 0-.163-.505L1.71 6.745l4.052-.576a.525.525 0 0 0 .393-.288l1.847-3.658 1.846 3.658a.525.525 0 0 0 .393.288l4.052.575-2.906 2.77a.564.564 0 0 0-.163.506l.694 3.957-3.686-1.894a.503.503 0 0 0-.461 0z'/></svg>
                                            收藏
                                        </button>
                                    </a>
                                </li>
                                
                            </ul>
                
                            <span style='float:right;margin-right:7%;margin-top:1%;font-size:0.1em;color:rgb(91, 112, 131);'><svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='currentColor' class='bi bi-eye' viewBox='0 -2 16 16'>
                                <path fill-rule='evenodd' d='M16 8s-3-5.5-8-5.5S0 8 0 8s3 5.5 8 5.5S16 8 16 8zM1.173 8a13.134 13.134 0 0 0 1.66 2.043C4.12 11.332 5.88 12.5 8 12.5c2.12 0 3.879-1.168 5.168-2.457A13.134 13.134 0 0 0 14.828 8a13.133 13.133 0 0 0-1.66-2.043C11.879 4.668 10.119 3.5 8 3.5c-2.12 0-3.879 1.168-5.168 2.457A13.133 13.133 0 0 0 1.172 8z'/>
                                <path fill-rule='evenodd' d='M8 5.5a2.5 2.5 0 1 0 0 5 2.5 2.5 0 0 0 0-5zM4.5 8a3.5 3.5 0 1 1 7 0 3.5 3.5 0 0 1-7 0z'/>
                                </svg>&nbsp;&nbsp;<span>$post_view</span>
                            </span>
                
                            <div style='clear:both'></div>
                            ";
                        }
                        echo "<div style='margin-top:20px;'id='$post_id'>$showZan</div>
                        <hr style='margin-top:0px;'>";
                        
                if ($login !== 0) {
                    echo "
                    <form method='POST' action='' style=''>
                        <input id='let_comment' style='float:left;width:74%;margin:0;padding-left:15px;'class='form-control search' type='text' maxlength='50' name='comment' autocomplete='off' required='required' placeholder='请输入你的评论'>
                        <button name='reply' class='btn btn-primary' style='width:20%; float:right' >评论</button>
                        <div style='clear:both'></div>
                    </form>
                    <br>
                    ";

                    if (isset($_POST['reply'])) {
                        $comment = htmlentities($_POST['comment']);

                        if ($comment == '') {
                            echo "<script>alert('输入你的评论')</script>";
                            echo "<script>window.open('post.php?post_id=$post_id', '_self')</script>";
                        }else {
                            $insert = "insert into comment(post_id, author_id, comment, comment_author, comment_date) Values('$post_id','$u_id','$comment','$u_name',NOW())";

                            $run = mysqli_query($con, $insert);
                            if ($run) {
                                echo "<script>alert('评论成功!')</script>";
                                echo "<script>window.open('post.php?post_id=$post_id', '_self')</script>";
                            }
                            else {
                                echo "<script>alert('评论失败了~')</script>";
                                //echo "<script>window.open('post.php?post_id=$post_id', '_self')</script>";
                                echo mysqli_error($con);
                            } 
                        }
                    }
                }else {
                    echo "
                    <input style='margin:2% 3%;width:86%;margin-bottom:0px;padding-left:15px;'class='form-control search' type='text' name='comment' autocomplete='off' required='required' disabled placeholder='登陆后开启评论功能'>
                    <br>
                    <br>";
                }
                $get_com = "select * from comment where post_id='$get_id' ORDER by 1 DESC";
                echo mysqli_error($con);
                $run_com = mysqli_query($con, $get_com);
                echo mysqli_error($con);
                if (isset($run_com)) {
                    echo "<div style='min-height:100px; border:1px solid #ccc;padding:5px;border-radius:10px;'>
                            <h5>评论</h5>
                            <hr style='margin:5px;'>";
                    while($row = mysqli_fetch_array($run_com)){
                        $com = $row['comment'];
                        $con_name = $row['comment_author'];
                        $date = $row['comment_date'];
                        $user_id = $row['author_id'];

                        $date = wordTime($date);
                        $user_query = "Select * from `users` where user_id = $user_id";
                        $run_user = mysqli_query($con, $user_query);
                        $row_user = mysqli_fetch_array($run_user);
                        $com_image = $row_user['user_image'];

                        echo "
                            <div style=''>
                                <a href='profile.php?u_id=$user_id'><img src='$com_image'style='float:left;width:40px;margin-right:10px;border:1px solid #CCCC99'></a>
                                <div style='width:70%;float:left;'>
                                    <a href='profile.php?u_id=$user_id'><span style='font-size:1em;color:#555666'>$con_name</span></a>:   
                                    &nbsp;
                                    <span id='com_date'style='font-weight:normal;color:rgb(91, 112, 131)'>$date</span>
                                    <br>
                                    <span style='font-size:13.5px;color:black'>$com</span>
                                </div>
                                <span style='float:right;margin-top: 10px;'><button class='btn btn-default' style='font-size:0.8em;padding:4px;'>回复</button></span>

                                <div style='clear:both'></div>
                            </div>
                            <hr style='margin:5px 0;'>
                        ";
                    }
                    echo "  
                    </div>
                    <br>
                    </div>";
                }else {
                    echo "  
                    </div>";
            }
        ?>
                    <div class="col-md-3" id='rightbar'>
                        <div id="search-small">
                            <form action="result.php" method="POST">
                                <span>
                                    <input class='form-control search' type="text" name='searchcontent'autocomplete="off" placeholder='搜索大学/文章/用户' required='required' style='width:100%'/>
                                </span>
                                <span class='span2'>
                                    <a href="result.php" style='position:relative'>
                                        <span class="glyphicon glyphicon-search search-sm-icon"></span>
                                        <button class='form-control btn btn-primary'type='submit' style='display:none'>
                                        </button>
                                    </a>
                                </span>
                                <div style="clear:both;"></div>
                            </form>
                        </div>
                        <div id='other'>
                            <div class='rightbar' >
                                <h4 style='font-weight:bold;margin-top:0px;padding-top:20px;text-align:center'>作者简介</h4>
                                <hr style='margin:5px;'>
                                <a href='<?php echo "profile.php?u_id=$writer_id";?>' target='_blank'><img id=''src='<?php echo $user_image?>' style='margin:0 auto;display:block' alt='profile' width='50px'class='img-thumbnail img-circle'></a>
                                
                                <a href='<?php echo "profile.php?u_id=$writer_id";?>' target='_blank' style='text-align:center;display:block;font-weight:bold;color:rgb(91, 112, 131);font-size:1.1em;margin-bottom:5px;'><?php echo $writer_name?></a>
                                <span style='font-size:0.6em;margin-top:5px;text-align:center;display:block;color:rgb(91, 112, 131);'><small><?php echo $user_des?></small></span>
                                <br>
                                <div style='text-align: center;'>
                                <?php
                                     if ($status == 1) {
                                        echo "<a href='edit.php'><button style='position:static !important;border-radius:0;'class='editProfile'>编辑个人资料</button></a>";
                                    }elseif($status == 2){
                                        $check_follow = "Select * from follow where follower_id = '$u_id' and user_id = '$writer_id'";
                                        $run_check = mysqli_query($con, $check_follow);
                                        echo mysqli_error($con);
                                        if (mysqli_num_rows($run_check) == 0) {
                                            echo "<a><button  onclick='follow(this)' id='$writer_id' class='follow_btn' style='position:static !important;border-radius:0;'><span id='$u_id'>关注</span></button></a>";
                                        }else {
                                            echo "<a><button onclick='unfollow(this)'  id='$writer_id' class='btn-danger followed_btn' style='position:static !important;border-radius:0;'><span id='$u_id'>取消关注</span></button></a>";
                                        }
                                    }elseif($status == 0){
                                        echo "<a data-toggle='modal' data-target='#myModal'><button style='position:static !important;border-radius:0;' class='follow_btn'>关注他</button></a>";
                                    }
                                ?>
                                    <a href="profile.php?u_id=<?php echo $writer_id;?>" target='_blank'><button style='position:static !important;border-radius:0;' class='follow_btn' >文章</button></a>
                                </div>
                                <hr>
                                <div style='text-align: center;color:#999'>
                                    <div style='display:inline-block'>
                                        回答数
                                        <br>
                                        <?php
                                            $answer_num = "SELECT * FROM posts where user_id = '$writer_id' and type='answer'";
                                            $run_answer_query = mysqli_query($con, $answer_num);
                                            echo mysqli_error($con);
                                            $result_answer = mysqli_num_rows($run_answer_query);
                                            if ($result_answer == 0 or $result_answer == null) {
                                                echo '0';
                                            }else {
                                                echo $result_answer;
                                            }
                                        ?>
                                    </div>
                                    <div style='display:inline-block'>
                                        文章数
                                        <br>
                                        <?php
                                            $post_num = "SELECT * FROM posts where user_id = '$writer_id' and type='post'";
                                            $run_post_query = mysqli_query($con, $post_num);
                                            echo mysqli_error($con);
                                            $result_post = mysqli_num_rows($run_post_query);
                                            if ($result_post == 0 or $result_post == null) {
                                                echo '0';
                                            }else {
                                                echo $result_post;
                                            }
                                        ?>
                                    </div>
                                    <div style='display:inline-block'>
                                        获赞
                                        <br>
                                        <?php
                                            $like_num = "SELECT * FROM posts where user_id = '$writer_id'";
                                            $run_like_query = mysqli_query($con, $like_num);
                                            echo mysqli_error($con);
                                            while($result_like = mysqli_fetch_array($run_like_query)){
                                                $post_like = $result_like['post_like'];
                                                $total += $post_like;
                                            }
                                            echo $total;
                                        ?>
                                    </div>
                                    <div style='display:inline-block'>
                                        阅读量
                                        <br>
                                        <?php
                                            $view_num = "SELECT * FROM posts where user_id = '$writer_id'";
                                            $run_view_query = mysqli_query($con, $view_num);
                                            echo mysqli_error($con);
                                            while($result_view = mysqli_fetch_array($run_view_query)){
                                                $post_view = $result_view['post_view'];
                                                $total_view += $post_view;
                                            }
                                            echo $total_view;
                                        ?>
                                    </div>
                                    <div style='display:inline-block'>
                                        粉丝
                                        <br>
                                        <?php
                                            $follower_num = "SELECT * FROM follow where user_id = '$writer_id'";
                                            $run_follower_query = mysqli_query($con, $follower_num);
                                            echo mysqli_error($con);
                                            $result_follow = mysqli_num_rows($run_follower_query);
                                            echo $result_follow;
                                        ?>
                                    </div>
                                </div>
                                <br>
                                <br>
                            </div>
                        </div>
                        <br>
                        <div id='other'>
                            <div class='rightbar' >
                                <div class='ulist'>
                                    <h4 style='margin-top:0;font-weight:bold;text-align:center;padding-top:15px;'>🎉推荐文章</h4>
                                    <div class="row">
                                        <div class='col-md-11' style='border:0px;box-shadow:none;'>
                                            <ul class='tuij'style='list-style:none;float:left;padding-left:10px;'>
                                                <li>
                                                    <div>
                                                        <a href="country.php?selectednation=UK" ><h4 style='font-weight:bold;text-align:center;margin:0px'><span>#</span>英国</h4></a>
                                                    </div>
                                                </li>
                                                <br>
                                                <li>
                                                    <div>
                                                        <a href="country.php?selectednation=CAN"><h4 style='font-weight:bold;text-align:center;margin:0px'><span>#</span>加拿大</h4></a>
                                                    </div>
                                                </li>
                                                <br>
                                                <li>
                                                    <div>
                                                        <a href="country.php?selectednation=AUS"><h4 style='font-weight:bold;text-align:center;margin:0px'><span>#</span>澳大利亚</h4></a>
                                                    </div>
                                                </li>
                                            </ul>
                                            <ul style='list-style:none;float:right;padding-left:10px;' class='tuij'>
                                                <li>
                                                    <div>
                                                        <a href="oversealife.php" ><h4 style='font-weight:bold;text-align:center;margin:0px'><span>#</span>海外留学</h4></a>
                                                    </div>
                                                </li>
                                                <br>
                                                <li>
                                                    <div>
                                                        <a href="topics.php?"><h4 style='font-weight:bold;text-align:center;margin:0px'><span>#</span>留学归来</h4></a>
                                                    </div>
                                                </li>
                                                <br>
                                                <li>
                                                    <div>
                                                        <a href="question.php"><h4 style='font-weight:bold;text-align:center;margin:0px'><span>#</span>留学问答</h4></a>
                                                    </div>
                                                </li>
                                            </ul>
                                        </div>         
                                    </div> 
                                    <br>  
                                    
                                </div>
                            </div>
                        </div>
                    </div>
        <?php
            }elseif ($type='question') {
                echo "
                <div class='col-md-6 midbar' style='padding:0;'>
                    <div class='content'>
                        <h3 style='font-weight:bold;margin-left:1%;padding:8px;display:block'>$question</h3>
                        <a href='profile.php?u_id=$user_id'><img id='home-profile'src='$user_image' style='margin-left:4%;' alt='profile' width='30px'class='img-circle'></a>
                        <a href='profile.php?u_id=$user_id' style='font-weight:bold;color:rgb(91, 112, 131);margin-left:1%;font-size:1em;margin-bottom:5px;'>$user_name</a>
                        <span style='font-size:0.6em;display:inline-block;color:rgb(91, 112, 131);margin-top:10px;'><small>$user_des</small></span>
                        ";
                        if (!empty($qu_des)) {
                            echo "<div style='width:75%;margin:20px;'>$qu_des</div>";
                        }
                        echo "<span style='float:left;margin-left:20px;font-size:0.7em;'>编辑于: $post_date</span>";
                ?>
                <br>
                <div style='margin-right:10px;float:right;'>
                    <span style='margin-right:25px;font-size:0.1em;color:rgb(91, 112, 131);'><svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='currentColor' class='bi bi-eye' viewBox='0 -2 16 16'>
                    <path fill-rule='evenodd' d='M16 8s-3-5.5-8-5.5S0 8 0 8s3 5.5 8 5.5S16 8 16 8zM1.173 8a13.134 13.134 0 0 0 1.66 2.043C4.12 11.332 5.88 12.5 8 12.5c2.12 0 3.879-1.168 5.168-2.457A13.134 13.134 0 0 0 14.828 8a13.133 13.133 0 0 0-1.66-2.043C11.879 4.668 10.119 3.5 8 3.5c-2.12 0-3.879 1.168-5.168 2.457A13.133 13.133 0 0 0 1.172 8z'/>
                    <path fill-rule='evenodd' d='M8 5.5a2.5 2.5 0 1 0 0 5 2.5 2.5 0 0 0 0-5zM4.5 8a3.5 3.5 0 1 1 7 0 3.5 3.5 0 0 1-7 0z'/>
                    </svg>&nbsp;&nbsp;<span><?php echo $question_view;?></span></span>
                    <a data-toggle='modal' data-target='#answer_question'>
                        <button class='question_btn' style='margin-top:0;'>回答</button></a> 
                    </a>
                    
                    <button class='question_btn' onclick='shouW(this)' id='<?php echo $get_id;?>' style='margin-top:0;color:#198754;background-color:white'><span class='<?php echo $u_id;?>'>收藏</span></button></a> 
                    
                </div>
                <br>
                <br>
                <div class="modal fade" id="answer_question" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content"style='width:100%'>
                            <div class="modal-body" >
                                <button type="button" class='close'data-dismiss="modal" aria-hidden="true" >
                                    &times;
                                </button>
                                <h4 style='margin-left:28px;'>回答问题 - <?php echo $question?></h4>
                                <div class="question-form" style='margin-top:0;'>
                                    <form action="" method="POST">
                                        <div id="answer-toolbar" class= "toolbar post"></div>
                                        <div id="answer-text" class="text"></div>
                                        <textarea required id="text2" name="answer-content" style="width:100%; height:200px;display:none"></textarea>
                                        <br>
                                        <button class="go_write" type="submit">发布</button></a>
                                    </form>
                                </div>
                            </div>
                        </div><!-- /.modal-content -->
                    </div><!-- /.modal -->
                </div>

                <script>
                    const C = window.wangEditor
                    const editor3 = new C('#answer-toolbar', '#answer-text')
                    editor3.config.menus = [
                        'head',
                        'bold',
                        'fontSize',
                        'italic',
                        'underline',
                        'strikeThrough',
                        'indent',
                        'lineHeight',
                        'foreColor',
                        'link',
                        'list',
                        'justify',
                        'quote',
                        'image',
                        'splitLine',
                        'undo',
                        'redo',
                    ]
                    editor3.config.placeholder = '你的答案？'
                    editor3.config.uploadImgAccept = ['jpg', 'jpeg', 'png', 'gif', 'bmp']
                    editor3.config.uploadImgServer = "insert_img.php";
                    editor3.config.uploadFileName = 'file'; //设置文件上传的参数名称
                    editor3.config.uploadImgMaxSize = 3 * 1024 * 1024; // 将图片大小限制为 3M
                    //自定义上传图片事件
                    editor3.config.uploadImgHeaders = {    //header头信息 
                        'Accept': 'text/x-json'
                    }
                    // 将图片大小限制为 3M
                    editor3.config.uploadImgShowBase64 = false;   // 使用 base64 保存图片
                    // editor.customConfig.customAlert = function (info) { //自己设置alert错误信息
                    //     // info 是需要提示的内容
                    //     alert('自定义提示：' + '图片上传失败，请重新上传')
                    // };
                    editor3.config.debug = true; //是否开启Debug 默认为false 建议开启 可以看到错误
                    // editor.customConfig.debug = location.href.indexOf('wangeditor_debug_mode=1') > 0; // 同上 二选一
                    //图片在编辑器中回显
                    editor3.config.uploadImgHooks = {  
                        error: function (xhr, editor) {
                            alert("2：" + xhr + "请查看你的json格式是否正确，图片并没有上传");
                            // 图片上传出错时触发  如果是这块报错 就说明文件没有上传上去，直接看自己的json信息。是否正确
                            // xhr 是 XMLHttpRequst 对象，editor 是编辑器对象
                        },
                        fail: function (xhr, editor, result) {
                            //  如果在这出现的错误 就说明图片上传成功了 但是没有回显在编辑器中，我在这做的是在原有的json 中添加了
                            //  一个url的key（参数）这个参数在 customInsert也用到
                            //  
                            alert("1：" + xhr + "请查看你的json格式是否正确，图片上传了，但是并没有回显");
                        },
                        success:function(xhr, editor, result){
                            //成功 不需要alert 当然你可以使用console.log 查看自己的成功json情况 
                            //console.log(result)
                            // insertImg('https://ss0.bdstatic.com/5aV1bjqh_Q23odCf/static/superman/img/logo/bd_logo1_31bdc765.png')
                        },
                        customInsert: function (insertImg, result, editor) {
                            //console.log(result);
                            // 图片上传并返回结果，自定义插入图片的事件（而不是编辑器自动插入图片！！！）
                            // insertImg 是插入图片的函数，editor 是编辑器对象，result 是服务器端返回的结果
                            // 举例：假如上传图片成功后，服务器端返回的是 {url:'....'} 这种格式，即可这样插入图片：
                            insertImg(result.url);
                        }
                    };
                    const $text2 = $('#text2')
                    editor3.config.onchange = function (html) {
                        // 第二步，监控变化，同步更新到 textarea
                        $text2.val(html)
                    }
                    editor3.create()

                    // 第一步，初始化 textarea 的值
                    $text2.val(editor3.txt.html())
                    
                </script>
                <hr>
                <h4 style='margin-left:10px;'>回答</h4>
                <?php
                    $get_answer = "select * from `posts` where type='answer' and post_title='$question'";
                    $answer_query = mysqli_query($con, $get_answer);
                    echo mysqli_error($con);
                    $result = mysqli_num_rows($answer_query);

                    if ($result == 0) {
                        echo "<h5 style='text-align:center;margin:50px;font-weight:bold'>这里还没有回答..<a href=''data-toggle='modal' data-target='#answer_question'style='color:green'>点此回答吧</a></h5>";
                    }else {
                        while ($row = mysqli_fetch_array($answer_query)) {
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

                            if (!empty($u_id)) {
                                $count= mysqli_query($con, "SELECT post_like FROM posts WHERE post_id=$post_id "); 
                                echo mysqli_error($con); 
                                $countResult=mysqli_fetch_array($count);  
                                $count_like=$countResult['post_like'];  


                                $is_liked = "SELECT * from like_post where user_id ='$u_id' and post_id='$post_id'";
                                $run_liked = mysqli_query($con, $is_liked);
                                echo mysqli_error($con);
                                $liked= mysqli_fetch_row($run_liked); 
                                if (isset($liked)) {
                                    $showZan= "
                                    <ul class='article-function'>
                                    <li>
                                        <button id='$post_id' name='$post_id' onclick='zanDel(this)' style='color:red;background-color:white;' class='btn btn-primary liked_post'>
                                            <svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='currentColor' class='bi bi-heart-fill' viewBox='0 0 16 16'>
                                            <path fill-rule='evenodd' d='M8 1.314C12.438-3.248 23.534 4.735 8 15-7.534 4.736 3.562-3.248 8 1.314z'></path>
                                            </svg>
                                            <span id=$u_id>
                                            $post_like
                                            </span>
                                        </button>
                                    </li>
                                    <li><a href='../post.php?post_id=$post_id' target='_blank'><button class='btn btn-outline-success'><svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='currentColor' class='bi bi-chat-dots' viewBox='0 0 16 16'><path fill-rule='evenodd' d='M2.678 11.894a1 1 0 0 1 .287.801 10.97 10.97 0 0 1-.398 2c1.395-.323 2.247-.697 2.634-.893a1 1 0 0 1 .71-.074A8.06 8.06 0 0 0 8 14c3.996 0 7-2.807 7-6 0-3.192-3.004-6-7-6S1 4.808 1 8c0 1.468.617 2.83 1.678 3.894zm-.493 3.905a21.682 21.682 0 0 1-.713.129c-.2.032-.352-.176-.273-.362a9.68 9.68 0 0 0 .244-.637l.003-.01c.248-.72.45-1.548.524-2.319C.743 11.37 0 9.76 0 8c0-3.866 3.582-7 8-7s8 3.134 8 7-3.582 7-8 7a9.06 9.06 0 0 1-2.347-.306c-.52.263-1.639.742-3.468 1.105z'/><path d='M5 8a1 1 0 1 1-2 0 1 1 0 0 1 2 0zm4 0a1 1 0 1 1-2 0 1 1 0 0 1 2 0zm4 0a1 1 0 1 1-2 0 1 1 0 0 1 2 0z'/></svg>评论</button></a></li>
                                    <li><a>
                                    
                                    <button onclick='shoucang(this)' id='$post_id'  class='btn btn-outline-success'>
                                        <svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='currentColor' class='bi bi-star' viewBox='0 0 16 16'><path fill-rule='evenodd' d='M2.866 14.85c-.078.444.36.791.746.593l4.39-2.256 4.389 2.256c.386.198.824-.149.746-.592l-.83-4.73 3.523-3.356c.329-.314.158-.888-.283-.95l-4.898-.696L8.465.792a.513.513 0 0 0-.927 0L5.354 5.12l-4.898.696c-.441.062-.612.636-.283.95l3.523 3.356-.83 4.73zm4.905-2.767l-3.686 1.894.694-3.957a.565.565 0 0 0-.163-.505L1.71 6.745l4.052-.576a.525.525 0 0 0 .393-.288l1.847-3.658 1.846 3.658a.525.525 0 0 0 .393.288l4.052.575-2.906 2.77a.564.564 0 0 0-.163.506l.694 3.957-3.686-1.894a.503.503 0 0 0-.461 0z'/></svg>
                                        <span class='$u_id'>
                                        收藏
                                        </span>
                                    </button></a></li>
                                    
                                        </ul>
                                        <span style='float:right;margin-right:8%;margin-top:1%;font-size:0.1em;color:rgb(91, 112, 131);'><svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='currentColor' class='bi bi-eye' viewBox='0 -2 16 16'>
                                            <path fill-rule='evenodd' d='M16 8s-3-5.5-8-5.5S0 8 0 8s3 5.5 8 5.5S16 8 16 8zM1.173 8a13.134 13.134 0 0 0 1.66 2.043C4.12 11.332 5.88 12.5 8 12.5c2.12 0 3.879-1.168 5.168-2.457A13.134 13.134 0 0 0 14.828 8a13.133 13.133 0 0 0-1.66-2.043C11.879 4.668 10.119 3.5 8 3.5c-2.12 0-3.879 1.168-5.168 2.457A13.133 13.133 0 0 0 1.172 8z'/>
                                            <path fill-rule='evenodd' d='M8 5.5a2.5 2.5 0 1 0 0 5 2.5 2.5 0 0 0 0-5zM4.5 8a3.5 3.5 0 1 1 7 0 3.5 3.5 0 0 1-7 0z'/>
                                            </svg>&nbsp;&nbsp;<span>$post_view</span>
                                        </span>
                                        <div style='clear:both'></div>
                                    ";
                                }else{
                                    $showZan="
                                    <ul class='article-function'>
                                        <li>
                                            <button onclick='zan(this)' id='$post_id' name='$post_id'  class='btn btn-primary like_post'>
                                                <svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='currentColor' class='bi bi-heart-fill' viewBox='0 0 16 16'>
                                                <path fill-rule='evenodd' d='M8 1.314C12.438-3.248 23.534 4.735 8 15-7.534 4.736 3.562-3.248 8 1.314z'></path>
                                                </svg>
                                                <span id=$u_id>
                                                    $post_like
                                                </span>
                                            </button>
                                        </li>
                                        
                                        <li>
                                            <a href='post.php?post_id=$post_id' target='_blank'>
                                                <button class='btn btn-outline-success'>
                                                    <svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='currentColor' class='bi bi-chat-dots' viewBox='0 0 16 16'><path fill-rule='evenodd' d='M2.678 11.894a1 1 0 0 1 .287.801 10.97 10.97 0 0 1-.398 2c1.395-.323 2.247-.697 2.634-.893a1 1 0 0 1 .71-.074A8.06 8.06 0 0 0 8 14c3.996 0 7-2.807 7-6 0-3.192-3.004-6-7-6S1 4.808 1 8c0 1.468.617 2.83 1.678 3.894zm-.493 3.905a21.682 21.682 0 0 1-.713.129c-.2.032-.352-.176-.273-.362a9.68 9.68 0 0 0 .244-.637l.003-.01c.248-.72.45-1.548.524-2.319C.743 11.37 0 9.76 0 8c0-3.866 3.582-7 8-7s8 3.134 8 7-3.582 7-8 7a9.06 9.06 0 0 1-2.347-.306c-.52.263-1.639.742-3.468 1.105z'/><path d='M5 8a1 1 0 1 1-2 0 1 1 0 0 1 2 0zm4 0a1 1 0 1 1-2 0 1 1 0 0 1 2 0zm4 0a1 1 0 1 1-2 0 1 1 0 0 1 2 0z'/></svg>
                                                    评论
                                                </button>
                                            </a>
                                        </li>

                                        <li>
                                            <a>
                                                <button onclick='shoucang(this)' id='$post_id'  class='btn btn-outline-success'>
                                                    <svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='currentColor' class='bi bi-star' viewBox='0 0 16 16'><path fill-rule='evenodd' d='M2.866 14.85c-.078.444.36.791.746.593l4.39-2.256 4.389 2.256c.386.198.824-.149.746-.592l-.83-4.73 3.523-3.356c.329-.314.158-.888-.283-.95l-4.898-.696L8.465.792a.513.513 0 0 0-.927 0L5.354 5.12l-4.898.696c-.441.062-.612.636-.283.95l3.523 3.356-.83 4.73zm4.905-2.767l-3.686 1.894.694-3.957a.565.565 0 0 0-.163-.505L1.71 6.745l4.052-.576a.525.525 0 0 0 .393-.288l1.847-3.658 1.846 3.658a.525.525 0 0 0 .393.288l4.052.575-2.906 2.77a.564.564 0 0 0-.163.506l.694 3.957-3.686-1.894a.503.503 0 0 0-.461 0z'/></svg>
                                                    <span class='$u_id'>
                                                    收藏
                                                    </span>
                                                </button>
                                            </a>
                                        </li>
                                        
                                    </ul>

                                    <span style='float:right;margin-right:7%;margin-top:1%;font-size:0.1em;color:rgb(91, 112, 131);'><svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='currentColor' class='bi bi-eye' viewBox='0 -2 16 16'>
                                        <path fill-rule='evenodd' d='M16 8s-3-5.5-8-5.5S0 8 0 8s3 5.5 8 5.5S16 8 16 8zM1.173 8a13.134 13.134 0 0 0 1.66 2.043C4.12 11.332 5.88 12.5 8 12.5c2.12 0 3.879-1.168 5.168-2.457A13.134 13.134 0 0 0 14.828 8a13.133 13.133 0 0 0-1.66-2.043C11.879 4.668 10.119 3.5 8 3.5c-2.12 0-3.879 1.168-5.168 2.457A13.133 13.133 0 0 0 1.172 8z'/>
                                        <path fill-rule='evenodd' d='M8 5.5a2.5 2.5 0 1 0 0 5 2.5 2.5 0 0 0 0-5zM4.5 8a3.5 3.5 0 1 1 7 0 3.5 3.5 0 0 1-7 0z'/>
                                        </svg>&nbsp;&nbsp;<span>$post_view</span>
                                    </span>

                                    <div style='clear:both'></div>
                                    ";
                                    }
                            }else{
                                $showZan = "
                                <ul class='article-function'>
                                    <li>
                                        <button data-toggle='modal' data-target='#myModal' id='$post_id' name='$post_id'  class='btn btn-primary like_post'>
                                            <svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='currentColor' class='bi bi-heart-fill' viewBox='0 0 16 16'>
                                            <path fill-rule='evenodd' d='M8 1.314C12.438-3.248 23.534 4.735 8 15-7.534 4.736 3.562-3.248 8 1.314z'></path>
                                            </svg>
                                            <span>
                                                $post_like
                                            </span>
                                        </button>
                                    </li>
                                    
                                    <li>
                                        <a data-toggle='modal' data-target='#myModal' href='post.php?post_id=$post_id' target='_blank'>
                                            <button class='btn btn-outline-success'>
                                                <svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='currentColor' class='bi bi-chat-dots' viewBox='0 0 16 16'><path fill-rule='evenodd' d='M2.678 11.894a1 1 0 0 1 .287.801 10.97 10.97 0 0 1-.398 2c1.395-.323 2.247-.697 2.634-.893a1 1 0 0 1 .71-.074A8.06 8.06 0 0 0 8 14c3.996 0 7-2.807 7-6 0-3.192-3.004-6-7-6S1 4.808 1 8c0 1.468.617 2.83 1.678 3.894zm-.493 3.905a21.682 21.682 0 0 1-.713.129c-.2.032-.352-.176-.273-.362a9.68 9.68 0 0 0 .244-.637l.003-.01c.248-.72.45-1.548.524-2.319C.743 11.37 0 9.76 0 8c0-3.866 3.582-7 8-7s8 3.134 8 7-3.582 7-8 7a9.06 9.06 0 0 1-2.347-.306c-.52.263-1.639.742-3.468 1.105z'/><path d='M5 8a1 1 0 1 1-2 0 1 1 0 0 1 2 0zm4 0a1 1 0 1 1-2 0 1 1 0 0 1 2 0zm4 0a1 1 0 1 1-2 0 1 1 0 0 1 2 0z'/></svg>
                                                评论
                                            </button>
                                        </a>
                                    </li>

                                    <li>
                                        <a>
                                            <button data-toggle='modal' data-target='#myModal'class='btn btn-outline-success'>
                                                <svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='currentColor' class='bi bi-star' viewBox='0 0 16 16'><path fill-rule='evenodd' d='M2.866 14.85c-.078.444.36.791.746.593l4.39-2.256 4.389 2.256c.386.198.824-.149.746-.592l-.83-4.73 3.523-3.356c.329-.314.158-.888-.283-.95l-4.898-.696L8.465.792a.513.513 0 0 0-.927 0L5.354 5.12l-4.898.696c-.441.062-.612.636-.283.95l3.523 3.356-.83 4.73zm4.905-2.767l-3.686 1.894.694-3.957a.565.565 0 0 0-.163-.505L1.71 6.745l4.052-.576a.525.525 0 0 0 .393-.288l1.847-3.658 1.846 3.658a.525.525 0 0 0 .393.288l4.052.575-2.906 2.77a.564.564 0 0 0-.163.506l.694 3.957-3.686-1.894a.503.503 0 0 0-.461 0z'/></svg>
                                                收藏
                                            </button>
                                        </a>
                                    </li>
                                    
                                </ul>

                                <span style='float:right;margin-right:7%;margin-top:1%;font-size:0.1em;color:rgb(91, 112, 131);'><svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='currentColor' class='bi bi-eye' viewBox='0 -2 16 16'>
                                    <path fill-rule='evenodd' d='M16 8s-3-5.5-8-5.5S0 8 0 8s3 5.5 8 5.5S16 8 16 8zM1.173 8a13.134 13.134 0 0 0 1.66 2.043C4.12 11.332 5.88 12.5 8 12.5c2.12 0 3.879-1.168 5.168-2.457A13.134 13.134 0 0 0 14.828 8a13.133 13.133 0 0 0-1.66-2.043C11.879 4.668 10.119 3.5 8 3.5c-2.12 0-3.879 1.168-5.168 2.457A13.133 13.133 0 0 0 1.172 8z'/>
                                    <path fill-rule='evenodd' d='M8 5.5a2.5 2.5 0 1 0 0 5 2.5 2.5 0 0 0 0-5zM4.5 8a3.5 3.5 0 1 1 7 0 3.5 3.5 0 0 1-7 0z'/>
                                    </svg>&nbsp;&nbsp;<span>$post_view</span>
                                </span>

                                <div style='clear:both'></div>
                                ";
                            }

                    
                            echo "
                            <div class='col-md-12' style='padding:10px;padding-bottom:5px;border-top: 1px solid #f0f2f7;'>
                                <div id='post-img'style='float:right;'>
                                    <a id='post_img'href='../post.php?post_id=$post_id' target='_blank'><span>$post_img</span></a>
                                </div>
                                <div style='width:100%'>
                                    <br>
                                    <a id='image' href='../profile.php?u_id=$user_id' target='_blank' style='font-size:1em;'>
                                        <img src='../$user_image' style='width:35px;border-radius:5px;'> 
                                    </a>
                                    <a id='name' href='../profile.php?u_id=$user_id' target='_blank'style='font-size:1.1em;color:#646464'>
                                        <b style='line-height:1.4;font-size:1.3em;'>
                                            $user_name
                                        </b>
                                    </a>
                                    $post_date
                                    <br>
                                    <a id='content' href='../post.php?post_id=$post_id' target='_blank' style='margin-left:13%;font-size:15px'>
                                        $post_content
                                    </a>
                                </div>
                                <br>
                                <div style='clear:both'></div>
                            </div>
                            <div id='$post_id'>
                            $showZan
                            </div>";
                            }
                        }
                        echo '
                        </div>
                        </div>';
                        
                    include('include/rightbar.php');
            }

        ?>
    </div>
</body>
<?php include("baidu_js_push.php") ?>
</html>
<?php
    if (isset($_POST['answer-content'])) {
        $question = $row_question['question'];
        $content = addslashes($_POST['answer-content']);
        $insert = "Insert into posts 
        (user_id, post_content,post_title, post_date,type) 
        values('$u_id', '$content','$question', NOW(),'answer')";
        mysqli_query($con, "set names 'utf8'");
        $run = mysqli_query($con, $insert);
        
        $update_question = "update `question` set `is_answered`='yes' where `question`= '$question' ";
        $ruan_update =mysqli_query($con, $update_question);
        if ($run) {
            echo mysqli_error($con)."<script>alert('发布成功')</script>";
            echo "<script>window.open('post.php?qu_id=$get_id','_self')</script>";

            $update = "update users set 
            posts='yes' where user_id='$u_id'";
            $run_update = mysqli_query($con, $update);
        }else {
            echo "<script>alert('发布失败')</script>";
            //mysqli_error($con);
            echo "<script>window.open('home.php','_self')</script>";
        }
    }
?>