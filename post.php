<?php
    session_start();
    include('include/connection.php');
    $webpage = 1;
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
        $u_id = $row_posts['user_id'];
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
        $writer = "select * from users where user_id = '$u_id' AND posts ='yes'";
        mysqli_query($con, "set names 'utf8'");

        $run_writer = mysqli_query($con, $writer);
        $row_writer = mysqli_fetch_array($run_writer);
        $user_name = $row_writer['user_name'];
        $user_image =$row_writer['user_image'];
        $user_des = $row_writer['user_des'];
        $post_date = wordTime($post_date);
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

        $u_id = $row_question['user_id'];
        $question = $row_question['question'];
        $keyword = $row_question['question'];
        $get_answer = "select * from answer where qu_id='$get_id'";
        $qu_des = $row_question['qu_des'];
        mysqli_query($con, "set names 'utf8'");

        $post_date = $row_question['qu_date'];
    
        $post_date = date('Y-m-d',strtotime($post_date));

        $writer = "select * from users where user_id = '$u_id'";
        mysqli_query($con, "set names 'utf8'");

        $run_writer = mysqli_query($con, $writer);
        $row_writer = mysqli_fetch_array($run_writer);
        $user_name = $row_writer['user_name'];
        $user_image =$row_writer['user_image'];
        $user_des = $row_writer['user_des'];
        $post_date = wordTime($post_date);
        $type='question';

        if(!isset($_COOKIE["visittime"])){ 
        
            setcookie("visittime",date("y-m-d H:i:s"));
            setcookie("visitcount",1);
            $question_view = "UPDATE `question` SET `qu_view` =+ 1 WHERE qu_id = $get_id";
            $update_view = mysqli_query($question_view);
        }
    }else {
        header('location:home.php');
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

                //echo "<script>document.getElementById('login').click()</script>";
            }
       ?> <?php
            if ($type=='post') {
                echo "
                <div class='col-md-6 midbar' style='padding:0 10px;'>
                    <div class='content'>
                        <h3 style='font-weight:bold;margin-left:1%;padding:8px'>$title</h3>
                        <a href='profile.php?u_id=$u_id'><img id='home-profile'src='$user_image' style='margin-left:4%;' alt='profile' width='30px'class='img-circle'></a>
                        <a href='profile.php?u_id=$u_id' style='font-weight:bold;color:rgb(91, 112, 131);margin-left:1%;font-size:1em;margin-bottom:5px;'>$user_name</a>
                        <span style='font-size:0.6em;display:inline-block;color:rgb(91, 112, 131);margin-top:10px;'><small>$user_des</small></span>
                        <span style='float:right;margin-right:20px;font-size:0.1em;color:rgb(91, 112, 131);'><small>发布时间: $post_date</small></span>
                        <br>
                        <span style='float:left;margin-left:63px;font-size:0.1em;color:rgb(91, 112, 131);'><svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='currentColor' class='bi bi-eye' viewBox='0 -2 16 16'>
                        <path fill-rule='evenodd' d='M16 8s-3-5.5-8-5.5S0 8 0 8s3 5.5 8 5.5S16 8 16 8zM1.173 8a13.134 13.134 0 0 0 1.66 2.043C4.12 11.332 5.88 12.5 8 12.5c2.12 0 3.879-1.168 5.168-2.457A13.134 13.134 0 0 0 14.828 8a13.133 13.133 0 0 0-1.66-2.043C11.879 4.668 10.119 3.5 8 3.5c-2.12 0-3.879 1.168-5.168 2.457A13.133 13.133 0 0 0 1.172 8z'/>
                        <path fill-rule='evenodd' d='M8 5.5a2.5 2.5 0 1 0 0 5 2.5 2.5 0 0 0 0-5zM4.5 8a3.5 3.5 0 1 1 7 0 3.5 3.5 0 0 1-7 0z'/>
                        </svg>&nbsp;&nbsp;<span>$post_view</span></span>
                        <hr margin:10px;> 
                        <div id='posted_img'>
                        $content
                        </div>
                    </div>
                    <div style='clear:both'></div>
                    <hr style='margin:10px 0 0'>";
                    if (isset($u_id)) {
                        $is_liked = "SELECT * from like_post where user_id ='$u_id' and post_id='$post_id'";
                        $run_liked = mysqli_query($con,$is_liked);
                        if (mysqli_num_rows($run_liked) !== 0) {
                            echo "
                            <ul class='article-function'>
                            <li style='margin-left:10px'>
                                <button id='$post_id' name='$post_id'  style='color:red;background-color:white;' class='btn btn-primary liked_post'>
                                    <svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='currentColor' class='bi bi-heart-fill' viewBox='0 0 16 16'>
                                    <path fill-rule='evenodd' d='M8 1.314C12.438-3.248 23.534 4.735 8 15-7.534 4.736 3.562-3.248 8 1.314z'></path>
                                    </svg>
                                    <span id=$u_id>
                                    $post_like
                                    </span>
                                </button>
                            </li>
                            <li><a href='#let_comment'><button class='btn btn-outline-success'><svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='currentColor' class='bi bi-chat-dots' viewBox='0 0 16 16'><path fill-rule='evenodd' d='M2.678 11.894a1 1 0 0 1 .287.801 10.97 10.97 0 0 1-.398 2c1.395-.323 2.247-.697 2.634-.893a1 1 0 0 1 .71-.074A8.06 8.06 0 0 0 8 14c3.996 0 7-2.807 7-6 0-3.192-3.004-6-7-6S1 4.808 1 8c0 1.468.617 2.83 1.678 3.894zm-.493 3.905a21.682 21.682 0 0 1-.713.129c-.2.032-.352-.176-.273-.362a9.68 9.68 0 0 0 .244-.637l.003-.01c.248-.72.45-1.548.524-2.319C.743 11.37 0 9.76 0 8c0-3.866 3.582-7 8-7s8 3.134 8 7-3.582 7-8 7a9.06 9.06 0 0 1-2.347-.306c-.52.263-1.639.742-3.468 1.105z'/><path d='M5 8a1 1 0 1 1-2 0 1 1 0 0 1 2 0zm4 0a1 1 0 1 1-2 0 1 1 0 0 1 2 0zm4 0a1 1 0 1 1-2 0 1 1 0 0 1 2 0z'/></svg>评论</button></a></li>
                            <li><a><button class='btn btn-outline-success'><svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='currentColor' class='bi bi-star' viewBox='0 0 16 16'><path fill-rule='evenodd' d='M2.866 14.85c-.078.444.36.791.746.593l4.39-2.256 4.389 2.256c.386.198.824-.149.746-.592l-.83-4.73 3.523-3.356c.329-.314.158-.888-.283-.95l-4.898-.696L8.465.792a.513.513 0 0 0-.927 0L5.354 5.12l-4.898.696c-.441.062-.612.636-.283.95l3.523 3.356-.83 4.73zm4.905-2.767l-3.686 1.894.694-3.957a.565.565 0 0 0-.163-.505L1.71 6.745l4.052-.576a.525.525 0 0 0 .393-.288l1.847-3.658 1.846 3.658a.525.525 0 0 0 .393.288l4.052.575-2.906 2.77a.564.564 0 0 0-.163.506l.694 3.957-3.686-1.894a.503.503 0 0 0-.461 0z'/></svg>收藏</button></a></li>
                            <span style='float:right;margin-right:8%;margin-top:1%;font-size:0.1em;color:rgb(91, 112, 131);'><svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='currentColor' class='bi bi-eye' viewBox='0 -2 16 16'>
                                    <path fill-rule='evenodd' d='M16 8s-3-5.5-8-5.5S0 8 0 8s3 5.5 8 5.5S16 8 16 8zM1.173 8a13.134 13.134 0 0 0 1.66 2.043C4.12 11.332 5.88 12.5 8 12.5c2.12 0 3.879-1.168 5.168-2.457A13.134 13.134 0 0 0 14.828 8a13.133 13.133 0 0 0-1.66-2.043C11.879 4.668 10.119 3.5 8 3.5c-2.12 0-3.879 1.168-5.168 2.457A13.133 13.133 0 0 0 1.172 8z'/>
                                    <path fill-rule='evenodd' d='M8 5.5a2.5 2.5 0 1 0 0 5 2.5 2.5 0 0 0 0-5zM4.5 8a3.5 3.5 0 1 1 7 0 3.5 3.5 0 0 1-7 0z'/>
                                    </svg>&nbsp;&nbsp;<span>$post_view</span>
                                </span>
                                </ul>
                                
                                <div style='clear:both'></div>
                            ";
                        }else{
                            echo "
                            <ul class='article-function'>
                            <li style='margin-left:10px'>
                                <button id='post$post_id' name='$post_id'  class='btn btn-outline-success like_post'>
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
                                    <li><a href='#let_comment'><button class='btn btn-outline-success'><svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='currentColor' class='bi bi-chat-dots' viewBox='0 0 16 16'><path fill-rule='evenodd' d='M2.678 11.894a1 1 0 0 1 .287.801 10.97 10.97 0 0 1-.398 2c1.395-.323 2.247-.697 2.634-.893a1 1 0 0 1 .71-.074A8.06 8.06 0 0 0 8 14c3.996 0 7-2.807 7-6 0-3.192-3.004-6-7-6S1 4.808 1 8c0 1.468.617 2.83 1.678 3.894zm-.493 3.905a21.682 21.682 0 0 1-.713.129c-.2.032-.352-.176-.273-.362a9.68 9.68 0 0 0 .244-.637l.003-.01c.248-.72.45-1.548.524-2.319C.743 11.37 0 9.76 0 8c0-3.866 3.582-7 8-7s8 3.134 8 7-3.582 7-8 7a9.06 9.06 0 0 1-2.347-.306c-.52.263-1.639.742-3.468 1.105z'/><path d='M5 8a1 1 0 1 1-2 0 1 1 0 0 1 2 0zm4 0a1 1 0 1 1-2 0 1 1 0 0 1 2 0zm4 0a1 1 0 1 1-2 0 1 1 0 0 1 2 0z'/></svg>评论</button></a></li>
                                    <li><a><button class='btn btn-outline-success'><svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='currentColor' class='bi bi-star' viewBox='0 0 16 16'><path fill-rule='evenodd' d='M2.866 14.85c-.078.444.36.791.746.593l4.39-2.256 4.389 2.256c.386.198.824-.149.746-.592l-.83-4.73 3.523-3.356c.329-.314.158-.888-.283-.95l-4.898-.696L8.465.792a.513.513 0 0 0-.927 0L5.354 5.12l-4.898.696c-.441.062-.612.636-.283.95l3.523 3.356-.83 4.73zm4.905-2.767l-3.686 1.894.694-3.957a.565.565 0 0 0-.163-.505L1.71 6.745l4.052-.576a.525.525 0 0 0 .393-.288l1.847-3.658 1.846 3.658a.525.525 0 0 0 .393.288l4.052.575-2.906 2.77a.564.564 0 0 0-.163.506l.694 3.957-3.686-1.894a.503.503 0 0 0-.461 0z'/></svg>收藏</button></a></li>
                                    <span style='float:right;margin-right:8%;margin-top:1%;font-size:0.1em;color:rgb(91, 112, 131);'><svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='currentColor' class='bi bi-eye' viewBox='0 -2 16 16'>
                                            <path fill-rule='evenodd' d='M16 8s-3-5.5-8-5.5S0 8 0 8s3 5.5 8 5.5S16 8 16 8zM1.173 8a13.134 13.134 0 0 0 1.66 2.043C4.12 11.332 5.88 12.5 8 12.5c2.12 0 3.879-1.168 5.168-2.457A13.134 13.134 0 0 0 14.828 8a13.133 13.133 0 0 0-1.66-2.043C11.879 4.668 10.119 3.5 8 3.5c-2.12 0-3.879 1.168-5.168 2.457A13.133 13.133 0 0 0 1.172 8z'/>
                                            <path fill-rule='evenodd' d='M8 5.5a2.5 2.5 0 1 0 0 5 2.5 2.5 0 0 0 0-5zM4.5 8a3.5 3.5 0 1 1 7 0 3.5 3.5 0 0 1-7 0z'/>
                                            </svg>&nbsp;&nbsp;<span>$post_view</span>
                                        </span>
                                        </ul>
                                        
                                        <div style='clear:both'></div>
                                    ";
                            }
                    }else {
                        echo "<br><br>";
                    }
                if ($login !== 0) {
                    echo "
                    <form method='POST' action='' style=''>
                        <input id=let_comment style='float:left;width:74%;margin:0;padding-left:15px;'class='form-control search' type='text' maxlength='500' name='comment' autocomplete='off' required='required' placeholder='请输入你的评论'>
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
                    <br>";
                }
                $get_com = "select * from comment where post_id='$get_id' ORDER by 1 DESC";
                echo mysqli_error($con);
                $run_com = mysqli_query($con, $get_com);
                echo mysqli_error($con);
                if (isset($run_com)) {
                    echo "<div style='border:1px solid #ccc;padding:5px;border-radius:10px;'>
                            <h5>评论</h5>";
                    while($row = mysqli_fetch_array($run_com)){
                        $com = $row['comment'];
                        $con_name = $row['comment_author'];
                        $date = $row['comment_date'];
                        $user_id = $row['author_id'];

                        $date = wordTime($date);
                        $user_query = "Select * from `users` where user_id = $user_id";
                        $run_user = mysqli_query($con, $user_query);
                        $row_user = mysqli_fetch_array($run_user);
                        $user_image = $row_user['user_image'];

                        echo "
                        <hr style='margin:5px 0;'>
                            <div style=''>
                                <a href='profile.php?u_id=$user_id'><img src='$user_image' class='img-circle' style='float:left;width:30px'></a>
                                <div style='margin-left:5px;margin-top:5px;float:left;'>
                                    <a href='profile.php?u_id=$user_id'><span style='font-size:13.5px;color:#555666'>$user_name</span></a>:   
                                    <span style='margin-left:5px;font-size:13.5px;color:black'>
                                    $com</span>
                                </div>
                                <span style='float:right;font-weight:normal;margin-top:5px;'>$date</span>
                                <div style='clear:both'></div>
                            </div>
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
            }
            elseif ($type='question') {
                
                echo "
                <div class='col-md-6 midbar' style='padding:0;'>
                    <div class='content'>
                        <h3 style='font-weight:bold;margin-left:1%;padding:8px;display:inline-block'>$question</h3>
                        <span style='float:right;margin-top:30px;margin-right:20px;font-size:0.7em;'>发布时间: $post_date</span>
                        ";
                        if (!empty($qu_des)) {
                        echo $qu_des;}
                echo "<hr>
                    ";
                ?>
            <div id='write-box'>
                <a data-toggle='modal' data-target='#answer_question'>
                    <input type='text' autoComplete='off'  required placeholder='点此处以回答这个问题' maxlength='20' style='width:75%;border:1px solid #ccc !important;border-radius:10px' name='question' id='question-title'>
                    <button id='question'>回答</button></a>
                </a>
            </div>
            <hr>    
            <br>
            <div class="modal fade" id="answer_question" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content"style='width:100%'>
                        <div class="modal-body" >
                            <button type="button" class='close'data-dismiss="modal" aria-hidden="true" >
                                &times;
                            </button>
                            <div class="question-form" >
                                <form action="post.php" method="POST">
                                    <div id="answer-toolbar" class= "toolbar post"></div>
                                    <div id="answer-text" class="text"></div>
                                    <textarea required id="text2" name="answer-content" style="width:100%; height:200px;display:none"></textarea>
                                    <br>
                                    <button id="goWrite" type="submit">发布</button></a>
                                </form>
                            </div>
                        </div>
                    </div><!-- /.modal-content -->
                </div><!-- /.modal -->
            </div>
            </div>
                </div>
            <?php
                }
            ?>
        <?php
            require('include/rightbar.php');
        ?>
    </div>
</body>
<?php include_once("baidu_js_push.php") ?>
</html>

<?php
    $question = $question;
    if (!empty($_POST['answer-content'])) {
        $content = addslashes($_POST['answer-content']);
        $insert = "Insert into posts 
        (user_id, post_content,post_title, post_date,type) 
        values('$u_id', '$content','$question', NOW(),'answer')";
        mysqli_query($con, "set names 'utf8'");

        $run = mysqli_query($con, $insert);
        echo mysqli_error($con);
        if ($run) {
            echo "<script>alert('发布成功')</script>";
            echo "<script>window.open('home.php','_self')</script>";

            $update = "update users set 
            posts='yes' where user_id='$u_id'";
            $run_update = mysqli_query($con, $update);
        }else {
            echo "<script>alert('发布失败')</script>";
            mysqli_error($con);
            //echo "<script>window.open('home.php','_self')</script>";
        }
    }
?>
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
    $text2.val(editor2.txt.html())
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