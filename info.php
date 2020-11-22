<?php
    session_start();
    include('include/connection.php');
    if (!isset($_GET['uni_name_zh'])) {
        header('location:home.php');
    }else {
        $uni_name_zh = $_GET['uni_name_zh']; 
    }
    $search_query = "SELECT * FROM `university` where uni_name_zh = '$uni_name_zh' ";
    $run_search = mysqli_query($con, $search_query);
    $row = mysqli_fetch_array($run_search);

    $uni_name_en = $row['uni_name_en'];
    $uni_name_zh = $row['uni_name_zh'];
    $uni_country = $row['uni_country'];
    $uni_location = $row['uni_location'];
    $uni_link = $row['uni_link'];
    $uni_icon = $row['uni_icon'];
    $uni_description = $row['uni_description'];

    $rank_query = "SELECT * FROM `rank` where uni_name_zh = '$uni_name_zh' ";
    $run_rank = mysqli_query($con, $rank_query);
    $rank = mysqli_fetch_array($run_rank);
    @$qs_rank = $rank['qs_rank'];
    @$search_rank = $rank['search_rank'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://cdn.staticfile.org/twitter-bootstrap/3.3.7/css/bootstrap.min.css">  
    <script src="https://cdn.staticfile.org/jquery/2.1.1/jquery.min.js"></script>
    <script src="https://cdn.staticfile.org/twitter-bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <title><?php echo $uni_name_zh.' - WillCloudy'?> </title>
    <link rel="stylesheet" href="css/home.css">
<style>
    .info{
        font-weight:bold;
        font-size:1.1em;
    }
    .schoolmate{
        overflow-x:scroll;
        overflow-y:hidden;
        white-space:nowrap;
    }
    /*滚动条样式*/
    .schoolmate::-webkit-scrollbar {/*滚动条整体样式*/
        width: 10px;     /*高宽分别对应横竖滚动条的尺寸*/
        height: 10px;
    }
    .schoolmate::-webkit-scrollbar-thumb {/*滚动条里面小方块*/
        border-radius: 5px;
        -webkit-box-shadow: inset 0 0 5px rgba(0,0,0,0.2);
        background: #00BFFF;
        }
    .schoolmate::-webkit-scrollbar-track {/*滚动条里面轨道*/
        -webkit-box-shadow: inset 0 0 5px rgba(0,0,0,0.2);
        border-radius: 0;
        background:  rgb(181,212,213);
    }
    .inschool{
        display:inline-block;
        margin:20px;
        width:250px;
        background-color:white;
        box-shadow: 0px 2px 5px rgb(181,212,213);
        border:1px solid #00BFFF;
        border-radius: 15px;
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
        <div class="col-md-6" style='padding:0px'>
            <div class="box">
                <h3 style='font-weight:bold;padding:10px;'>
                    <?php echo 'University Info / '.$uni_name_zh?>
                    <span style='font-size:14px;color:grey'>
                        <?php echo '  '.$uni_name_en?>
                    </span>
                </h3>
                <hr>
                <div>
                    <img src="<?php echo $uni_icon;?>" alt="<?php echo "$uni_name_en's icon"?>" class='img-responsive' width='130px' style='float:left;margin-left:40px'>
                    <div class='list-group' >
                        <div style='float:left;margin-left:40px;margin-top:20px'>
                            <p class='info' style='font-weight:bold;margin-bottom:20px;border-left:5px solid #00BFFF'>&nbsp;国家: <?php echo $uni_country?></p>
                            <span class='info'style='font-weight:bold;margin-bottom:20px;border-left:5px solid #00BFFF'>&nbsp;城市: <?php echo $uni_location?><span>
                            <br>
                            <br>
                        </div>
                        <div style='float:right;margin-right:120px;margin-top:20px'>
                            <p class='info'style='font-weight:bold;margin-bottom:20px;border-left:5px solid #00BFFF' >&nbsp;QS大学排名: <?php echo $qs_rank?></p>
                            <span class='info' style='font-weight:bold;margin-bottom:20px;border-left:5px solid #00BFFF'>&nbsp;搜索次数: <?php echo $search_rank?></span>
                        </div>
                        
                        <div style='clear:both'></div>
                        <hr>
                    </div>
                    <div class="col-md-12">
                        <h4 style='font-weight:bold;margin-left:1em;margin-bottom:20px;border-left:5px solid #00BFFF'>&nbsp;学校简介</h4>
                        <p style='width:80%;margin:0 auto;font-weight:bold'><?php echo $uni_description;?></p>
                        <hr>
                        <h4 style='font-weight:bold;margin-left:1em;margin-bottom:20px;border-left:5px solid #00BFFF'>&nbsp;校友/Schoolmate</h4>
                        <div class='schoolmate'>
                        <?php
                            for ($i=0; $i < 5; $i++) { 
                                    echo "
                                    <div class='inschool'>
                                        <div style='float:left;'>
                                            <a href='#'><img src='#' alt='' width='80px' height='80px' style='margin-left:10px;margin-bottom:15px;margin-right:20px;margin-top:19px;'></a>
                                        </div>
                                        <div>
                                            <h5 style='font-weight:bold'><a href='#'>用户姓名</a></h5>
                                            <p>在校年数:</p>
                                            <p>目前:</p>
                                            <p>所学专业:</p>
                                        </div>
                                        <div style='clear:both'></div>
                                    </div>";
                            }
                        ?>
                        </div>
                        <hr >
                        <!-- <h4 style='text-align:center;font-weight:bold'>有意向/Interest in</h4>
                        <div class='schoolmate'>
                            <?php
                                // for ($i=0; $i < 5; $i++) { 
                                //         echo "
                                //         <div class='inschool'>
                                //             <div style='float:left;'>
                                //                 <a href='#'><img src='#' alt='' width='80px' height='80px' style='margin-left:10px;margin-bottom:15px;margin-right:20px;margin-top:10px;'></a>
                                //             </div>
                                //             <div>
                                //                 <h5 style='font-weight:bold'><a href='#'>用户姓名</a></h5>
                                //                 <p>目标专业:</p>
                                //                 <p>目标学位:</p>
                                //             </div>
                                //             <div style='clear:both'></div>
                                //         </div>";
                                // }
                            ?>
                        </div> -->
                    </div>
                </div>
            </div>  
        </div>
       
        <div class="col-md-3" id='tuijian' style='margin-top: 15px'>
                <form action="result.php" method="POST">
                    <span>
                        <input class='form-control' type="text" name='searchcontent' style='font-size:1em;width:80%;float:left;display:inline-block;
                        height:39px;margin-right:0;border-radius:5px 0px 0px 5px;' placeholder='搜索大学/文章/用户'>
                    </span>
                    <span class='span2'>
                        <a href="result.php"><button class='form-control btn btn-primary'type='submit' style='float:right;
                        height:38.5px;display:inline-block;width:20%;margin-left:0;border-radius:0px 5px 5px 0px;font-weight:bold;
                        background-color: #00BFFF;'><span class="glyphicon glyphicon-search"></span></button></a>
                    </span>
                    <div style="clear:both;"></div>
                    <br>
                </form>
            <div class='tuijian'>
                
                <div class='ulist'>
                    <h4 style='font-weight:bold;text-align:center;margin-top:20px;'>Who interest in</h4>
                        <div class="row">
                            <div class='col-md-11'>
                                <?php
                                    for ($i=0; $i < 2; $i++) { 
                                            echo "
                                            <div >
                                                <div style='float:left;'>
                                                    <a href='#'><img src='#' alt='' width='50px' height='50px' style='margin-left:10px;margin-bottom:15px;margin-right:20px;margin-top:0px;'></a>
                                                </div>
                                                <div>
                                                    <h5 style='font-weight:bold'><a href='#'>用户姓名</a></h5>
                                                    <p>目标专业:</p>
                                                </div>
                                                <div style='clear:both'></div>
                                            </div>";
                                    }
                                ?>
                            </div> 
                        </div>
                </div>
            </div>
            <br>
            <div class='tuijian'>
                <div class='ulist'>
                    <h4 id='duibi'style='font-weight:bold;text-align:center;margin-top:20px;'>对比<?php echo $uni_country?> 和中国物价</h4>
                        <div class="row">
                            <div class='col-md-11'>
                                <ul style='list-style:none;padding-left:20px;padding-top:2px'>
                                    <?php 
                                        if ($uni_country == 'England') {
                                            echo "<li>
                                            <div class='toprank'>
                                                <div >
                                                    <a href='country.php?country=UK'><img src='img/enland.jpg' alt='' class='img-responsive'></a>
                                                </div>
                                                <a href='country.php?country=UK'><h4 style='text-align:center'>英国/Prices in British</h4></a>
                                            </div>
                                        </li>";
                                        }elseif ($uni_country == 'Canada') {
                                            echo " <li>
                                            <div class='toprank'>
                                                <div >
                                                    <a href='country.php?country=CAN'><img src='img/caland.jpg' alt='' class='img-responsive'></a>
                                                </div>
                                                <a href='country.php?country=CAN'><h4 style='text-align:center'>加拿大/Prices in Canada</h4></a>
                                            </div>
                                        </li>";
                                        }elseif ($uni_country == 'Australia') {
                                            echo "<li>
                                            <div class='toprank'>
                                                <div >
                                                    <a href='country.php?country=AUS'><img src='img/auland.jpg' alt='' class='img-responsive'></a>
                                                </div>
                                                <a href='search.php?country=AUS'><h4 style='text-align:center'>澳大利亚/Prices in Australia</h4></a>
                                            </div>
                                        </li>";
                                        }else {
                                            echo "<script>document.getElementById('duibi').style.display ='none'</script>";
                                //             echo "<li>
                                //             <div class='toprank'>
                                //                 <div >
                                //                     <a href='country.php?country=UK'><img src='img/enland.jpg' alt='' class='img-responsive'></a>
                                //                 </div>
                                //                 <a href='country.php?country=UK'><h4 style='text-align:center'>英国/Prices in British</h4></a>
                                //             </div>
                                //         </li><li>
                                //         <div class='toprank'>
                                //             <div >
                                //                 <a href='country.php?country=CAN'><img src='img/caland.jpg' alt='' class='img-responsive'></a>
                                //             </div>
                                //             <a href='country.php?country=CAN'><h4 style='text-align:center'>加拿大/Prices in Canada</h4></a>
                                //         </div>
                                //     </li><li>
                                //     <div class='toprank'>
                                //         <div >
                                //             <a href='country.php?country=AUS'><img src='img/auland.jpg' alt='' class='img-responsive'></a>
                                //         </div>
                                //         <a href='search.php?country=AUS'><h4 style='text-align:center'>澳大利亚/Prices in Australia</h4></a>
                                //     </div>
                                // </li>";
                                        }
                                    ?>
                                </ul>
                            </div>
                            
                        </div>
                    </div>
                </div>
                <br>
            </div>
            <br>
        </div>

        
            
            <?php
            // echo "<footer style='text-align:center;'>当前在线".$users_online."人<footer>";
            //require('include/rightbar.php');
            ?>
</div>
</body>
</html>
<script>
    $.fn.smartFloat = function() {
    var position = function(element) {
    var top = element.position().top, pos = element.css("position");
    var more = top + 80;
    $(window).scroll(function() {
    var scrolls = $(this).scrollTop();
    if (scrolls > more) {
        if (window.XMLHttpRequest) {
        element.css({
        "width" : "19.4%",
        "marginTop": "15px",
        position: "fixed",
        top: 0,
        left: 1050
        }); 
        } else {
        element.css({
        top: scrolls
        }); 
        }
    }else {
        element.css({
        width:"25%",
        position: pos,
        left:0
        }); 
    }
    });
    };
    return $(this).each(function() {
    position($(this));      
    });
    };
    $('#tuijian').smartFloat();

</script>