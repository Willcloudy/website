<?php
    session_start();
    if (!isset($_POST['searchcontent'])) {
        header('location:explore.php');
    }elseif($_POST['searchcontent'] == ''){
        header('location:explore.php');
    }
    include('include/connection.php');
    $input = $_POST['searchcontent'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://cdn.staticfile.org/twitter-bootstrap/3.3.7/css/bootstrap.min.css">  
    <script src="https://cdn.staticfile.org/jquery/2.1.1/jquery.min.js"></script>
    <script src="https://cdn.staticfile.org/twitter-bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <title>搜索'<?php echo $input?>'结果 - WillCloudy</title>
    <link rel="stylesheet" href="css/css.css">
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
                    require('include/leftbar.php');
                    echo "
                        <script>
                            var profile = document.getElementById('profile');
                            profile.style.display='block';
                            document.getElementById('sign').style.display='none' 
                        </script>";
                }else {
                    require('include/leftbar.php');
                }
            ?>
            <div class="col-md-6 midbar">
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
                            <li class="active"><a href="#dt" data-toggle="tab"></a></li>
                            <li><a href="#zx" data-toggle="tab">#最新</a></li>
                            <li><a href="#tj" data-toggle="tab">#推荐</a></li>
                            <li><a href="topic.php">查看更多#话题</a></li>
                        </ul>
                        <div id="myTabContent" class="tab-content">
                        <div class="tab-pane fade" id="zx">
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
                                        $post_content = mb_substr($post_content,0, 60)."..<a href='post.php?post_id=$post_id'>查看全文</a>";
                                    }

                                    $post_title = $row['post_title'];
                                    $post_date = $row['post_date'];
                                    $user_id = $row['user_id'];
                                    $post_like = $row['post_like'];

                                    $writer = "select * from users where user_id = '$user_id' AND posts ='yes'";
                                    $run_writer = mysqli_query($con, $writer);
                                    $row_writer = mysqli_fetch_array($run_writer);

                                    $user_name = $row_writer['user_name'];
                                    $user_image =$row_writer['user_image'];
                                    $user_des = $row_writer['user_des'];
                                    
                                    echo "
                                        <div class='col-md-12' style='padding:10px;border-bottom: 1px solid #f0f2f7;border-top: 1px solid #f0f2f7;'>
                                            <div id='post-img'style='float:left;'>
                                                <a id='post_img'href='post.php?post_id=$post_id'><span>$post_img</span></a>
                                            </div>
                                            <div style='width:100%'>
                                                <a href='post.php?post_id=$post_id'>
                                                    <b style='line-height:1.4;font-size:1.3em;'>
                                                        $post_title
                                                    </b>
                                                </a>
                                                <br>
                                                <a id='image' href='profile.php?u_id=$user_id' style='font-size:1em;'>
                                                    <img src='$user_image' class='img-circle' style='width:5%;'> 
                                                </a>
                                                <a id='name' href='profile.php?u_id=$user_id' style='font-size:1.1em;'>
                                                    $user_name  
                                                </a>
                                                :
                                                <a id='content' href='post.php?post_id=$post_id'>
                                                    $post_content
                                                </a>
                                            </div>
                                            <div style='clear:both'></div>
                                        </div>
                                    ";
                                }
                            ?>
                        </div>

                            <div class="tab-pane fade in active" id="dt">
                                
                            </div>

                            <div class="tab-pane fade" id="tj">
                                推荐
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