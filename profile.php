<?php
    session_start();
    include('include/connection.php');
    if (isset($_SESSION['user_email'])) {
        $user = $_SESSION['user_email'];
        $get_user = "select * from users where user_email = '$user'";
        $run_user = mysqli_query($con, $get_user);
        $row = mysqli_fetch_array($run_user);
        $u_id = $row['user_id'];
        $u_image = $row['user_image'];
        $u_name = $row['user_name'];
    }//else {
       //header('location:home.php?from=login');
    //}
    if (!empty($_GET['u_id'])) {
        $user_id = $_GET['u_id'];
        $get1_user = "select * from users where user_id = '$user_id'";
        $run1_user = mysqli_query($con, $get1_user);
        $row1 = mysqli_fetch_array($run1_user);
        $user_name = $row1['user_name'];
        $user_image = $row1['user_image'];
        $user_cover = $row1['user_cover'];
        $user_des = $row1['user_des'];
        $user_id = $row1['user_id'];
        $user_country = $row1['user_country'];
        $user_gender = $row1['user_gender'];
        if ($user_gender == 1) {
            $user_gender ='男';
        }elseif ($user_gender == 2) {
            $user_gender = '保密';
        }elseif($user_gender == 0)  {
            $user_gender = '女';
        }
    }else{
        //header('location:home.php');
    }
    if (!empty($u_id)) {
        if ($u_id == $user_id) {
            $status = 1;
        }else {
            $status = 2;
        }
    }else {
        $status = 0;
    }
        
    
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">  
    <script src="https://cdn.staticfile.org/jquery/2.1.1/jquery.min.js"></script>
    <link rel="stylesheet" href="https://cdn.staticfile.org/twitter-bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://cdn.staticfile.org/twitter-bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <title><?php echo $user_name?> - WillCloudy</title>
    <link rel="stylesheet" href="css/css.css">
    <style>
        .avatar{
            margin:0px;
            padding:0px;
            position:absolute;
            top:47px;
            left:20px;
            border:2px solid white;
        }
        .info{
            color:black;
            font-weight: bold;
            font-size:2em;
            margin-left:25%;
        }
        .des{
            color:grey;
            font-weight:normal;
            font-size:1em;
            position:relative;
        }
        a .editProfile{
            position:absolute;
            top:60%;
            left:80%;
            font-weight:bold;
            color: #00BFFF;
            border:1px solid #00BFFF;
            border-radius: 2px;
            background:white;
        }
        a .follow_btn{
            position:absolute;
            top:60%;
            left:88%;
            font-weight:bold;
            color: #00BFFF;
            border:1px solid #00BFFF;
            border-radius: 2px;
            background:white;
        }
        a .editProfile:focus, a .follow_btn:focus{
            outline:none;
        }
        a .editProfile:hover, a .follow_btn:hover{
            background:#00BFFF;
            color:white;
            border:1px solid white;
            border-radius: 2px;
        }
        #userFunction{
            font-size:1em;
            font-weight:bold;
            padding:0px;
        }
        #userFunction li{
            text-decoration: none;  /*去掉前面的圆点*/
			list-style: none;
			border: 1px solid #FFFFFF;
            display: inline-block;
            width:10%;
            text-align:center;
            padding:0px;
            height:10px;
        }
        #userFunction li a{
            color:#040404;
			text-decoration: none;
			margin:0px;
			height:10%; 
			line-height:40px; 
            padding:0px;
        }
        #userFunction li:hover{
			background-color: ;
		}
        #col-moredes,#col-closedes{
            background-color:white;
            outline: none;
            border:none;
        }
        #col-closedes{
            display:none;
        }
        .more{
            margin-left:24%;
        }
        #zk,svg{
            color:grey;
        }
    </style>
</head>
<body>
<div class="container">
    <?php
        require('include/leftbar.php');
        if ($status == 2 or $status == 1) {
            echo "
            <script>
                var profile = document.getElementById('profile');
                profile.style.display='block';
                document.getElementById('sign').style.display='none';
            </script>";
        }
       
    ?>
    <div class="col-md-6 midbar" style='padding:0;'>
        <div class="box" style='margin-top:0;position:relative'>
            <img src="<?php echo $user_cover;?>" alt="cover" width='100%' height='100px'style='margin:0;padding:0;border-radius:10px 10px 0px 0px'>
            <script>
            function click() {
                window.location.href='edit.php'
            }
            </script>
            <?php
            if ($status == 1) {
                echo "<a href='edit.php'><button class='editProfile'>编辑个人资料</button></a>";
            }elseif($status == 2){
                echo "<a><button class='follow_btn'>关注</button></a>";
            }elseif($status == 0){
                echo "<a><button class='follow_btn'>关注</button></a>";
            }
            ?>
            <img src="<?php echo $user_image;?>" alt="avatar" width='19%' class='img-circle avatar'>
            <div>
                <span class='info'><?php echo $user_name;?></span>
                <span class="des"><?php echo $user_des;?></span>
                <br>
                <div class='more'>
                    <button data-toggle="collapse" data-target="#moredes" id='col-moredes'>
                        <svg id='down-arrow' width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-caret-down-fill" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                            <path d="M7.247 11.14L2.451 5.658C1.885 5.013 2.345 4 3.204 4h9.592a1 1 0 0 1 .753 1.659l-4.796 5.48a1 1 0 0 1-1.506 0z"/>
                        </svg>
                        <span id='zk'>展开更多资料</span>
                    </button>
                    <button data-toggle="collapse" data-target="#moredes" id='col-closedes'>
                        <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-caret-up-fill" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                            <path d="M7.247 4.86l-4.796 5.481c-.566.647-.106 1.659.753 1.659h9.592a1 1 0 0 0 .753-1.659l-4.796-5.48a1 1 0 0 0-1.506 0z"/>
                        </svg>
                        <span id='zk'>收起更多资料</span>
                    </button>
                    <div id="moredes" style='margin-top:10px;' class="collapse">
                        <span style='font-weight:bold;'>居住地: <?php echo $user_country;?></span>
                        <span style='margin:10%;font-weight:bold;'>教育经历: <?php echo @$user_uni;?></span><br><br>
                        <span style='font-weight:bold;'>性别: <?php echo $user_gender;?></span>
                    </div>
                    <script>
                        window.onload = function(){
                        var sm_open = document.getElementById("col-moredes");//展开操作详情按钮 
                        var sm_close = document.getElementById("col-closedes");//关闭操作详情按钮
                        //操作详情表的展开和收起
                            sm_open.onclick = function(){
                                sm_close.style.display = "block";
                                sm_open.style.display = "none";
                            };
                            sm_close.onclick = function(){
                                sm_close.style.display = "none";
                                sm_open.style.display = "block";
                            };
                        };
                        
                    </script>
                </div>
            </div>
            <br>
            <hr class='hrmargin'>

            <div class="col-md-12" style='padding:0px;margin:0px;'>
                <!-- <nav>
                    <ul id='userFunction'>
                        <li><a href="">动态</a></li>
                        <li><a href="">回答</a></li>
                        <li><a href="">文章</a></li>
                        <li><a href="">收藏</a></li>
                        <li><a href="">关注</a></li>
                        <li><a href="">粉丝</a></li>
                    </ul>
                </nav> -->
                <ul id="myTab" class="nav nav-tabs ">
                    <li class="active"><a href="#dt" data-toggle="tab">动态</a></li>
                    <li><a href="#wz" data-toggle="tab">文章</a></li>
                    <li><a href="#gz" data-toggle="tab">关注</a></li>
                    <?php

                        echo "<li><a href='#fs' data-toggle='tab'>粉丝</a></li>"
                    ?>
                </ul>
                <div id="myTabContent" class="tab-content">
                    <div class="tab-pane fade in active" id="trend">
                        
                    </div>

                    <div class="tab-pane fade" id="top100">
                        
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
<?php include_once("baidu_js_push.php") ?>
</html>
<?php
if ($status ==1) {
    echo "<script>
            document.getElementById('profileA').href = 'javascript:void(0);';
            var ele = document.getElementById('profileA');
            ele.style.color ='#00BFFF';
            ele.onmouseover =  function () {
            this.style.backgroundColor = 'white';
            }
        </script>";
    }
?>

<?php
    if (isset($_GET['from'])) {
        if ($_GET['from'] == "login") {
            echo "<script>document.getElementById('sign').click()</script>";
        }
    }
?>
 