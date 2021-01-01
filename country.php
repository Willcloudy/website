<?php  
    session_start();
    include('include/connection.php');
    if (empty($_GET['selectednation'])) {
        header('Location:home.php');
    }else {
        $country = $_GET['selectednation'];
        if ($country == 'England' || $country == 'UK' || $country == '英国') {
            $en_country = 'England';
            $cn_country = '英国';
        }elseif ($country == 'Canada' || $country == 'CAN' || $country == '加拿大') {
            $en_country = 'Canada';
            $cn_country = '加拿大';
        }elseif ($country == 'Australia' || $country == 'AUS' || $country == '澳大利亚') {
            $en_country = 'Australia';
            $cn_country = '澳大利亚';
        }else {
            header('Location:home.php');
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
    <title><?php echo $cn_country?> - willcloudy</title>
    <link rel="stylesheet" href="css/css.css">
    <link rel="icon" type="image/x-ico" href="img/logo.ico" />
    <link rel="apple-touch-icon" sizes="180x180" href="/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/favicon-16x16.png">
    <link rel="manifest" href="/site.webmanifest">

    <style>
        .selectednation{
            border:1px solid  #198754;
            color:rgb(91, 112, 131);
            border-radius:10px;
            padding:3px;
        }
        .selectednation:focus{
            outline:none;
        }
        @media(max-width:992px){
            form{
                margin-right:105px !important;
            }
            #uni-img img{
                display:none;
            }
            .uni-mini-word-info{
                margin-left:15px;
            }
            ul{
                padding-left:10px !important;
            }
            #uni_name{
                margin-left:10px !important;
            }
        }
    </style>
</head>
<body>
    <div class="container">
            <?php 
                if (isset($_SESSION['user_email'])) {
                    $user = $_SESSION['user_email'];
                    $get_user = "select * from users where user_email = '$user'";
                    mysqli_query($con, "set names 'utf8'");

                    $run_user = mysqli_query($con, $get_user);
                    $row = mysqli_fetch_array($run_user);
                    $u_name = $row['user_name'];
                    $u_image = $row['user_image'];
                    $u_id = $row['user_id'];
                    require('include/leftbar.php');
                    echo "
                        <script>
                            var profile = document.getElementById('profile');
                            profile.style.display='block';
                            document.getElementById('sign').style.display='none' 
                        </script>";
                }else {
                    require('include/leftbar.php');
                    echo "<script>document.getElementById('sign').style.display='block' </script>";

                }
            ?>
            <div class="col-md-6 midbar">
                <div class="box">
                    <h3 style='font-weight:bold;float:left;margin-left:10px;'><?php echo $cn_country."大学";?></h3>
                    <form style='float:right;margin-top:24px;margin-right:260px;'action="country.php" method="GET">
                        <span>
                            <select class='selectednation' name="selectednation" required='required' onchange="window.location=this.value" id="selectednation">
                                <option disable>更换国家</option>
                                <option value="country.php?selectednation=UK">英国</option>
                                <option value="country.php?selectednation=CAN">加拿大</option>
                                <option value="country.php?selectednation=AUS">澳大利亚</option>
                            </select>
                        </span>
                        <div style="clear:both;"></div>
                    </form>
                    <div style='clear:both'></div>
                    <hr>
                </div>
                <?php
                    include('include/get_post.php');
                    get_country($cn_country);
                    
                ?>
            </div>
            <?php
                require('include/rightbar.php');
            ?>
            
    </div>
</body>
</html>

<script>

    document.getElementById('search-small').style.display='block'

    document.getElementById('other').style.display='block'
</script>