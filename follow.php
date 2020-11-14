<?php
    session_start();
    header('Content-type: text/html; charset=utf-8');
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
    <link rel="stylesheet" href="css/home.css">
    <style>
        .hometop{
            font-weight:bold;
            font-size:20px;
            margin:7px;
            
        }
        .nav1,.nav2,.nav3{
            margin:10px;
        }
        .nav1 a,.nav2 a,.nav3 a{
            color:black;
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
            <div class="col-md-6">
                <div class="box">
                    <nav class='hometop'>
                        <span class='nav1'><a href="../website">推荐</a></span>
                        <span class='nav2' ><a href='' id='active'>关注</a></span>
                        <span class='nav3'><a href="trend.php">趋势</a></span> 
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