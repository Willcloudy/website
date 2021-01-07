<?php
    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\Exception;
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

        $profile_pic = "img/user.svg";
        $cover = 'img/bcimg/1609761242.png';
        
        mysqli_query($con, "set names 'utf8'");
        $insert = "INSERT INTO users (user_name, 
        user_des, user_password, user_email, user_image, user_cover, regtime, posts, token, token_exptime, `status`) values 
        ('$user_name', '这个人很懒什么都没有留下', 
        '$pass', '$email', '$profile_pic', '$cover', '$regtime', '$posts','$token','$token_exptime','0')";
        
        mysqli_query($con, "set names 'utf8'");
        $query = mysqli_query($con, $insert);
        if ($query) {
            require './PHPMailer-master/src/Exception.php';
            require './PHPMailer-master/src/PHPMailer.php';
            require './PHPMailer-master/src/SMTP.php';
            //echo "<script>window.open('home.php', '_self')</script>";
            $emailtype = "HTML"; //信件类型，文本:text；网页：HTML
            $smtpemailto = $email;
            $emailsubject = "=?UTF-8?B?".base64_encode("⚡用户帐号激活🔥")."?=";
            
            $subject = stripslashes($emailsubject); 
            // @$headers　= "MIME-Version: 1.0\r\n"; 
            // $headers .= "Content-type: text/html; charset=utf-8\r\n"; 
            // $headers .= "Content-Transfer-Encoding: 8bit\r\n"; 
            
            $emailbody = "
            $user_name , 感谢您在我站注册了新帐号。请点击链接激活您的帐号。
            <br>
            <br>
            https://www.willcloudy.com/active.php?verify=$token
            <br>
            <br>
            如果以上链接无法点击，请将它复制到你的浏览器地址栏中进入访问，该链接24小时内有效。
            <br>
            <br>
            如果此次激活请求非你本人所发，请忽略本邮件";
            // $message = $emailbody; 
            // $rs= mail($smtpemailto, $subject, $message, $headers); 

            $mail = new PHPMailer(); //建立邮件发送类
            $mail->CharSet ="UTF-8";                     //设定邮件编码
            $mail->SMTPDebug = 0;  
            $address = $email;
            $mail->IsSMTP(); // 使用SMTP方式发送
            $mail->Host = "smtp.163.com"; // 您的企业邮局域名
            $mail->SMTPAuth = true; // 启用SMTP验证功能
            $mail->Username = "willcloudy@163.com"; // 邮局用户名(请填写完整的email地址)
            $mail->Password = "HSUOJDNMILDIBCLC"; // 邮局密码
            $mail->SMTPSecure = 'ssl';                    // 允许 TLS 或者ssl协议
            $mail->Port = 465; 

            $mail->setFrom("willcloudy@163.com","Willcloudy"); //邮件发送者email地址
            $mail->AddAddress("$address", "$user_name");//收件人地址，可以替换成任何想要接收邮件的email信箱,格式是AddAddress("收件人email","收件人姓名")
            //$mail->AddReplyTo("", "");

            //$mail->AddAttachment("/var/tmp/file.tar.gz"); // 添加附件
            //$mail->IsHTML(true); // set email format to HTML //是否使用HTML格式
            $mail->isHTML(true);
            $mail->Subject = $subject; //邮件标题
            $mail->Body = $emailbody . date('Y-m-d H:i:s'); //邮件内容
            //$mail->AltBody = "This is the body in plain text for non-HTML mail clients"; //附加信息，可以省略
            if($mail->Send()){
            $msg = '注册成功！请登录到您的邮箱及时激活您的帐号！';
            echo "<script>alert('恭喜你$user_name, $msg')</script>";
            echo "<script>window.open('active.php', '_self')</script>";
            }else{
                echo "<script>alert('邮件发送失败')</script>" ;
                echo $mail->ErrorInfo;
            }
        }
        else {
            //echo mysqli_error($con);
            echo "<script>alert('注册失败')</script>" . mysqli_error($con);
            echo "<script>window.open('signup.php', '_self')</script>";
        }
    }
?>