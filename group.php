<?php
    include('include/connection.php');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://cdn.staticfile.org/twitter-bootstrap/3.3.7/css/bootstrap.min.css">  
    <script src="https://cdn.staticfile.org/jquery/2.1.1/jquery.min.js"></script>
    <script src="https://cdn.staticfile.org/twitter-bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <title>兴趣组 - WillCloudy</title>
    <link rel="stylesheet" href="css/home.css">
</head>
<body>
    <div class="container">
            <?php require('include/leftbar.php');?>
            <div class="col-md-6">
                <div class="box">
                    
                </div>  
            </div>
            <?php
                require('include/rightbar.php');
            ?>
    </div>
</body>
</html>
<script>
    var ele = document.getElementById("group");
    ele.href="javascript:volid(0);";
    //ele.style.backgroundColor = "rgb(181,212,213)";
    ele.style.color ="#00BFFF";
    ele.onmouseover =  function () {
    this.style.backgroundColor = "white";
    }
</script>