<?php
    session_start();
    include('include/connection.php');
    if (empty($_GET['uni_name_zh'])) {
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
    $uni_rank = $row['uni_rank'];
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
    <link rel="stylesheet" href="css/css.css">
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
        <div class="col-md-6 midbar" style='padding:0px'>
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
                            <p class='info'style='font-weight:bold;margin-bottom:20px;border-left:5px solid #00BFFF' >&nbsp;QS大学排名: <?php echo $uni_rank?></p>
                            <!-- <span class='info' style='font-weight:bold;margin-bottom:20px;border-left:5px solid #00BFFF'>&nbsp;搜索次数: <?php echo $search_rank?></span> -->
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
        <?php
        echo"<div class='col-md-3' id='rightbar' style='margin-top: 15px'>
        <form action='result.php' method='POST'>
            <span>
                <input class='form-control search' type='text' name='searchcontent' placeholder='搜索大学/文章/用户' required='required' style='width:100'/>
            </span>
            <span class='span2'>
                <a href='result.php'>
                    <span class='glyphicon glyphicon-search search-sm-icon'></span>
                    <button class='form-control btn btn-primary'type='submit' style='display:none'>
                    </button>
                </a>
            </span>
            <div style='clear:both;'></div>
            <br>
        </form>
        <div class='rightbar'>  
        <div class='ulist'>
        <h4 style='font-weight:bold;text-align:center;margin-top:20px;'>同样想去".$uni_name_zh."的同学</h4>
        <div class='row'>
    
            <div class='col-md-11' style='border:0px;box-shadow:none;'>
                <ul style='list-style:none;padding-left:20px;padding-top:2px'>";
            $who_follow_query = "SELECT * FROM users where uni_interest ='$uni_name_zh'";
            $run_who_follow = mysqli_query($con, $who_follow_query);
            if (isset($run_who_follow)){
                while($row = mysqli_fetch_array($run_who_follow)) {
                    $uni_interest = $row['uni_interest'];
                    $u_id = $row['user_id'];
                    $user_image = $row['user_image'];
                    $user_name = $row['user_name'];
                    $user_des = $row['user_des'];
                    if (strlen($user_des) > 5) {
                        $user_des= mb_substr($user_des,0,5,'utf-8').'......';
                    }
                    echo "
                    <li>
                        <div class='uni-mini-info' style='border-radius:15px;margin:0;margin-top:5px;padding:6px'>
                            <a href='profile.php?u_id=$u_id'><img src='$user_image' alt='user_profile' width='50px' height='50px' style='margin-left:10px' class='img-circle'></a>
                            <span><a href='profile.php?u_id=$u_id'><b style='color:#00BFFF;font-size:1.5em;'>$user_name</b></a>
                            <button class='btn btn-primary'style='font-size:5px;'>关注</button>
                            <div style='clear:both'></div>
                        </div>
                    </li>
                            ";   
                }
            }
            echo "
            </ul>
            </div>
            </div>
        </div>
        </div> 
        <a id='about' href='about.php' style='color:grey'><span class='glyphicon glyphicon-question-sign'></span> About/关于我们</a>
        <a href='#' style='color:grey'><span class='glyphicon glyphicon-question-sign'></span> 隐私政策</a>
        </div>";
            ?>
    


<script>
    $.fn.smartFloat = function() {
    var position = function(element) {
    var top = element.position().top, pos = element.css("position");
    var more = top + 100;
    $(window).scroll(function() {
    var scrolls = $(this).scrollTop();
    if (scrolls > more) {
        if (window.XMLHttpRequest) {
        element.css({
        "width" : "19%",
        "marginTop": "15px",
        position: "fixed",
        top: 0,
        left: 1050,
        }); 
        } else {
        element.css({
        top: scrolls
        }); 
        }
    }else {
        element.css({
        position: pos,
        left:0,
        "width" : "25%",
        }); 
    }
    });
    };
    return $(this).each(function() {
    position($(this));      
    });
    };
    $('#rightbar').smartFloat();


</script>
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