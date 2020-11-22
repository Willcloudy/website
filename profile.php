<?php
    session_start();
    include('include/connection.php');
    if (isset($_SESSION['user_email'])) {
        $user = $_SESSION['user_email'];
        $get_user = "select * from users where user_email = '$user'";
        $run_user = mysqli_query($con, $get_user);
        $row = mysqli_fetch_array($run_user);
        $user_name = $row['user_name'];
        $user_image = $row['user_image'];
        $user_cover = $row['user_cover'];
        $user_des = $row['user_des'];
    }else {
        header('location:home.php?from=login');
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">  
    <script src="https://cdn.staticfile.org/jquery/2.1.1/jquery.min.js"></script>
    <link rel="stylesheet" href="https://cdn.staticfile.org/twitter-bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://cdn.staticfile.org/twitter-bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <title><?php echo $user_name?> - WillCloudy</title>
    <link rel="stylesheet" href="css/home.css">
    <style>
        .avatar{
            margin:0px;
            padding:0px;
            position:absolute;
            top:70px;
            left:20px;
            border:3px solid white;
        }
        .info{
            color:black;
            font-weight: bold;
            font-size:2em;
            margin-left:25%;
        }
        .des{
            color:black;
            font-weight:normal;
            font-size:1.4em;
            margin-left:40%;
        }
    </style>
</head>
<body>
<div class="container">
            <?php
                require('include/leftbar.php');
                echo "
                    <script>
                        var profile = document.getElementById('profile');
                        profile.style.display='block';
                        document.getElementById('sign').style.display='none';
                    </script>";
            ?>
            <div class="col-md-6" style='padding:0;'>
                <div class="box" style='margin-top:0;position:relative'>
                    <img src="<?php echo $user_cover;?>" alt="cover" width='100%' height='100px'style='margin:0;padding:0;'>
                    <img src="<?php echo $user_image;?>" alt="avatar" width='15%' class='img-circle avatar'>
                    <div>
                        <span class='info'><?php echo $user_name;?></span>
                        <span class="des"><?php echo $user_des;?></span>
                    </div>
                </div>  
            </div>
            <?php
                require('include/rightbar.php');
            ?>
    </div>
</body>
</html>
<script>
    document.getElementById("profileA").href = "javascript:volid(0);";
    var ele = document.getElementById("profileA");
    ele.style.color ="#00BFFF";
    ele.onmouseover =  function () {
    this.style.backgroundColor = "white";
    }
</script>
<?php
    if (isset($_GET['from'])) {
        if ($_GET['from'] == "login") {
            echo "<script>document.getElementById('sign').click()</script>";
        }
    }
?>