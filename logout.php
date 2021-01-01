<?php
  //开启 Session
session_start();
// 删除所有 Session 变量
$_SESSION = array();
//判断 cookie 中是否保存 Session ID

 if(isset($_COOKIE[session_name()])){
   setcookie(session_name(),'',time()-3600, '/');
}
//彻底销毁 Session
session_destroy();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>登出 - willcloudy</title>
    <link rel="icon" type="image/x-ico" href="img/logo.ico" />
    <link rel="apple-touch-icon" sizes="180x180" href="/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/favicon-16x16.png">
    <link rel="manifest" href="/site.webmanifest">

</head>
<body>
    已经成功登出,2秒后进行重定向,如果浏览器没有反应请点击这里返回 <a href="home.php">主页</a> 
</body>
</html>
<script>
setTimeout("self.location = 'home.php'", 2000);
</script>