<?php
    session_start();
    if (!isset($_POST['searchcontent'])) {
        header('location:search.php');
    }elseif($_POST['searchcontent'] == ''){
        header('location:search.php');
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
    <title>搜索结果 - WillCloudy</title>
    <link rel="stylesheet" href="css/home.css">
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
                    <h3 style='font-weight:bold;'>Result/搜索结果</h3>
                    <hr>
                    <form action="" method="POST">
                        <span>
                            <input class='form-control search' type="text" name='searchcontent' style='font-size:20px'placeholder='搜索你心仪大学(中英文名字都可)'>
                        </span>
                        <span class='span2'>
                            <button class='form-control search-btn btn btn-primary'type='submit'><span class="glyphicon glyphicon-search"></span> Search</button>
                        </span>
                        <div style="clear:both;"></div>
                        <br>
                    </form>
                    <hr>
                    <h4 style='font-weight:bold;text-align:center'>搜索"<?php echo $input;?>"的结果</h4>
                    <?php
                        $recommend_query = "SELECT * FROM `university` where uni_name_en like '%$input%' OR uni_name_zh like '%$input%'";
                        if (!$run_recommend = mysqli_query($con, $recommend_query)) {
                            echo "
                            <hr>
                            <h5 style='font-weight:bold;text-align:center'>没有你想要的学校？<a href=#>点此反馈</h5>";
                        }else {
                            while(@$row = mysqli_fetch_array($run_recommend)){
                                $uni_name_en = $row['uni_name_en'];
                                $uni_name_zh = $row['uni_name_zh'];
                                $uni_country = $row['uni_country'];
                                $uni_location = $row['uni_location'];
                                $uni_icon = $row['uni_icon'];
                                $uni_link = $row['uni_link'];

                                $insert_search_num = "UPDATE rank SET search_rank = search_rank + 1 WHERE uni_name_zh = '$uni_name_zh'";
                                $run_query = mysqli_query($con, $insert_search_num);
                                echo mysqli_error($con);
                                
                                echo "
                                    <div class='col-md-13'>
                                        <ul style='list-style:none;padding-left:20px;padding-top:2px'>
                                            <li>
                                                <div class='toprank'>
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
                            
                            echo "<hr>
                            <h5 style='font-weight:bold;text-align:center'>没有你想要的学校？<a href=#>点此反馈</h5>";
                        }
                        
                    ?>
                    
                    <br>
                    <br>    
                </div>  
            </div>
            <?php
                // echo "<footer style='text-align:center;'>当前在线".$users_online."人<footer>";
                require('include/rightbar.php');
            ?>
    </div>
</body>
</html>