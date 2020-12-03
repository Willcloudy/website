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
    <title>寻找心仪大学 - WillCloudy</title>
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
            <div class="col-md-6 midbar" style='padding:0'id='mid'>
                <div class="box">
                    <form action="result.php" method="POST">
                        <span>
                            <input style='margin:2% 3%;width:90%;margin-bottom: 0px;'class='form-control search' type="text" name='searchcontent' placeholder="what's happening " required='required'>
                        </span>
                            <span class="glyphicon glyphicon-search glyphicon-search-explore"></span>
                            <a href="result.php"><button class='form-control search-btn btn btn-primary'type='submit'></button></a>
                        
                    </form>
                    <div>
                        <ul id="myTab" class="nav nav-tabs ">
                            <li class="active"><a href="#dt" data-toggle="tab">趋势/Trend</a></li>
                            <li><a href="#tj" data-toggle="tab">为你推荐/Lastest</a></li>
                            <li><a href="#zx" data-toggle="tab">最新/Lastest</a></li>
                        </ul>
                        <div id="myTabContent" class="tab-content">
                            <div class="tab-pane fade in active" id="dt">
                                趋势
                            </div>

                            <div class="tab-pane fade" id="tj">
                                推荐
                            </div>

                            <div class="tab-pane fade" id="zx">
                                最新
                            </div>
                        </div>
                    </div>
                </div>  
            </div>
            <?php
                require('include/rightbar.php');
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
</script>