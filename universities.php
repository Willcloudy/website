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
    <title>院校库 - willcloudy</title>
    <link rel="stylesheet" href="css/css.css">
</head>
<style>
    .selectednation{
        width:30%;
        height:34px;
        border:1px solid #ccc;
        border-radius:15px;
        padding-left:3%;
        background-color:rgb(235, 238, 240);
        color:rgb(91, 112, 131);
    }
    .selectednation:focus{
        border:1px solid #00BFFF;
        background-color:white;
        box-shadow: inset 0 1px 1px rgba(0,0,0,.075), 0 0 8px rgba(102,175,233,.6);
        outline:none;
    }
    .uni-search-btn:focus{
        outline:none;
    }
</style>
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
            <div class="col-md-6 midbar" >
                <div class="box" >
                    <form action="universities.php" method="POST">
                        <span>
                            <label for="searchcontent" style='display:inline;margin-top:5%;'>学校名字 : </label>
                            <input class='form-control search' autoComplete='off'type="text" name='searchcontent' placeholder='搜索你心仪大学(中英文名字都可)' style='width:60%;padding:2%;border-radius:15px 0px 0px 15px;'required='required'/>
                            <button class='uni-search-btn' 
                                style='position:absolute;top:20px;height:34px;
                                border:2px solid #00BFFF;background-color:white;font-weight:bold;color:#00BFFF;border-radius:0 15px 15px 0;font-size:1em'>
                                <span class="glyphicon glyphicon-search" ></span>搜索
                            </button>
                        </span>
                    </form>
                    <br>
                    <form action="country.php" method="GET">
                        <span>
                            <label for="searchcontent" style='display:inline;margin-top:5%;'>地理位置 : </label>
                            <select class='selectednation' name="selectednation" required='required' style='width:40%' id="selectednation">
                                <option disable>请选择一个国家</option>
                                <option value="UK">英国</option>
                                <option value="AUS">澳大利亚</option>
                                <option value="CAN">加拿大</option>
                            </select>
                            <button class='uni-search-btn' style='height:34px;font-weight:bold;border-radius:15px;border:2px solid #00BFFF;background-color:white;color:#00BFFF;font-size:1.1em'><span class="glyphicon glyphicon-search"></span>搜索</button>
                        </span>
                        <div style="clear:both;"></div>
                    </form>
                    
                    <?php
                        if (isset($_POST['searchcontent'])) {
                            $input = $_POST['searchcontent'];
                            echo '<hr><h4 style="font-weight:bold;text-align:center"><small>搜索</small> "'.$input.'" <small>的结果</small></h4>';
                            $recommend_query = "SELECT * FROM `university` where uni_name_en like '%$input%' OR uni_name_zh like '%$input%'";
                            if (!$run_recommend = mysqli_query($con, $recommend_query)) {
                                echo "
                                <h5 style='font-weight:bold;text-align:center'>没有你想要的学校？<a href=#>点此反馈</h5>";
                            }else{
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
                        }else {
                            echo '
                            <hr>';
                            $uni_info_query = "SELECT * FROM `university` order by uni_rank asc" ;
                            $run_uni_info = mysqli_query($con, $uni_info_query);
                            echo mysqli_error($con);
                            while($uni_info = mysqli_fetch_array($run_uni_info)){
                                $uni_name_en = $uni_info['uni_name_en'];
                                $uni_country = $uni_info['uni_country'];
                                $uni_location = $uni_info['uni_location'];
                                $uni_icon = $uni_info['uni_icon'];
                                $uni_link = $uni_info['uni_link'];
                                $uni_name_zh = $uni_info['uni_name_zh'];
                                $uni_rank = $uni_info['uni_rank'];
                                echo "
                                <div class='col-md-13'>
                                    <ul style='list-style:none;padding-left:20px;padding-top:2px'>
                                        <li>
                                            <div class='uni-mini-info'>
                                                <div style='float:left;'>
                                                    <br>
                                                    <a href='info.php?uni_name_zh=$uni_name_zh'><img src='$uni_icon' alt='' width='120px' height='120px' style='margin-left:10px'></a>
                                                </div>
                                                <div class='uni-mini-word-info'>
                                                    <br>
                                                    <h4 style='margin-left:10px;display:inline-block'><a href='info.php?uni_name_zh=$uni_name_zh'>$uni_name_zh</a></h4>
                                                    <span style='font-size:5px;color:grey'>$uni_name_en</span>
                                                    <div><h5 style='float:right;margin-right: 52px;'><b>排名:$uni_rank</b></h5></div>
                                                    <ul style='list-style:none'>
                                                        <li><p>国家/Country:<a href='country.php?country=$uni_country'>$uni_country</a></p></li>
                                                        <li><p>所在地/Location: $uni_location</p></li>
                                                        <li><p>官网: <a href='$uni_link' target='_blank'>$uni_link</a></p></li>
                                                        <li><br></li>
                                                    </ul>   
                                                    <div style='clear:both'></div>
                                                </div>
                                            </div>
                                        </li>
                                    </ul>
                                </div>";
                            }
                        }
                    ?>
                </div>
            </div>
        <?php
            // echo "<footer style='text-align:center;'>当前在线".$users_online."人<footer>";
            require('include/rightbar.php');
        ?>
    </div>
</body>
</html>

<script>
    var ele = document.getElementById("ranking");
    ele.href="javascript:void(0);";
    ele.style.color ="#00BFFF";
    ele.onmouseover =  function () {
    this.style.backgroundColor = "white";
    }
    
</script>