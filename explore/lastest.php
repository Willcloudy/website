<?php
    session_start();
    include('../include/connection.php');
    $webpage = 2;
    
date_default_timezone_set('PRC');

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
        $str = date('Y/m/d',strtotime($time));
        }
        return $str;
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
    <title>最新 - willcloudy</title>
    <link rel="stylesheet" href="../css/css.css">
    <link rel="stylesheet" type="text/css" media="screen" href="https://cdn.staticfile.org/ionicons/2.0.1/css/ionicons.min.css">

    <style>
        #post_img img{
            height:115px;
            border-radius:10px;
            margin-right:20px;
        }
        .col-md-12 a{
            color:#121212;
        }
        .col-md-12 a:hover{
            text-decoration: none;
            color:#068ab6;
        }
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
                font-size:0.6em;
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
                }
            ?>
            <div class="col-md-6 midbar" style='padding:0'id='mid'>
                <div class="box">
                    <form action="result.php" method="POST">
                        <span>
                            <input style='margin:2% 3%;width:90%;margin-bottom: 0px;'class='form-control search' type="text" name='searchcontent' autocomplete="off" placeholder="关于留学的问题？" required='required'>
                        </span>
                            <span class="glyphicon glyphicon-search glyphicon-search-explore"></span>
                            <a href="result.php"><button class='form-control search-btn btn btn-primary'type='submit'></button></a>
                        
                    </form>
                    <div>
                        <ul id="myTab" class="nav nav-tabs ">
                            <li><a href="hot.php">#热榜</a></li>
                            <li class="active"><a href="#rb" data-toggle="tab">#最新</a></li>
                            <li><a href="oversealife.php">#海外生活</a></li>
                            <li><a href="apply.php">#留学申请</a></li>
                        </ul>
                        <div id="myTabContent" class="tab-content">
                            <div class="tab-pane fade in active" id="zx">
                                <?php
                                    $get_posts = "select * from posts ORDER by post_date desc";

                                    $run_posts = mysqli_query($con, $get_posts);
                                    echo mysqli_error($con);
                                    while($row = mysqli_fetch_array($run_posts)){
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
                                        $user_id = $row['user_id'];
                                        $post_like = $row['post_like'];
                                        $post_date = wordTime($post_date);
                                        $writer = "select * from users where user_id = '$user_id' AND posts ='yes'";
                                        $run_writer = mysqli_query($con, $writer);
                                        $row_writer = mysqli_fetch_array($run_writer);

                                        $user_name = $row_writer['user_name'];
                                        $user_image =$row_writer['user_image'];
                                        $user_des = $row_writer['user_des'];
                                        
                                        echo "
                                            <div class='col-md-12' style='padding:10px;border-bottom: 1px solid #f0f2f7;border-top: 1px solid #f0f2f7;'>
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
                                                        <img src='../$user_image' class='img-circle' style='width:5%;'> 
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
                                                
                                            </div>
                                        ";
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
    ele.style.color ="#00BFFF";
    ele.onmouseover =  function () {
    this.style.backgroundColor = "white";
    }

    var rightbar = document.getElementById('topic');
    rightbar.style.display='block';
    document.getElementById('other').style.display='none'
    document.getElementById('topic').style.marginTop= "60px"
    document.getElementById('search-small').style.display='none'
</script>