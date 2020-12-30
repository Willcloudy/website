<?php
    session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://cdn.staticfile.org/twitter-bootstrap/3.3.7/css/bootstrap.min.css">  
    <script src="https://cdn.staticfile.org/jquery/2.1.1/jquery.min.js"></script>
    <script src="https://cdn.staticfile.org/twitter-bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <title>大学专业 - willcloudy</title>
    <link rel="stylesheet" href="css/css.css">
    <style>
        ul{
            list-style-type:none;
            font-size:17px;
            font-weight:bold;
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
                                        echo "<script>document.getElementById('sign').style.display='block' </script>";

                }
            ?>
            <div class="col-md-6 midbar">
                <div class="box" >
                    <h3 style='font-weight:bold;'>Major/看看学什么专业？</h3>
                    <hr class='hrmargin'>
                    <div class="row" >
                        <div class="col-md-7">
                            <h4 style='font-weight:bold;'>商业管理与经济</h4>
                            <ul>
                                <li><a href="">经济</a></li>
                                <li><a href="">管理</a></li>
                                <li><a href="">金融</a></li>
                                <li><a href="">财务会计</a></li>
                                <li><a href="">市场营销</a></li>
                                <li><a href="">人力资源与组织管理</a></li>
                            </ul>
                        </div>
                        <div class="col-md-5">
                            <h4 style='font-weight:bold;'>工程与技术</h4>
                            <ul>
                                <li><a href="">机械,航空与制造工程</a></li>
                                <li><a href="">土木工程</a></li>
                                <li><a href="">化学,物理和材料工程</a></li>
                                <li><a href="">电子电气工程</a></li>
                                <li><a href="">计算机与通信工程</a></li>
                                <li><a href="">生物医药工程</a></li>
                            </ul>
                        </div>
                        <div class="col-md-7">
                            <h4 style='font-weight:bold;'>计算机与信息科学</h4>
                            <ul>
                                <li><a href="">计算与计算机科学</a></li>
                                <li><a href="">网络与信息技术</a></li>
                                <li><a href="">软件</a></li>
                                <li><a href="">动漫与游戏</a></li>
                                <li><a href="">计算机工程</a></li>
                            </ul>
                        </div>
                        <div class="col-md-5">
                            <h4 style='font-weight:bold;'>文化传媒与艺术</h4>
                            <ul>
                                <li><a href="">新闻与传播</a></li>
                                <li><a href="">广告与公共关系</a></li>
                                <li><a href="">影视与多媒体</a></li>
                                <li><a href="">美术与设计</a></li>
                                <li><a href="">视觉与创意艺术</a></li>
                                <li><a href="">音乐，舞蹈与表演</a></li>
                            </ul>
                        </div>
                        <div class="col-md-7">
                            <h4 style='font-weight:bold;'>建筑与规划</h4>
                            <ul>
                                <li><a href="">建筑</a></li>
                                <li><a href="">环境园林景观</a></li>
                                <li><a href="">规划与设计</a></li>
                                <li><a href="">建造与管理</a></li>
                            </ul>
                        </div>
                        <div class="col-md-5">
                            <h4 style='font-weight:bold;'>科学与应用科学</h4>
                            <ul>
                                <li><a href="">数学与统计</a></li>
                                <li><a href="">地理</a></li>
                                <li><a href="">生物</a></li>
                                <li><a href="">物理</a></li>
                                <li><a href="">化学</a></li>
                                <li><a href="">食品与营养科学</a></li>
                            </ul>
                        </div>
                        <div class="col-md-7">
                            <h4 style='font-weight:bold;'>教育与人文社科</h4>
                            <ul>
                                <li><a href="">语言与语言学</a></li>
                                <li><a href="">心理学</a></li>
                                <li><a href="">文学，历史与哲学</a></li>
                                <li><a href="">社会学</a></li>
                                <li><a href="">法律</a></li>
                                <li><a href="">政治</a></li>
                            </ul>
                        </div>
                        <div class="col-md-5">
                            <h4 style='font-weight:bold;'>医学与健康科学</h4>
                            <ul>
                                <li><a href="">医学</a></li>
                                <li><a href="">药剂学</a></li>
                                <li><a href="">健康科学</a></li>
                                <li><a href="">护理与助产</a></li>
                                <li><a href="">兽医</a></li>
                                <br>
                            </ul>
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