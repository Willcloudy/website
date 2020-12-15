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
    if (isset($_GET['post_id'])) {
        $get_id = $_GET['post_id'];

        $get_posts = "select * from posts where post_id='$get_id'";

        $run_posts = mysqli_query($con, $get_posts);

        $row_posts = mysqli_fetch_array($run_posts);

        $post_id = $row_posts['post_id'];
        $u_id = $row_posts['user_id'];
        $content = $row_posts['post_content'];
        $title = $row_posts['post_title'];
        $post_date = $row_posts['post_date'];
        $keyword = $row_posts['post_title'];
        $post_date = date('Y-m-d',strtotime($post_date));

        $writer = "select * from users where user_id = '$u_id' AND posts ='yes'";

        $run_writer = mysqli_query($con, $writer);
        $row_writer = mysqli_fetch_array($run_writer);
        $user_name = $row_writer['user_name'];
        $user_image =$row_writer['user_image'];
        $user_des = $row_writer['user_des'];
        $post_date = wordTime($post_date);
        $type='post';
    }elseif (isset($_GET['qu_id'])) {
        $get_id = $_GET['qu_id'];

        $get_question = "select * from question where qu_id='$get_id'";

        $run_question = mysqli_query($con, $get_question);

        $row_question = mysqli_fetch_array($run_question);

        $u_id = $row_question['user_id'];
        $question = $row_question['question'];
        $keyword = $row_question['question'];
        $get_answer = "select * from answer where qu_id='$get_id'";

        $post_date = $row_question['qu_date'];
    
        $post_date = date('Y-m-d',strtotime($post_date));

        $writer = "select * from users where user_id = '$u_id' AND posts ='yes'";

        $run_writer = mysqli_query($con, $writer);
        $row_writer = mysqli_fetch_array($run_writer);
        $user_name = $row_writer['user_name'];
        $user_image =$row_writer['user_image'];
        $user_des = $row_writer['user_des'];
        $post_date = wordTime($post_date);
        $type='question';
    } else {
        header('location:home.php');
    }
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
    <title><?php echo "$keyword - WillCloudy" ?></title>
    <link rel="stylesheet" href="css/css.css">
    <style>
    p{  
        font-size:1.3em;
        margin-top:5%;
        margin:10px;
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
                //echo "<script>document.getElementById('login').click()</script>";
            }
       ?> <?php
            if ($type=='post') {
                echo "
                <div class='col-md-6 midbar' style='padding:0;'>
                    <div class='content'>
                        <h3 style='font-weight:bold;margin-left:1%;padding:8px'>$title</h3>
                        <a href='profile.php?u_id=$u_id'><img id='home-profile'src='$user_image' style='margin-left:4%'alt='profile' width='45px'class='img-circle'></a>
                        <a href='profile.php?u_id=$u_id' style='font-weight:bold;color:rgb(91, 112, 131);margin-left:1%;font-size:1.4em;margin-bottom:5px;'>$user_name</a>
                        <span style='font-size:0.8em;display:inline-block;color:rgb(91, 112, 131);margin-top:10px;'>$user_des</span>
                        <span style='float:right;margin-right:20px;font-size:0.7em;'>发布时间: $post_date</span>
                        <hr>    
                        $content
                    </div>
                </div>";
            }elseif ($type='question') {
                echo "
                <div class='col-md-6 midbar' style='padding:0;'>
                    <div class='content'>
                        <h3 style='font-weight:bold;margin-left:1%;padding:8px;display:inline-block'>$question</h3>
                        <span style='float:right;margin-top:30px;margin-right:20px;font-size:0.7em;'>发布时间: $post_date</span>
                        <hr>
                    </div>
                </div>";
            }
            
        ?>
        <?php
            require('include/rightbar.php');
        ?>
    </div>
</body>
<?php include_once("baidu_js_push.php") ?>
</html>