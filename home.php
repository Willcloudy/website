<?php
    session_start();
    include('include/connection.php');
    if (isset($_SESSION['user_email'])) {
        $user = $_SESSION['user_email'];
        $get_user = "select * from users where user_email = '$user'";
        $run_user = mysqli_query($con, $get_user);
        $row = mysqli_fetch_array($run_user);
        $u_name = $row['user_name'];
        $u_image = $row['user_image'];
        $u_id = $row['user_id'];
        $login = 1;
        
    }else {
        $login=0;
    }
?>
<!DOCTYPE html>
<html>
<head>
    <script data-ad-client="ca-pub-2929558295093322" async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
    <meta name="description" content="WillCloudy是一个可以帮助想要出国留学的学生快速获取心仪学校的环境和入学条件及各种信息的网站，并且有很多毕业大学生来分享他们个人的亲身经历，这是一个面向留学生的社交性质的交流平台。" />
    <meta name="keywords" content="加拿大留学,英国留学,欧洲留学,留学经验分享,IDY留学,留学申请,留学流程,留学费用,出国留学,留学论坛,留学网站,留学考试,GRE,TOEFL,IBT,GMAT,IELTS,SAT,VISA,文书,签证" />
    <meta charset="utf-8"/>
    <meta charset="utf-8" name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1, maximum-scale=1, user-scalable=no"/>
    <script src="https://cdn.staticfile.org/jquery/2.1.1/jquery.min.js"></script>
    <link rel="stylesheet" href="https://cdn.staticfile.org/twitter-bootstrap/3.3.7/css/bootstrap.min.css"/>
    <script src="https://cdn.staticfile.org/twitter-bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <title><?php 
        if ($login == 0) {
            echo "willcloudy - 海内外留学生交流社区";
        }else{
           echo "主页 - WillCloudy";} ?></title>
    <link rel="stylesheet" href="css/css.css">
    <style>
        #write-box{
            margin-top:10px;
            padding-left:15%;
        }
        .toolbar {
            width:85%;
            border-top:1px solid #ccc;
            border-bottom:1px solid #ccc;
        }
        .text{
            min-height:50px;
            width:85%;
        }
        .text:hover{
            /* border-left:1px solid #00BFFF;
            border-right:1px solid #00BFFF;
            border-bottom:1px solid #00BFFF; */
            /* border:1px solid #00BFFF; */
        }
        #goWrite{
            position:absolute;
            top: 20px;  
            left: 500px;
            font-weight:bold;
            font-size:0.9em;
            width:55px;
            height:30px;
            color:white;
            background:#00BFFF;
            border:1px solid #ccc;
            border-radius:10px;
        }
        #goWrite:hover{
            color:#00BFFF;
            background:white;
            border:2px solid #ccc;
        }
        #goWrite:focus{
            outline:none;
        }
        #home-profile{
            position:absolute;
            left: 15px;
            top: 14px;
            border:1px solid #ccc;
        }
        #home-profile:hover{
            opacity:0.5;
        }
        .content{
            margin-top:10px;
        }
        #article-title{
            border:none;
            padding:10px;
        }
        #article-title:focus{
            outline:none;
        }
    </style>
</head>
<body>
    <div class="container">
       <?php
            if ($login == 1) {
                require('include/leftbar.php');
                echo "
                <script>
                    var profile = document.getElementById('profile');
                    profile.style.display='block';
                    document.getElementById('sign').style.display='none'; 
                    var profileA = document.getElementById('profileA');
                    profileA.style.display='block';
                </script>";
            }elseif ($login == 0) {
                require('include/leftbar.php');
                echo "<script>document.getElementById('login').click()</script>";
            }
       ?>   
        <div class="col-md-6 midbar" style='padding:0;'>
            <?php require('include/publish.php');?>
            <hr>
            <div class="content">
                
            </div>
        </div>
        <?php
            require('include/rightbar.php');
        ?>
    </div>
</body>
</html>
<script>
    document.getElementById("logo").href = "javascript:void(0);";
    var home = document.getElementById("home");
    home.href="javascript:void(0);";
    home.style.color ="#00BFFF";
    home.onmouseover =  function () {
        this.style.backgroundColor = "white";
    }
</script>
