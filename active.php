<?php
    include_once("include/connection.php");//连接数据库
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>激活&nbsp;|&nbsp;Willcloudy</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://cdn.staticfile.org/twitter-bootstrap/3.3.7/css/bootstrap.min.css">  
    <script src="https://cdn.staticfile.org/jquery/2.1.1/jquery.min.js"></script>
    <script src="https://cdn.staticfile.org/twitter-bootstrap/3.3.7/js/bootstrap.min.js"></script>
</head>
<style>
    body{
        overflow-x:hidden;
        background-color:#f6f6f6;
    }
    .main-content{
        width:800px;
        height:50%;
        margin:10px auto;
        background-color: #fff;
        border:2px solid #e6e6e6;
        padding: 40px 50px;
    }
    .well{
        min-height:80px;
        background-color:white;
    }
    h1{
        margin-top:-30px;
        margin-left:-50px;
        margin:0 auto;
    }
    #signup{
        width:60%;
        border-radius:30px;
    }
    p{
        margin:20px 0 15px;
        font-size:15px;
        line-height:normal;
        font-family: 'Courgette', sans-serif;
    }
    strong{
        font-size: 28px;
        font-weight: bold;
        margin:0 0 10px;
        font-family: 'Pacifico', sans-serif;
    }
    h1{
        font-size: 35px;
        font-weight: bold;
        margin:0 0 10px;
        font-family: 'Pacifico', sans-serif;
    }
    a{
        color:#00BFFF;
    }
    a:hover{
        text-decoration: underline;
    }
    .btn{
        border-radius:7px;
        font-weight:bold;
        background-color: #00BFFF;
    }
    form{
        color: #999;
        background: white;
    }
</style>
<body>
<div class="row">
        <div class="col-sm-12">
            <div class="well">
                <div class="center" style="text-align:center">
                    <h1>WillCloudy</h1>
                </div>
            </div>
        </div>    
    </div>
    <?php
    if (isset($_GET['verify'])) {
        $verify = stripslashes(trim($_GET['verify']));

        $nowtime = time();
    
        $query = mysqli_query($con, "select user_id, token_exptime from users where status = 0 and token = '$verify'");
        
        $row = mysqli_fetch_array($query);
        
        mysqli_error($con);
        if($row){
    
            if($nowtime>$row['token_exptime']){ //24hour
        
                $msg = '您的激活有效期已过，请登录您的帐号重新发送激活邮件.';
        
            }else{
        
                mysqli_query($con,"update users set status=1 where user_id=".$row['user_id']);
        
                if(mysqli_affected_rows($con)!=1) die(0);
        
                $msg = "激活成功！请去<a href='home.php?from=login'>主页</a>登录";
                $eng = 'activation success';
        
            }
    
        }else{
    
            $msg = "邮箱已经激活完成，请去<a href='home.php?from=login'>主页</a>登录";
            $eng = 'Activation already done';
        }
        echo "
        <div class='row'>
            <div class='col-md-12'>
                <div class='main-content'>
                    <div class='header'>
                        <h3 style='text-align:center;'>
                            <strong>$msg</strong>
                            <p>$eng</p>
                            
                            <hr>    
                        </h3>
                    </div>
                </div>
            </div>
        </div>";

    }else {
        echo "
        <div class='row'>
            <div class='col-md-12'>
                <div class='main-content'>
                    <div class='header'>
                        <h3 style='text-align:center;'>
                            <strong>请前往注册表单中填写的邮箱获取激活链接</strong>
                            <p>Please go to the email address filled in the registration form to get the activation link</p>
                            <hr>    
                        </h3>
                    </div>
                </div>
            </div>
        </div>";
    }
    ?>
</body>
</html>