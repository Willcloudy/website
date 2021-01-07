<?php
    session_start();
    include('include/connection.php');
    if (isset($_GET['uni_name_zh'])) {
        $page = 'uni_info';
        $uni_name_zh = $_GET['uni_name_zh']; 
        $search_query = "SELECT * FROM `university` where zh = '$uni_name_zh' ";
        mysqli_query($con, "set names 'utf8'");
        $run_search = mysqli_query($con, $search_query);
        $row = mysqli_fetch_array($run_search);
        $uni_name_en = $row['uni_name_en'];
        $uni_name_zh = $row['zh'];
        $uni_country = $row['uni_country'];
        $uni_location = $row['uni_location'];
        $uni_link = $row['uni_link'];
        $uni_icon = $row['icon'];
        $uni_description = $row['uni_description'];
        $qs_rank = $row['qs_rank']; 
        $fee_detail = $row['fee_detail'];
        $fee_detail = str_replace('<p>',"<p style='width:80%;margin:0 auto;font-weight:bold'>",$fee_detail);
        $fee_detail = str_replace('<h4><span>&gt; </span>本科费用</h4>',"",$fee_detail);

        $uni_require = $row['uni_require'];
        $uni_require = str_replace('>',"<p style='width:80%;margin:0 auto;font-weight:bold'>>",$uni_require);
        $uni_require = str_replace('。',"<br>",$uni_require);
        $uni_require = str_replace('本科',"",$uni_require);
        $uni_require = str_replace('，',"<br>",$uni_require);
        $uni_require = str_replace('语言要求',"语言要求<br>",$uni_require);
        $uni_require = str_replace('学历要求',"学历要求<br>",$uni_require);
        $uni_require = str_replace('申请材料',"申请材料<br>",$uni_require);
        $uni_require = str_replace('申请费',"申请费<br>",$uni_require);
        $uni_require = str_replace('申请方式',"申请方式<br>",$uni_require);
        $uni_require = str_replace('申请时间',"申请时间<br>",$uni_require);





        $title = $uni_name_zh;
        $fee = $row['fee'];
    }else {
        $page = 'index';
        $title = '话题';
    }
    
?>
<!DOCTYPE html>
<html lang="en">
<head>
<link rel="icon" type="image/x-ico" href="img/logo.ico" />
    <link rel="apple-touch-icon" sizes="180x180" href="/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/favicon-16x16.png">
    <link rel="manifest" href="/site.webmanifest">
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://cdn.staticfile.org/twitter-bootstrap/3.3.7/css/bootstrap.min.css">  
    <script src="https://cdn.staticfile.org/jquery/2.1.1/jquery.min.js"></script>
    <script src="https://cdn.staticfile.org/twitter-bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <title><?php echo $title;?> - willcloudy </title>
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
        background: #198754;
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
        border:1px solid #198754;
        border-radius: 15px;
    }
    .uni_img img{
        width:130px;
        float:left;
        margin-left:40px;
    }
    .col-md-12 p{
        margin-bottom:15px !important;
        word-break: break-all;
    }
    @media(max-width:992px)
        {
            .uni_img img{
                width:120px !important;
            }
        }
    .col-md-5{
        margin:10px 4.1%;
        background-color:white;
        border-radius:10px;
        box-shadow: 0px 2px 5px rgb(181,212,213);

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
            echo "<script>document.getElementById('sign').style.display='block' </script>";

        }
    ?>
    <?php
        if ($page == 'uni_info') {
            ?>
            <div class="col-md-6 midbar" style='padding:0px'>
                <div class="box">
                <h3 style='font-weight:bold;padding:10px;'>
                    <?php echo '#'.$uni_name_zh?>
                    <span style='font-size:14px;color:grey'>
                        <?php echo '  '.$uni_name_en?>
                    </span>
                </h3>
                <hr>
                <div>
                    <div class="uni_img">
                        <img src='<?php echo $uni_icon;?>'>
                    </div>
                    <div class='list-group' >
                        <div style='float:left;margin-left:40px;margin-top:20px'>
                            <p class='info' style='font-weight:bold;margin-bottom:20px;border-left:5px solid #198754'>&nbsp;国家: <?php echo $uni_country?></p>
                            <span class='info'style='font-weight:bold;margin-bottom:20px;border-left:5px solid #198754'>&nbsp;城市: <?php echo $uni_location?><span>
                            <br>
                            <br>
                        </div>
                        <div style='float:right;margin-right:120px;margin-top:20px'>
                            <p class='info'style='font-weight:bold;margin-bottom:20px;border-left:5px solid #198754' >&nbsp;QS大学排名: <?php echo $qs_rank?></p>
                            <!-- <span class='info' style='font-weight:bold;margin-bottom:20px;border-left:5px solid #198754'>&nbsp;搜索次数:-->
                        </div>
                        <div style='clear:both'></div>
                        <hr>
                    </div>
                    <div class="col-md-12">
                        <h4 style='font-weight:bold;margin-left:1em;margin-bottom:20px;border-left:5px solid #198754'>&nbsp;学校简介</h4>
                        <p style='width:80%;margin:0 auto;font-weight:bold'><?php echo $uni_description;?></p>
                        <hr>
                        <!-- <h4 style='font-weight:bold;margin-left:1em;margin-bottom:20px;border-left:5px solid #198754'>&nbsp;校友/Schoolmate</h4>
                        <div class='schoolmate'>
                        <?php
                            // for ($i=0; $i < 5; $i++) { 
                            //         echo "
                            //         <div class='inschool'>
                            //             <div style='float:left;'>
                            //                 <a href='#'><img src='#' alt='' width='80px' height='80px' style='margin-left:10px;margin-bottom:15px;margin-right:20px;margin-top:19px;'></a>
                            //             </div>
                            //             <div>
                            //                 <h5 style='font-weight:bold'><a href='#'>用户姓名</a></h5>
                            //                 <p>在校年数:</p>
                            //                 <p>目前:</p>
                            //                 <p>所学专业:</p>
                            //             </div>
                            //             <div style='clear:both'></div>
                            //         </div>";
                            // }
                        ?>
                        </div> -->
                        <h4 style='font-weight:bold;margin-left:1em;margin-bottom:20px;border-left:5px solid #198754'>&nbsp;入学申请&要求<span style='float:right;font-size:12px;margin-right:10px;color:rgb(91, 112, 131)'>仅供参考,详情请咨询留学中心</span></h4>
                        <?php echo $uni_require;?>
                        <hr>
                        <h4 style='font-weight:bold;margin-left:1em;margin-bottom:20px;border-left:5px solid #198754'>&nbsp;费用<span style='float:right;font-size:12px;margin-right:10px;color:rgb(91, 112, 131)'>仅供参考,详情请咨询留学中心</span></h4>
                        <?php echo $fee_detail;?>
                        <hr>
                    </div>
                </div>
                </div>
                </div>
                    <?php
                    echo"
                    <div class='col-md-3' id='rightbar'>
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
                        </form>
                        <div class='rightbar'>  
                            <div class='ulist'>
                            <h4 style='font-weight:bold;font-size:1em;text-align:center;padding-top:10px;'>同样想去".$uni_name_zh."的同学</h4>
                                <div class='row'>
                                    <div class='col-md-11' style='border:0px;box-shadow:none;'>
                                        <ul style='list-style:none;padding-left:20px;padding-top:2px'>";
                                        $who_follow_query = "SELECT * FROM uni_shou where uni_name_zh ='$uni_name_zh'";
                                        $run_who_follow = mysqli_query($con, $who_follow_query);
                                        echo mysqli_error($con);
                                        if (isset($run_who_follow)){
                                            while($row = mysqli_fetch_array($run_who_follow)) {
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
                                                        <span><a href='profile.php?u_id=$u_id'><b style='color:#198754;font-size:1.5em;'>$user_name</b></a>
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
        }elseif ($page == 'index') {
    ?>   
        <div class='col-md-6 midbar' style='padding:0px;'>
            <h3 style='font-weight:bold;margin-left:20px;'> 话题中心</h3> 
            <hr>           
            <div class='box'>
    <?php
        $tag_select = "SELECT * FROM tag";
        $tag_query = mysqli_query($con,$tag_select);
        while($tag_row = mysqli_fetch_array($tag_query)){
            
            $tag_name = $tag_row['tag_name'];
            if ($tag_name == '海外生活') {
                $info = "<a href='oversealife.php' style='float:right;margin-top:10px;'>查看更多</a>
                <a href='oversealife.php'><h4 style='font-weight:bold;'>$tag_name</h4></a>
                <div><small>$tag_des</small></div>";
            }else {
                $info = "
                <a href='topics.php?tag_id=$tag_id' style='float:right;margin-top:10px;'>查看更多</a>
                <a href='topics.php?tag_id=$tag_id'><h4 style='font-weight:bold;'>$tag_name</h4></a>
                <div><small>$tag_des</small></div>";
            }
            $tag_id = $tag_row['id'];
            $tag_des = $tag_row['tag_des'];
            
            $get_post = "SELECT * FROM posts where tag ";
            echo "
            <div class='col-md-5'>
                $info
                <small>回答</small>
                <hr>
                <div>
                    <h4 style='font-weight:bold;'>title</h5>
                    <span>name：</span><span>content</span>
                </div>
            </div>";    
        }
    ?>
                    
                    
        </div>
    </div>
    <?php
    require('include/rightbar.php');                    
        }
    ?>
</div>


</body>
</html>
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
        "marginTop" : '0'
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