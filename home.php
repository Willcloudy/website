<?php
    session_start();
    include('include/connection.php');
    $webpage = 1;
    if (isset($_SESSION['user_email'])) {
        $user = $_SESSION['user_email'];
        $get_user = "select * from users where user_email = '$user'";
        $run_user = mysqli_query($con, $get_user);
        $row = mysqli_fetch_array($run_user);
        $u_name = $row['user_name'];
        $u_image = $row['user_image'];
        $u_id = $row['user_id'];
        $login = 1;
        
    }else {
        $login=0;
    }
?>
<!DOCTYPE html>
<html>
<head>
    <meta name="description" content="WillCloudy是一个可以帮助想要出国留学的学生快速获取心仪学校的环境和入学条件及各种信息的网站，并且有很多毕业大学生来分享他们个人的亲身经历，这是一个面向留学生的社交性质的交流平台。" />
    <meta name="keywords" content="加拿大留学,英国留学,欧洲留学,留学经验分享,IDY留学,留学申请,留学流程,留学费用,出国留学,留学论坛,留学网站,留学考试,GRE,TOEFL,IBT,GMAT,IELTS,SAT,VISA,文书,签证" />
    <meta charset="utf-8"/>
    <meta charset="utf-8" name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1, maximum-scale=1, user-scalable=no"/>
    <script src="https://cdn.staticfile.org/jquery/2.1.1/jquery.min.js"></script>
    <link rel="stylesheet" href="https://cdn.staticfile.org/twitter-bootstrap/3.3.7/css/bootstrap.min.css"/>
    <script src="https://cdn.staticfile.org/twitter-bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <title><?php 
        if ($login == 0) {
            echo "willcloudy - 海内外留学生交流社区";
        }else{
           echo "主页 - WillCloudy";} ?></title>
    <link rel="stylesheet" href="css/css.css">
    <style>
        #write-box{
            margin-top:10px;
            padding-left:2%;
        }
        .toolbar {
            width:85%;
            border-top:1px solid #ccc;
            border-bottom:1px solid #ccc;
            z-index: 2 !important;
        }
        .text{
            min-height:50px;
            width:85%;
            z-index: 1 !important;
        }
        .text:hover{
            /* border-left:1px solid #00BFFF;
            border-right:1px solid #00BFFF;
            border-bottom:1px solid #00BFFF; */
            /* border:1px solid #00BFFF; */
        }
        #goWrite,#question{
            /* position:absolute;
            top: 5px;  
            left: 510px; */
            font-weight:bold;
            font-size:1em;
            width:50px;
            height:30px;
            color:white;
            background:#00BFFF;
            border:1px solid #ccc;
            border-radius:10px;
        }
        #question{
            /* top:20px;
            left:490px; */
            width:70px;
            height:35px;
            margin-right:4%;
            margin-top:1%;
            float:right;
        }
        #write{
            float:right;
            margin-right:6.5%;
            color:grey;
        }
        #write:hover{
            color:#00BFFF;
            text-decoration:underline;
        }
        #goWrite:hover,#question:hover{
            color:#00BFFF;
            background:white;
            border:2px solid #ccc;
            transition:0.5s
        }
        #goWrite:focus,#question:focus{
            outline:none;
        }
        #home-profile{
            /* position:absolute;
            left: 15px;
            top: 14px; */
            float:left;
            border:1px solid #ccc;
        }
        #home-profile:hover{
            opacity:0.5;
        }
        .content{
            margin-top:10px;
        }
        #article-title, #question-title{
            border:none;
            padding:10px;
        }
        #article-title:focus{
            outline:none;
        }
        #question-title:focus{
            border-bottom:1px solid #00BFFF !important;
            outline:none;
            transition:0.5s;
        }
        @media(max-width:992px)
        {
            #home-profile{
                /* display:none; */
            }
            #question,#goWrite{
                
                width:53px;
            }
            #write-box{
                padding-left:1%;
            }
        }
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
                echo "<script>document.getElementById('login').click()</script>";
            }
       ?>   
        <div class="col-md-6 midbar" style='padding:0;'>
            <?php require('include/publish.php');?>
            <div class="content">
                <?php
                    
                    $get_posts = "select * from posts  ORDER BY RAND() LIMIT 10";
                
                    echo mysqli_error($con);
                    $run_posts = mysqli_query($con, $get_posts);
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
                            $post_content = mb_substr($post_content,0, 60)."..<a href='post.php?post_id=$post_id' target='_blank'>查看全文</a>";
                        }
                
                        $post_title = $row['post_title'];
                        $post_date = $row['post_date'];
                        $user_id = $row['user_id'];
                        $post_like = $row['post_like'];
                        //$post_date = wordTime($post_date);
                        $writer = "select * from users where user_id = '$user_id' AND posts ='yes'";
                        $run_writer = mysqli_query($con, $writer);
                        $row_writer = mysqli_fetch_array($run_writer);
                
                
                        $user_name = $row_writer['user_name'];
                        $user_image = $row_writer['user_image'];
                
                        echo "
                        <div class='col-md-12' style='padding:10px;padding-bottom:5px;border-top: 1px solid #f0f2f7;'>
                            <div id='post-img'style='float:left;'>
                                <a id='post_img'href='post.php?post_id=$post_id' target='_blank'><span>$post_img</span></a>
                            </div>
                            <div style='width:100%'>
                                <a href='post.php?post_id=$post_id' target='_blank'>
                                    <b style='line-height:1.4;font-size:1.3em;'>
                                        $post_title
                                    </b>
                                </a>
                                <br>
                                <a id='image' href='profile.php?u_id=$user_id' target='_blank' style='font-size:1em;'>
                                    <img src='$user_image' class='img-circle' style='width:20px;'> 
                                </a>
                                <a id='name' href='profile.php?u_id=$user_id' target='_blank'style='font-size:1.1em;'>
                                    $user_name  
                                </a>
                                :
                                <a id='content' href='post.php?post_id=$post_id' target='_blank'>
                                    $post_content
                                </a>
                            </div>
                            <div style='clear:both'></div>
                        </div>
                        <ul class='article-function'>
                            <li>
                                <button>
                                    <svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='currentColor' class='bi bi-heart' viewBox='0 0 16 16'>
                                    <path fill-rule='evenodd' d='M8 2.748l-.717-.737C5.6.281 2.514.878 1.4 3.053c-.523 1.023-.641 2.5.314 4.385.92 1.815 2.834 3.989 6.286 6.357 3.452-2.368 5.365-4.542 6.286-6.357.955-1.886.838-3.362.314-4.385C13.486.878 10.4.28 8.717 2.01L8 2.748zM8 15C-7.333 4.868 3.279-3.04 7.824 1.143c.06.055.119.112.176.171a3.12 3.12 0 0 1 .176-.17C12.72-3.042 23.333 4.867 8 15z'/>
                                    </svg>";
                                    if ($post_like == null) {
                                        echo "点赞";
                                    }else {
                                        echo $post_like;
                                    }           
                                               
                                    echo    "</button>
                            </li>
                            <li>
                                <button>
                                    <a href='post.php?post_id=$post_id' target='_blank'>
                                        <svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='currentColor' class='bi bi-chat-dots' viewBox='0 0 16 16'>
                                        <path fill-rule='evenodd' d='M2.678 11.894a1 1 0 0 1 .287.801 10.97 10.97 0 0 1-.398 2c1.395-.323 2.247-.697 2.634-.893a1 1 0 0 1 .71-.074A8.06 8.06 0 0 0 8 14c3.996 0 7-2.807 7-6 0-3.192-3.004-6-7-6S1 4.808 1 8c0 1.468.617 2.83 1.678 3.894zm-.493 3.905a21.682 21.682 0 0 1-.713.129c-.2.032-.352-.176-.273-.362a9.68 9.68 0 0 0 .244-.637l.003-.01c.248-.72.45-1.548.524-2.319C.743 11.37 0 9.76 0 8c0-3.866 3.582-7 8-7s8 3.134 8 7-3.582 7-8 7a9.06 9.06 0 0 1-2.347-.306c-.52.263-1.639.742-3.468 1.105z'/>
                                        <path d='M5 8a1 1 0 1 1-2 0 1 1 0 0 1 2 0zm4 0a1 1 0 1 1-2 0 1 1 0 0 1 2 0zm4 0a1 1 0 1 1-2 0 1 1 0 0 1 2 0z'/>
                                        </svg>
                                        评论
                                    </a>
                                </button>
                            </li>
                            <li>
                                <button>
                                    <a>
                                        <svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='currentColor' class='bi bi-star' viewBox='0 0 16 16'>
                                            <path fill-rule='evenodd' d='M2.866 14.85c-.078.444.36.791.746.593l4.39-2.256 4.389 2.256c.386.198.824-.149.746-.592l-.83-4.73 3.523-3.356c.329-.314.158-.888-.283-.95l-4.898-.696L8.465.792a.513.513 0 0 0-.927 0L5.354 5.12l-4.898.696c-.441.062-.612.636-.283.95l3.523 3.356-.83 4.73zm4.905-2.767l-3.686 1.894.694-3.957a.565.565 0 0 0-.163-.505L1.71 6.745l4.052-.576a.525.525 0 0 0 .393-.288l1.847-3.658 1.846 3.658a.525.525 0 0 0 .393.288l4.052.575-2.906 2.77a.564.564 0 0 0-.163.506l.694 3.957-3.686-1.894a.503.503 0 0 0-.461 0z'/>
                                        </svg>
                                        收藏
                                    </a>
                                </button>
                            </li>
                        </ul>
                        <div style='clear:both'></div>
                    ";
                    }
                    
                ?>
            </div>
        </div>
        <?php
            require('include/rightbar.php');
        ?>
    </div>
</body>
</html>
<script>
    document.getElementById("logo").href = "javascript:void(0);";
    var home = document.getElementById("home");
    home.href="javascript:void(0);";
    home.style.color ="#00BFFF";
    home.onmouseover =  function () {
        this.style.backgroundColor = "white";
    }
</script>

r