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
    <title>登出 - WillCloudy</title>
</head>
<body>
    已经成功登出点击这里返回 <a href="home.php">主页</a> 
</body>
</html>