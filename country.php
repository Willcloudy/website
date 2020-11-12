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
    <title>物价对比 - WillCloudy</title>
    <link rel="stylesheet" href="css/home.css">
</head>
<body>
    <div class="container">
            <?php require('include/leftbar.php');?>
            <div class="col-md-6">
                <div class="box">
                    <h3 style='font-weight:bold;'>England/英国</h3>
                    <hr>
                </div>
            </div>
            <?php
                require('include/rightbar.php');
            ?>
            
    </div>
</body>
</html>