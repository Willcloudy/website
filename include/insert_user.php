<?php
    include("include/connection.php");
    if (isset($_POST['sign_up'])) {
        $user_name = $_POST['user_name'];
        $pass = md5(trim($_POST['user_password']));
        $email = trim($_POST['user_email']);
        $posts = "no";

        $check_email = "SELECT * FROM users where user_email = '$email'";
        $run_email = mysqli_query($con, $check_email);

        $check = mysqli_num_rows($run_email);

        if ($check == 1) {
            echo "<script>alert('邮箱已经存在，请使用其他邮箱')</script>";
            echo "<script>window.open('signup.php', '_self')</script>";
            return false;
        }

        $regtime = time();
        $token = md5($user_name.$pass.$regtime); //创建用于激活识别码
        $token_exptime = time()+60*60*24;//过期时间为24小时后

        $profile_pic = "images/user.svg";
        $cover = 'img/cover.jpg';
        
        $insert = "INSERT INTO users (user_name, 
        user_des, user_password, user_email, user_image, user_cover, regtime, posts, token, token_exptime) values 
        ('$user_name', '这个人很懒什么都没有留下', 
        '$pass', '$email', '$profile_pic', '$cover', '$regtime', '$posts','$token','$token_exptime')";

        $query = mysqli_query($con, $insert);
        if (!mysqli_query($con,$query))
        {
            
        }
        
        if ($query) {
            //echo "<script>window.open('home.php', '_self')</script>";
            $emailtype = "HTML"; //信件类型，文本:text；网页：HTML
            $smtpemailto = $email;
            $emailsubject = "=?UTF-8?B?".base64_encode("⚡用户帐号激活🔥")."?=";
            
            $subject = stripslashes($emailsubject); 
            $headers　= "MIME-Version: 1.0\r\n"; 
            $headers .= "Content-type: text/html; charset=utf-8\r\n"; 
            $headers .= "Content-Transfer-Encoding: 8bit\r\n"; 
            
            $emailbody = "
            $user_name ：感谢您在我站注册了新帐号。请点击链接激活您的帐号。
            <br>
            <br>
            https://www.willcloudy.com/active.php?verify=$token
            <br>
            <br>
            如果以上链接无法点击，请将它复制到你的浏览器地址栏中进入访问，该链接24小时内有效。如果此次激活请求非你本人所发，请忽略本邮件";
            $message = $emailbody; 
            $rs= mail($smtpemailto, $subject, $message, $headers); 
            if ($rs) {
                $msg = '注册成功！请登录到您的邮箱及时激活您的帐号！';
                echo "<script>alert('恭喜你$user_name, $msg')</script>";
                echo "<script>window.open('active.php', '_self')</script>";
                
            } else {
                return false;
            }
        }
        else {
            echo "<script>alert('注册失败')</script>";
            echo "<script>window.open('signup.php', '_self')</script>";
        }
    }
?>