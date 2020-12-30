<?php
    session_start();
    if (!isset($_POST['searchcontent'])) {
        header('location:explore');
    }elseif($_POST['searchcontent'] == ''){
        header('location:explore');
    }
    include('include/connection.php');
    $input = $_POST['searchcontent'];
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
    <link rel="stylesheet" href="https://cdn.staticfile.org/twitter-bootstrap/3.3.7/css/bootstrap.min.css">  
    <script src="https://cdn.staticfile.org/jquery/2.1.1/jquery.min.js"></script>
    <script src="https://cdn.staticfile.org/twitter-bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <title>搜索'<?php echo $input?>'结果 - willcloudy</title>
    <link rel="stylesheet" href="css/css.css">
</head>
<body>
    <div class="container">
            <?php 
                if (isset($_SESSION['user_email'])) {
                    $user = $_SESSION['user_email'];
                    $get_user = "select * from users where user_email = '$user'";
                    mysqli_query($con, "set names 'utf8'");
                    $run_user = mysqli_query($con, $get_user);
                    mysqli_query($con, "set names 'utf8'");
                    $row = mysqli_fetch_array($run_user);
                    $u_name = $row['user_name'];
                    $u_image = $row['user_image'];
                    $u_id = $row['user_id'];
                    require('include/leftbar.php');
                    echo "
                        <script>
                            var profile = document.getElementById('profile');
                            profile.style.display='block';
                            document.getElementById('sign').style.display='none' 
                        </script>";
                }else {
                    require('include/leftbar.php');                    
                    echo "<script>document.getElementById('sign').style.display='block' </script>";

                }
            ?>
            <div class="col-md-6 midbar" style='padding:0;'>
                <div class="box">
                    <form action="result.php" method="POST">
                        <span>
                            <input style='margin:2% 3%;width:90%;margin-bottom: 0px;'class='form-control search' type="text" name='searchcontent' autocomplete="off" value="<?php echo $input ?>" required='required'>
                        </span>
                        <span class="glyphicon glyphicon-search glyphicon-search-explore"></span>
                        <a href="result.php"><button class='form-control search-btn btn btn-primary'type='submit'></button></a>
                    </form>
                    <div>
                        <ul id="myTab" class="nav nav-tabs ">
                            <li class="active"><a href="#zh" data-toggle="tab">文章</a></li>
                            <li><a href="#yh" data-toggle="tab">用户</a></li>
                            <li><a href="#wt" data-toggle="tab">问题</a></li>
                            <li><a href="#xx" data-toggle="tab">学校</a></li>
                        </ul>
                        <div id="myTabContent" class="tab-content">
                            <hr style='margin:0 5px;height:3px;color:black'>
                            <div class="tab-pane fade in active" id="zh" style='min-height:250px'>
                                <?php
                                    $zh_select = "SELECT * FROM `posts` WHERE `post_title` like '%$input%' or `post_content` like '%$input%'";
                                    $run_posts = mysqli_query($con, $zh_select);
                                    echo mysqli_error($con);
                                    mysqli_query($con, "set names 'utf8'");
                                    if (mysqli_num_rows($run_posts) < 1){
                                        echo '<h5 style="font-weight:bold;text-align:center;margin-top:100px">抱歉，查询无结果</h5>';
                                    }else {
                                        while ($row = mysqli_fetch_array($run_posts) ) {
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


                                                $post_user_name = $row_writer['user_name'];
                                                $post_user_image = $row_writer['user_image'];

                                                echo "
                                                <div class='col-md-12' style='padding:10px;padding-bottom:5px;border-top: 1px solid #f0f2f7;'>
                                                    <div id='post-img'style=''>
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
                                                            <img src='../$post_user_image' class='img-circle' style='width:20px;'> 
                                                        </a>
                                                        <a id='name' href='../profile.php?u_id=$user_id' target='_blank'style='font-size:1.1em;'>
                                                            $post_user_name  
                                                        </a>
                                                        :
                                                        <a id='content' href='../post.php?post_id=$post_id' target='_blank'>
                                                            $post_content
                                                        </a>
                                                    </div>
                                                    
                                                </div>
                                                <ul class='article-function'>
                                                <li>
                                                <button  type='button' class='btn btn-primary'>
                                                    <svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='currentColor' class='bi bi-heart-fill' viewBox='0 0 16 16'>
                                                    <path fill-rule='evenodd' d='M8 1.314C12.438-3.248 23.534 4.735 8 15-7.534 4.736 3.562-3.248 8 1.314z'></path>
                                                    </svg>";
                                                    if ($post_like == null) {
                                                        echo "点赞";
                                                    }else {
                                                        echo $post_like;
                                                    }           
                                                            
                                                    echo    "</button>
                                                </button>
                                            </li>
                                            <li><a href='post.php?post_id=$post_id' target='_blank'><button class='btn btn-outline-success'><svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='currentColor' class='bi bi-chat-dots' viewBox='0 0 16 16'><path fill-rule='evenodd' d='M2.678 11.894a1 1 0 0 1 .287.801 10.97 10.97 0 0 1-.398 2c1.395-.323 2.247-.697 2.634-.893a1 1 0 0 1 .71-.074A8.06 8.06 0 0 0 8 14c3.996 0 7-2.807 7-6 0-3.192-3.004-6-7-6S1 4.808 1 8c0 1.468.617 2.83 1.678 3.894zm-.493 3.905a21.682 21.682 0 0 1-.713.129c-.2.032-.352-.176-.273-.362a9.68 9.68 0 0 0 .244-.637l.003-.01c.248-.72.45-1.548.524-2.319C.743 11.37 0 9.76 0 8c0-3.866 3.582-7 8-7s8 3.134 8 7-3.582 7-8 7a9.06 9.06 0 0 1-2.347-.306c-.52.263-1.639.742-3.468 1.105z'/><path d='M5 8a1 1 0 1 1-2 0 1 1 0 0 1 2 0zm4 0a1 1 0 1 1-2 0 1 1 0 0 1 2 0zm4 0a1 1 0 1 1-2 0 1 1 0 0 1 2 0z'/></svg>评论</button></a></li>
                                            <li><a><button class='btn btn-outline-success'><svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='currentColor' class='bi bi-star' viewBox='0 0 16 16'><path fill-rule='evenodd' d='M2.866 14.85c-.078.444.36.791.746.593l4.39-2.256 4.389 2.256c.386.198.824-.149.746-.592l-.83-4.73 3.523-3.356c.329-.314.158-.888-.283-.95l-4.898-.696L8.465.792a.513.513 0 0 0-.927 0L5.354 5.12l-4.898.696c-.441.062-.612.636-.283.95l3.523 3.356-.83 4.73zm4.905-2.767l-3.686 1.894.694-3.957a.565.565 0 0 0-.163-.505L1.71 6.745l4.052-.576a.525.525 0 0 0 .393-.288l1.847-3.658 1.846 3.658a.525.525 0 0 0 .393.288l4.052.575-2.906 2.77a.564.564 0 0 0-.163.506l.694 3.957-3.686-1.894a.503.503 0 0 0-.461 0z'/></svg>收藏</button></a></li>
                                            
                                                </ul>
                                                <span style='float:right;margin-right:8%;margin-top:1%;font-size:0.1em;color:rgb(91, 112, 131);'><svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='currentColor' class='bi bi-eye' viewBox='0 -2 16 16'>
                                                    <path fill-rule='evenodd' d='M16 8s-3-5.5-8-5.5S0 8 0 8s3 5.5 8 5.5S16 8 16 8zM1.173 8a13.134 13.134 0 0 0 1.66 2.043C4.12 11.332 5.88 12.5 8 12.5c2.12 0 3.879-1.168 5.168-2.457A13.134 13.134 0 0 0 14.828 8a13.133 13.133 0 0 0-1.66-2.043C11.879 4.668 10.119 3.5 8 3.5c-2.12 0-3.879 1.168-5.168 2.457A13.133 13.133 0 0 0 1.172 8z'/>
                                                    <path fill-rule='evenodd' d='M8 5.5a2.5 2.5 0 1 0 0 5 2.5 2.5 0 0 0 0-5zM4.5 8a3.5 3.5 0 1 1 7 0 3.5 3.5 0 0 1-7 0z'/>
                                                    </svg>&nbsp;&nbsp;<span>$post_view</span></span>
                                                    <div style='clear:both'></div>
                                                <div style='clear:both'></div>
                                            ";
                                        }
                                    }
                                ?>
                            </div>

                            <div class="tab-pane fade" id="yh" style='min-height:250px'>
                                <?php
                                    $yh_select = "SELECT * FROM `users` WHERE `user_name` like '%$input%'";
                                    $run_yh = mysqli_query($con, $yh_select);
                                    echo mysqli_error($con);
                                    mysqli_query($con, "set names 'utf8'");
                                    echo mysqli_error($con);
                                    if (mysqli_num_rows($run_yh) < 1 ){
                                        echo '<h5 style="font-weight:bold;text-align:center;margin-top:100px">抱歉，查询无结果</h5>';
                                    }elseif((mysqli_num_rows($run_yh) >= 1 )) {
                                        while ($row = mysqli_fetch_array($run_yh)) {
                                            $user_id = $row['user_id'];
                                            $user_name = $row['user_name'];
                                            $user_des = $row['user_des'];
                                            $user_image = $row['user_image'];
                                            $user_cover = $row['user_cover'];
                                            echo "
                                            <div class='col-md-12' style='padding:10px;border-top: 1px solid #f0f2f7;background-image:url($user_cover)'>
                                                <div style='float:left;margin-left:20px;'>
                                                    <a id='image' href='profile.php?u_id=$user_id' target='_blank'><span><img class='img-circle'src='$user_image' width='60px'></span></a>
                                                </div>
                                                <div style='float:left;margin-left:30px;margin-top:15px;'>
                                                    <a href='profile.php?u_id=$user_id' target='_blank'>
                                                        <b style='line-height:1.4;font-size:1.3em;color:black;'>
                                                            $user_name
                                                        </b>
                                                        <small>
                                                            $user_des
                                                        </small>
                                                    </a>
                                                </div>
                                                <div style='clear:both'></div>
                                            </div>";
                                        }
                                    }
                                ?>
                            </div>

                            <div class="tab-pane fade" id="wt" style='min-height:250px'>
                                <?php
                                    $wt_select = "SELECT * FROM `question` WHERE `question` like '%$input%'";
                                    $run_wt = mysqli_query($con, $wt_select);
                                    echo mysqli_error($con);
                                    mysqli_query($con, "set names 'utf8'");
                                    echo mysqli_error($con);
                                    if (mysqli_num_rows($run_wt) < 1 ){
                                        echo '<h5 style="font-weight:bold;text-align:center;margin-top:100px">抱歉，查询无结果</h5>';
                                    }elseif((mysqli_num_rows($run_wt) >= 1 )) {
                                        while ($row = mysqli_fetch_array($run_wt)) {
                                            $qu_id = $row['qu_id'];
                                            $question = $row['question'];
                                            // if(preg_match('/<\s*img\s+[^>]*?src\s*=\s*(\'|\")(.*?)\\1[^>]*?\/?\s*>/i',$post_content,$match)){
                                            // $post_img = $match[0];
                                            // }else {
                                            //     $post_img = null;
                                            // }
                                            // $post_content = strip_tags($post_content);
                                            // if (strlen($post_content) > 50) {
                                            //     $post_content = mb_substr($post_content,0, 60)."..<a href='../post.php?post_id=$post_id' target='_blank'>查看全文</a>";
                                            // }
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
                                            <div class='col-md-12' style='padding:10px;padding-bottom:5px;border-top: 1px solid #f0f2f7;'>
                                                <div style='width:100%'>
                                                
                                                    <a id='image' href='../profile.php?u_id=$user_id' target='_blank' style='font-size:1em;'>
                                                        <img src='../$user_image' class='img-circle' style='width:30px;'> 
                                                    </a>
                                            
                                                    <a id='name' href='../profile.php?u_id=$user_id' target='_blank'style='rgb(91, 112, 131);font-size:1em;font-weight:bold'>
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
                                                <a>
                                                    <button class='btn btn-primary'>
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
                                                                    <a href='../post.php?qu_id=$qu_id' target='_blank'>
                                                                        <button id='click_like'>
                                                                            <svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='currentColor' class='bi bi-menu-up' viewBox='0 0 16 16'>
                                                                                <path fill-rule='evenodd' d='M15 3.207v9a1 1 0 0 1-1 1h-3.586A2 2 0 0 0 9 13.793l-1 1-1-1a2 2 0 0 0-1.414-.586H2a1 1 0 0 1-1-1v-9a1 1 0 0 1 1-1h12a1 1 0 0 1 1 1zm-13 11a2 2 0 0 1-2-2v-9a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v9a2 2 0 0 1-2 2h-3.586a1 1 0 0 0-.707.293l-1.353 1.354a.5.5 0 0 1-.708 0L6.293 14.5a1 1 0 0 0-.707-.293H2z'/>
                                                                                <path fill-rule='evenodd' d='M15 5.207H1v1h14v-1zm0 4H1v1h14v-1zm-13-5.5a.5.5 0 0 0 .5.5h6a.5.5 0 1 0 0-1h-6a.5.5 0 0 0-.5.5zm0 4a.5.5 0 0 0 .5.5h11a.5.5 0 0 0 0-1h-11a.5.5 0 0 0-.5.5zm0 4a.5.5 0 0 0 .5.5h8a.5.5 0 0 0 0-1h-8a.5.5 0 0 0-.5.5z'/>
                                                                            </svg>
                                                                            回答$num
                                                                        </button>
                                                                    </a>
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
                                            </ul>
                                            <div style='clear:both'></div>
                                        ";
                                        }
                                    }
                                ?>
                            </div>

                            <div class="tab-pane fade" id="xx" style='min-height:250px'>
                                <?php
                                    $xx_select = "SELECT * FROM `university` WHERE `uni_name_en` like '%$input%' or 'zh' like '%$input%'";
                                    $run_xx = mysqli_query($con, $xx_select);
                                    echo mysqli_error($con);
                                    mysqli_query($con, "set names 'utf8'");
                                    echo mysqli_error($con);
                                    if (mysqli_num_rows($run_xx) < 1 ){
                                        echo "<br>
                                            <h5 style='font-weight:bold;text-align:center;margin-top:80px;'>没有你想要的学校？<a href=#>点此反馈</h5>
                                            <br>";
                                    }elseif((mysqli_num_rows($run_xx) >= 1 )) {
                                        while($row = mysqli_fetch_array($run_xx)){
                                            $uni_name_en = $row['uni_name_en'];
                                            $uni_name_zh = $row['zh'];
                                            $uni_country = $row['uni_country'];
                                            $uni_location = $row['uni_location'];
                                            $uni_icon = $row['icon'];
                                            $uni_link = $row['uni_link'];
                                            $qs_rank = $row['qs_rank'];
                                            echo "
                                            <div class='col-md-13'>
                                            <ul style='list-style:none;padding-left:20px;padding-top:2px'>
                                                <li>
                                                    <div class='uni-mini-info'>
                                                        <div style='float:left;'>
                                                            <a id='uni-img' href='topics.php?uni_name_zh=$uni_name_zh'><img src='$uni_icon'></a>
                                                        </div>
                                                        <div class='rank-info' style='padding:5px;'>
                                                            <h4 id='uni_name'style='margin-left:38px'><a href='topics.php?uni_name_zh=$uni_name_zh'> $uni_name_en $uni_name_zh</a></h4>
                                                            <div><h5 style='float:right;margin-right: 52px;'><b>排名:$qs_rank</b></h5></div>
                                                            <ul style='list-style:none'>
                                                                <li><p>所在地/Location: $uni_location</p></li>
                                                                <li><p>国家:<a href='country.php?selectednation=$uni_country'>$uni_country</a></p></li>
                                                                <li><p>官网: <a href='$uni_link' target='_blank'>$uni_link</a></p></li>
                                                                <li><br></li>
                                                            </ul>
                                                            <div style='clear:both'></div>
                                                        </div>
                                                    </div>
                                                </li>
                                            </ul>
                                        </div>
                                                
                                                    ";
                                        }
                                        echo "<br>
                                            <h5 style='font-weight:bold;text-align:center'>没有你想要的学校？<a href=#>点此反馈</h5>
                                            <br>";
                                    }
                                ?>
                            </div>
                            
                        </div>
                    </div>
                </div>  
            </div>
            <?php
                // echo "<footer style='text-align:center;'>当前在线".$users_online."人<footer>";
                require('include/rightbar.php');
            ?>
    </div>
</body>
</html>