<?php
    session_start();
    include('include/connection.php');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta name="description" content="WillCloudy是一个可以帮助想要出国留学的学生快速获取心仪学校的环境和入学条件及各种信息的网站，并且有很多毕业大学生来分享他们个人的亲身经历，这是一个面向留学生的社交性质的交流平台。" />
    <meta name="keywords" content="留学,qs大学排名,论坛,英国留学,加拿大留学,澳大利亚留学,出国留学,留学生" />
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1"/>  
    <script src="https://cdn.staticfile.org/jquery/2.1.1/jquery.min.js"></script>
    <link rel="stylesheet" href="https://cdn.staticfile.org/twitter-bootstrap/3.3.7/css/bootstrap.min.css"/>
    <script src="https://cdn.staticfile.org/twitter-bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <title>首页 - WillCloudy</title>
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
                $user_name = $row['user_name'];
                $user_image = $row['user_image'];

                require('include/leftbar.php');
                echo "
                    <script>
                        var profile = document.getElementById('profile');
                        profile.style.display='block';
                        document.getElementById('sign').style.display='none'; 
                        var profileMo = document.getElementById('profileMo');
                        profileMo.style.display='block';
                    </script>";
            }else {
                require('include/leftbar.php');
                echo "<script>document.getElementById('sign').click()</script>";
            }
        ?>
        <div class="col-md-6 midbar">
            <div class="box">
                <nav id='hometop'>
                    <span class='homespan'><a href='' id='active'>推荐</a></span>
                    <span class='homespan'><a href="follow.php">关注</a></span>
                    <span class='homespan'><a href="trend.php">趋势</a></span>
                    <span class='homespan'id='sjrank'><a href='ranking'>大学排名</a></span>
                    <span class='homespan'id='sjsearch'><a href="search.php">搜索</a></span> 
                </nav>
                <hr class='hrmargin'>
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
    document.getElementById("active").style.color = "#00BFFF";
</script>
