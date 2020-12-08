<?php  
    session_start();
    include('include/connection.php');
    if (empty($_GET['selectednation'])) {
        header('Location:home.php');
    }else {
        $country = $_GET['selectednation'];
        if ($country == 'England' || $country == 'UK') {
            $en_country = 'England';
            $cn_country = '英国';
        }elseif ($country == 'Canada' || $country == 'CAN') {
            $en_country = 'Canada';
            $cn_country = '加拿大';
        }elseif ($country == 'Australia' || $country == 'AUS') {
            $en_country = 'Australia';
            $cn_country = '澳大利亚';
        }else {
            header('Location:home.php');
        }
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
    <title><?php echo $cn_country?> - 积云</title>
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
                    <h3 style='font-weight:bold;float:left'><?php echo $cn_country."大学排名";?></h3>
                    <form style='float:right;margin-top:22px;margin-right:100px;'action="country.php" method="GET">
                        <span>
                            <select class='selectednation' name="selectednation" required='required' id="selectednation">
                                <option disable>更换国家</option>
                                <option value="UK">英国</option>
                                <option value="AUS">澳大利亚</option>
                                <option value="CAN">加拿大</option>
                            </select>
                            <button class='uni-search-btn' style='padding-bottom:20px;height:20px;font-weight:bold;border-radius:15px;border:2px solid #00BFFF;background-color:white;color:#00BFFF;font-size:1em'><span class="glyphicon glyphicon-search"></span>更换</button>
                        </span>
                        <div style="clear:both;"></div>
                    </form>
                    <div style='clear:both'></div>
                    <hr>
                </div>
                <?php
                    $recommend_query = "SELECT * FROM `university` where uni_country like '%$cn_country%'";
                    if (!$run_recommend = mysqli_query($con, $recommend_query)) {
                        echo "<h5 style='font-weight:bold;text-align:center'>没有你想要的学校？<a href=#>点此反馈</h5>";
                    }else {
                        while(@$row = mysqli_fetch_array($run_recommend)){
                            $uni_name_en = $row['uni_name_en'];
                            $uni_name_zh = $row['uni_name_zh'];
                            $uni_country = $row['uni_country'];
                            $uni_location = $row['uni_location'];
                            $uni_icon = $row['uni_icon'];
                            $uni_link = $row['uni_link'];

                            // $insert_search_num = "UPDATE rank SET search_rank = search_rank + 1 WHERE uni_name_zh = '$uni_name_zh'";
                            // $run_query = mysqli_query($con, $insert_search_num);
                            // echo mysqli_error($con);
                            
                            echo "
                                <div class='col-md-13'>
                                    <ul style='list-style:none;padding-left:20px;padding-top:2px'>
                                        <li>
                                            <div class='uni-mini-info'>
                                                <div style='float:left;'>
                                                    <br>
                                                    <a href='info.php?uni_name_zh=$uni_name_zh'><img src='$uni_icon' alt='' width='120px' height='120px' style='margin-left:10px;margin-bottom:15px;'></a>
                                                </div>
                                                <div class='rank-info'>
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
                        echo "<br>
                        <h5 style='font-weight:bold;text-align:center'>没有你想要的学校？<a href=#>点此反馈</h5>
                        <br>";
                    }
                

                

                ?>
            </div>
            <?php
                require('include/rightbar.php');
            ?>
            
    </div>
</body>
</html>

<script>

    document.getElementById('search-small').style.display='block'

</script>