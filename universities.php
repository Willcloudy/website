<?php 
    session_start();
    include('include/connection.php');
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta name="keywords" content="海外大学,美国大学,澳洲大学,加拿大大学,英国大学,积云,willcloudy" />
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://cdn.staticfile.org/twitter-bootstrap/3.3.7/css/bootstrap.min.css">  
    <script src="https://cdn.staticfile.org/jquery/2.1.1/jquery.min.js"></script>
    <script src="https://cdn.staticfile.org/twitter-bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <title>院校库 - willcloudy - 美国大学 - 澳洲大学 - 加拿大大学 - 英国大学</title>
    <link rel="stylesheet" href="css/css.css">
    <link rel="icon" type="image/x-ico" href="img/logo.ico" />
    <link rel="apple-touch-icon" sizes="180x180" href="/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/favicon-16x16.png">
    <link rel="manifest" href="/site.webmanifest">

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
        border:1px solid #198754;
        background-color:white;
        box-shadow: inset 0 1px 1px rgba(0,0,0,.075), 0 0 8px rgba(102,175,233,.6);
        outline:none;
    }
    .uni-search-btn:focus{
        outline:none;
    }
    .uni-search-btn:hover{
        background-color:#198754 !important;
        color:white !important;
    }
    #uni-img img{
        width:120px !important;
        height:120px;
        margin-left:10px;
        margin-bottom:15px;
        margin-right: 10px;
        margin-top: 20px;
    }
    @media(max-width:992px)
    {
        #uni-img img{
            display:none;
        }
        .uni-mini-word-info{
            margin-left:15px;
        }
        ul{
            padding-left:10px !important;
        }
        #uni_name{
            margin-left:10px !important;
        }
    }
</style>
<body>
    <div class="container">
            <?php 
                if (isset($_SESSION['user_email'])) {
                    $user = $_SESSION['user_email'];
                    $get_user = "select * from users where user_email = '$user'";
                    mysqli_query($con, "set names 'utf8'");
                    $run_user = mysqli_query($con, $get_user);
                    $row = mysqli_fetch_array($run_user);
                    mysqli_query($con, "set names 'utf8'");
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
                    echo "<script>document.getElementById('sign').style.display='block' </script>";

                }
            ?>
            <div class="col-md-6 midbar" >
                <div class="box" >
                    <form action="" method="GET">
                        <span>
                            <label for="searchcontent" style='display:inline;margin-top:5%;'>学校名字 : </label>
                            <input class='form-control search' autoComplete='off'type="text" name='searchcontent' placeholder='搜索你心仪大学(中英文名字都可)' style='width:60%;padding:2%;border-radius:15px 0px 0px 15px;'/>
                            <button class='uni-search-btn' 
                                style='position:absolute;top:20px;height:34px;
                                border:1px solid #198754;background-color:white;font-weight:bold;color:#198754;border-radius:0 15px 15px 0;font-size:0.95em'>
                                <span class="glyphicon glyphicon-search" ></span>搜索
                            </button>
                        </span>
                    </form>
                    <br>
                    <form action="country.php" method="GET">
                        <span>
                            <label for="searchcontent" style='display:inline;margin-top:5%;'>地理位置 : </label>
                            <select class='selectednation' name="selectednation" required='required' style='width:40%' id="selectednation" onchange="window.location=this.value">
                                <option disable>更换国家</option>
                                <option value="country.php?selectednation=UK">英国</option>
                                <option value="country.php?selectednation=CAN">澳大利亚</option>
                                <option value="country.php?selectednation=AUS">加拿大</option>
                            </select>
                        </span>
                        <div style="clear:both;"></div>
                    </form>
                    <br>
                    <label for="searchcontent" style='display:inline;margin-top:5%;'>排名顺序 : </label>
                    <select class='selectednation' name="selectednation" required='required' style='width:22%;padding:8px;' id="selectednation" onchange="window.location=this.value">
                        <?php
                            if (@$_GET['rank'] == 'qs') {
                        ?>
                        <option value="universities.php?rank=qs">QS大学排名</option>
                        <option value="universities.php">全部</option>
                        <?php
                            }elseif (@$_GET['rank'] == 'all' or empty(@$_GET['rank'])) {
                        ?>
                        <option value="universities.php">全部</option>
                        <option value="universities.php?rank=qs">QS大学排名</option>
                        <?php
                            }
                        ?>

                    </select>
                    <?php
                    include('include/get_post.php');
                    get_university();
                    
                        // if (!empty($_GET['searchcontent'])) {
                        //     $input = $_GET['searchcontent'];
                        //     echo '<hr><h4 style="font-weight:bold;text-align:center"><small>搜索</small> "'.$input.'" <small>的结果</small></h4>';
                        //     $recommend_query = "SELECT * FROM `university` where uni_name_en like '%$input%' OR zh like '%$input%'";
                        //     if (!$run_recommend = mysqli_query($con, $recommend_query)) {
                        //         echo mysqli_error($con)."
                        //         <h5 style='font-weight:bold;text-align:center'>没有你想要的学校？<a href=#>点此反馈</h5>";
                        //     }else{
                        //         while(@$row = mysqli_fetch_array($run_recommend)){
                        //             $uni_name_en = $row['uni_name_en'];
                        //             $uni_name_zh = $row['zh'];
                        //             $uni_country = $row['uni_country'];
                        //             $uni_location = $row['uni_location'];
                        //             $uni_icon = $row['icon'];
                        //             $uni_link = $row['uni_link'];
                        //             $insert_search_num = "UPDATE rank SET search_rank = search_rank + 1 WHERE uni_name_zh = '$uni_name_zh'";
                        //             $run_query = mysqli_query($con, $insert_search_num);
                        //             echo mysqli_error($con);
                                    
                        //             echo "
                        //             <div class='col-md-13'>
                        //             <ul style='list-style:none;padding-left:20px;padding-top:2px'>
                        //                 <li>
                        //                     <div class='uni-mini-info'>
                        //                         <div style='float:left;'>
                        //                             <a id='uni-img' href='topics.php?uni_name_zh=$uni_name_zh'><img src='$uni_icon'></a>
                        //                         </div>
                        //                         <div class='rank-info'>
                        //                             <h4 id='uni_name'style='margin-left:38px'><a href='topics.php?uni_name_zh=$uni_name_zh'> $uni_name_en $uni_name_zh</a></h4>
                        //                             <ul style='list-style:none'>
                        //                                 <li><p>所在地/Location: $uni_location</p></li>
                        //                                 <li><p>国家:<a href='country.php?country=$uni_country'>$uni_country</a></p></li>
                        //                                 <li><p>官网: <a href='$uni_link' target='_blank'>$uni_link</a></p></li>
                        //                                 <li><br></li>
                        //                             </ul>
                        //                             <div style='clear:both'></div>
                        //                         </div>
                        //                     </div>
                        //                 </li>
                        //             </ul>
                        //         </div>
                                        
                        //                     ";
                        //         }
                        //         echo mysqli_error($con)."<br>
                        //         <h5 style='font-weight:bold;text-align:center'>没有你想要的学校？<a href=#>点此反馈</h5>
                        //         <br>";
                        //     }
                        // }else {
                        //     echo '
                        //     <hr>';
                        //     $uni_info_query = "SELECT * FROM `university` order by uni_rank asc" ;
                        //     $run_uni_info = mysqli_query($con, $uni_info_query);
                        //     echo mysqli_error($con);
                        //     while($uni_info = mysqli_fetch_array($run_uni_info)){
                        //         $uni_name_en = $uni_info['uni_name_en'];
                        //         $uni_country = $uni_info['uni_country'];
                        //         $uni_location = $uni_info['uni_location'];
                        //         $uni_icon = $uni_info['icon'];
                        //         $uni_link = $uni_info['uni_link'];
                        //         $uni_name_zh = $uni_info['zh'];
                        //         $uni_rank = $uni_info['uni_rank'];
                        //         echo "
                        //         <div class='col-md-13'>
                        //             <ul style='list-style:none;padding-left:20px;padding-top:2px'>
                        //                 <li>
                        //                     <div class='uni-mini-info'>
                        //                         <div style='float:left;'>
                        //                             <br>
                        //                             <a id='uni-img' href='topics.php?uni_name_zh=$uni_name_zh'><img src='$uni_icon'></a>
                        //                         </div>
                        //                         <div class='uni-mini-word-info'>
                        //                             <br>
                        //                             <h4 style='display:inline-block'><a href='topics.php?uni_name_zh=$uni_name_zh'>$uni_name_zh</a></h4>
                        //                             <span style='font-size:5px;color:grey'>$uni_name_en</span>
                        //                             <div><h5 style='float:right;margin-right: 52px;'><b>排名:$uni_rank</b></h5></div>
                        //                             <ul style='list-style:none'>
                        //                                 <li><p>国家/Country:<a href='country.php?country=$uni_country'>$uni_country</a></p></li>
                        //                                 <li><p>所在地/Location: $uni_location</p></li>
                        //                                 <li><p>官网: <a href='$uni_link' target='_blank'>$uni_link</a></p></li>
                        //                                 <li><br></li>
                        //                             </ul>   
                        //                             <div style='clear:both'></div>
                        //                         </div>
                        //                     </div>
                        //                 </li>
                        //             </ul>
                        //         </div>";
                        //     }
                        // }
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
    ele.style.color ="#198754";
    ele.onmouseover =  function () {
    this.style.backgroundColor = "white";
    }
    
</script>