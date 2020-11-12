<?php
    header('Content-type: text/html; charset=utf-8');
    include('include/connection.php');
    // $online_log = "count.dat"; //保存人数的文件,
    // $timeout = 30;//30秒内没动作者,认为掉线
    // $entries = file($online_log);

    // $temp = array();

    // for ($i=0;$i<count($entries);$i++) {
    // $entry = explode(",",trim($entries[$i]));
    // if (($entry[0] != $_SERVER["REMOTE_ADDR"]) && ($entry[1] > time())) {
    // array_push($temp,$entry[0].",".$entry[1]."\n"); //取出其他浏览者的信息,并去掉超时者,保存进$temp
    // }
    // }

    // array_push($temp,$_SERVER["REMOTE_ADDR"].",".(time() + ($timeout))."\n"); //更新浏览者的时间
    // $users_online = count($temp); //计算在线人数

    // $entries = implode("",$temp);
    // 写入文件
    // $fp = fopen($online_log,"w");
    // flock($fp,LOCK_EX); //flock() 不能在NFS以及其他的一些网络文件系统中正常工作
    // fputs($fp,$entries);
    // flock($fp,LOCK_UN);
    // fclose($fp); 
    // echo "<footer style='text-align:center;'>当前在线".$users_online."人<footer>";
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://cdn.staticfile.org/twitter-bootstrap/3.3.7/css/bootstrap.min.css">  
    <script src="https://cdn.staticfile.org/jquery/2.1.1/jquery.min.js"></script>
    <script src="https://cdn.staticfile.org/twitter-bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <title>首页 - WillCloudy</title>
    <link rel="stylesheet" href="css/home.css">
</head>
<body>
<div class="container">
            <?php require('include/leftbar.php');?>
            <div class="col-md-6">
                <div class="box">
                    <h3 style='font-weight:bold;'>Home/首页</h3>
                    <hr>
                    
                </div>  
            </div>
            <?php
                require('include/rightbar.php');
            ?>
    </div>
</body>
</html>
<script>
    document.getElementById("logo").href = "javascript:volid(0);";
    var ele = document.getElementById("home");
    ele.href="javascript:volid(0);";
    ele.style.color ="#00BFFF";
    ele.onmouseover =  function () {
    this.style.backgroundColor = "white";
    }
</script>