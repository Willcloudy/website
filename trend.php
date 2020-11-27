<?php
    session_start();
    include('include/connection.php');
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://cdn.staticfile.org/twitter-bootstrap/3.3.7/css/bootstrap.min.css">  
    <script src="https://cdn.staticfile.org/jquery/2.1.1/jquery.min.js"></script>
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
                            document.getElementById('sign').style.display='none' 
                        </script>";
                }else {
                    require('include/leftbar.php');
                }
            ?>
        <div class="col-md-6 midbar">
            <div class="box">
                <nav id='hometop'>
                    <span class='homespan'><a href='home.php'>推荐</a></span>
                    <span class='nav2 homespan'><a href="follow.php">关注</a></span>
                    <span class='homespan'><a href="trend.php"id='active'>趋势</a></span>
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
    document.getElementById("logo").href = "javascript:volid(0);";
    var ele = document.getElementById("home");
    ele.href="javascript:volid(0);";
    ele.style.color ="#00BFFF";
    ele.onmouseover =  function () {
    this.style.backgroundColor = "white";
    }
    
    document.getElementById("active").style.color = "#00BFFF";
</script>