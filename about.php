<!DOCTYPE html>
<html lang="en">
<head>
    
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://cdn.staticfile.org/twitter-bootstrap/3.3.7/css/bootstrap.min.css">  
    <script src="https://cdn.staticfile.org/jquery/2.1.1/jquery.min.js"></script>
    <script src="https://cdn.staticfile.org/twitter-bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <title>关于我们 - willcloudy</title>
    <link rel="stylesheet" href="css/css.css">
    <style>
    .willcloudy{
        border: 1px solid white;
        box-shadow: 0px 2px 10px rgb(181,212,213);
        margin-bottom:20px;
    }
    .willcloudy:hover{
        border:1px solid  #198754;
        box-shadow: 0px 2px 20px rgb(181,212,213);
        }
    </style>
</head>
<body>
    <div class="container">
        <?php require('include/leftbar.php');?>
            <div class="col-md-6 midbar">
                <div class="box">
                    <h3 style='font-weight:bold;'>About/关于</h3>
                    <hr>
                    <div class="row">
                        <div class="willcloudy col-md-7 " style='margin-left:30px;width:90%;'>
                            <h4 style='font-weight:bold;'>About the site/关于WillCloudy</h4>
                            <hr>
                            "WillCloudy"是一个可以帮助想要出国留学的学生快速获取心仪学校的环境和入学条件及各种信息的网站，并且有很多毕业大学生来分享他们个人的亲身经历，这是一个面向留学生的社交性质的交流平台。<hr>
                            "WillCloudy" is an online directory that can help the students who want study aboard quickly get the information about their dream university, and we will open a new function that can connect the student who are already study aboard through social network.
                            <hr>
                        </div>
                        <hr>
                        <div class="willcloudy col-md-7 " style='margin-left:30px;width:90%;'>
                            <h4 style='font-weight:bold;'>About the people/关于创始人</h4>
                            <hr>
                            <div><a href="">Mark He zhe/和喆</a> -- 创始人兼首席执行官/Founder & CEO</div><br>
                            <div><a href="">Dragon Chen Long Xin/陈龙鑫</a> -- 共同创始人兼首席财务官/Co-Founder & CFO</div>
                            <hr>
                        </div>
                    </div>
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
    var ele = document.getElementById("about");
    ele.href="javascript:volid(0);";
    ele.style.color ="#198754";
</script>