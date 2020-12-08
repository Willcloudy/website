<?php
    session_start();
    if (!isset($_POST['searchcontent'])) {
        header('location:explore.php');
    }elseif($_POST['searchcontent'] == ''){
        header('location:explore.php');
    }
    include('include/connection.php');
    $input = $_POST['searchcontent'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://cdn.staticfile.org/twitter-bootstrap/3.3.7/css/bootstrap.min.css">  
    <script src="https://cdn.staticfile.org/jquery/2.1.1/jquery.min.js"></script>
    <script src="https://cdn.staticfile.org/twitter-bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <title>搜索'<?php echo $input?>'结果 - WillCloudy</title>
    <link rel="stylesheet" href="css/css.css">
</head>
<body>
    <div class="container">
            <?php 
                if (isset($_SESSION['user_email'])) {
                    $user = $_SESSION['user_email'];
                    $get_user = "select * from users where user_email = '$user'";
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
                }
            ?>
            <div class="col-md-6 midbar">
                <div class="box">
                    <form action="result.php" method="POST">
                        <span>
                            <input class='form-control search' type="text" name='searchcontent' value='<?php echo $input?>' required='required'>
                        </span>
                        <span class='span2'>
                            <span class="glyphicon glyphicon-search glyphicon-search-explore" style='left: 3%;'>
                            <a href="result.php"><button class='form-control search-btn btn btn-primary'type='submit'></span></button></a>
                        </span>
                        <div style="clear:both;"></div>
                        <br>
                    </form> 
                </div>  
            </div>
            <?php
                // echo "<footer style='text-align:center;'>当前在线".$users_online."人<footer>";
                require('include/rightbar.php');
            ?>
    </div>
</body>
</html>