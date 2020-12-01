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
            <div class="col-md-6 midbar" id='mid'>
                <div class="box">
                    <h3 style='font-weight:bold;'>Search/搜索</h3>
                    <hr class='hrmargin'>
                    <form action="result.php" method="POST">
                        <span>
                            <input class='form-control search' type="text" name='searchcontent' style='font-size:20px'placeholder='搜索你心仪大学(中英文名字都可)' required='required'>
                        </span>
                        <span class='span2'>
                            <a href="result.php"><button class='form-control search-btn btn btn-primary'type='submit'><span class="glyphicon glyphicon-search"></span> Search</button></a>
                        </span>
                        <div style="clear:both;"></div>
                        <br>
                    </form>
                    <hr>
                    <h4 style='font-weight:bold;text-align:center'>University RCMD/学校推荐</h4>
                    <?php
                        $recommend_query = "SELECT * FROM `university` ORDER BY Rand() LIMIT 10";
                        $run_recommend = mysqli_query($con, $recommend_query);
                        while($row = mysqli_fetch_array($run_recommend)){
                            $uni_name_en = $row['uni_name_en'];
                            $uni_name_zh = $row['uni_name_zh'];
                            $uni_country = $row['uni_country'];
                            $uni_location = $row['uni_location'];
                            $uni_icon = $row['uni_icon'];
                            $uni_link = $row['uni_link'];

                            echo "
                            <div class='col-md-13'>
                                <ul style='list-style:none;padding-left:20px;padding-top:2px'>
                                    <li>
                                        <div class='uni-mini-info'>
                                            <div style='float:left;'>
                                                <br>
                                                <a href='info.php?uni_name_zh=$uni_name_zh'><img src='$uni_icon' alt='' width='120px' height='120px' style='margin-left:10px;margin-bottom:15px;'></a>
                                            </div>
                                            <div class='uni-mini-word-info'>
                                                <br>
                                                <h4 style='margin-left:38px'><a href='info.php?uni_name_zh=$uni_name_zh'> $uni_name_en $uni_name_zh</a></h4>
                                                <ul style='list-style:none'>
                                                    <li><p>所在地/Location: $uni_location in <a href='country.php?country=$uni_country'>$uni_country</a></p></li>
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
                    ?>
                    
                    <br>
                    <br>    
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
    ele.href="javascript:volid(0);";
    //ele.style.backgroundColor = "rgb(181,212,213)";
    ele.style.color ="#00BFFF";
    ele.onmouseover =  function () {
    this.style.backgroundColor = "white";
    }
</script>