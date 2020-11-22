<?php  
    session_start();
    include('include/connection.php');
    if (!isset($_GET['country'])) {
        header('Location:home.php');
    }else {
        $country = $_GET['country'];
        if ($country == 'England' || $country == 'UK') {
            $en_country = 'England';
            $cn_country = '英国';
        }elseif ($country == 'Canada' || $country == 'CAN') {
            $en_country = 'Canada';
            $cn_country = '加拿大';
        }elseif ($country == 'Australia' || $country == 'AUS') {
            $en_country = 'Australia';
            $cn_country = '澳大利亚';
        }
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://cdn.staticfile.org/twitter-bootstrap/3.3.7/css/bootstrap.min.css">  
    <script src="https://cdn.staticfile.org/jquery/2.1.1/jquery.min.js"></script>
    <script src="https://cdn.staticfile.org/twitter-bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <title><?php echo $cn_country?> - WillCloudy</title>
    <link rel="stylesheet" href="css/home.css">
</head>
<body>
    <div class="container">
            <?php 
                if (isset($_SESSION['user_email'])) {
                    $user = $_SESSION['user_email'];
                    $get_user = "select * from users where user_email = '$user'";
                    $run_user = mysqli_query($con, $get_user);
                    $row = mysqli_fetch_array($run_user);
                    $user_name = $row['user_name'];
                    $user_image = $row['user_image'];
                    require('include/leftbar.php');
                    echo "
                        <script>
                            var profile = document.getElementById('profile');
                            profile.style.display='block';
                            document.getElementById('sign').style.display='none' 
                        </script>";
                }else {
                    require('include/leftbar.php');
                }
            ?>
            <div class="col-md-6">
                <div class="box">
                    <h3 style='font-weight:bold;'><?php echo $en_country."/".$cn_country;?></h3>
                    <hr>
                </div>
            </div>
            <?php
                require('include/rightbar.php');
            ?>
            
    </div>
</body>
</html>