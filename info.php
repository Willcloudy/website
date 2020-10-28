<?php
    include('include/connection.php');
    if (!isset($_GET['uni_name_zh'])) {
        header('location:home.php');
    }else {
        $uni_name_zh = $_GET['uni_name_zh']; 
    }
    $search_query = "SELECT * FROM `university` where uni_name_zh = '$uni_name_zh' ";
    $run_search = mysqli_query($con, $search_query);
    $row = mysqli_fetch_array($run_search);

    $uni_name_en = $row['uni_name_en'];
    $uni_name_zh = $row['uni_name_zh'];
    $uni_country = $row['uni_country'];
    $uni_location = $row['uni_location'];
    $uni_img = $row['uni_img'];
    $uni_link = $row['uni_link'];
    $uni_icon = $row['uni_icon'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://cdn.staticfile.org/twitter-bootstrap/3.3.7/css/bootstrap.min.css">  
    <script src="https://cdn.staticfile.org/jquery/2.1.1/jquery.min.js"></script>
    <script src="https://cdn.staticfile.org/twitter-bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <title><?php echo $uni_name_zh.'- WillCloudy'?> </title>
    <link rel="stylesheet" href="home.css">
</head>
<body>
<div class="container">
        <?php require('include/leftbar.php');?>
        <div class="col-md-6" style='padding:0px'>
            <div class="box">
                <h3 style='font-weight:bold;padding:10px;'>
                    <?php echo 'University Info / '.$uni_name_zh?>
                    <span style='font-size:14px;color:grey'>
                        <?php echo '  '.$uni_name_en?>
                    </span>
                </h3>
                <div style='position:absolute;'>
                    <img src="<?php echo $uni_img;?>" alt="" class='img-responsive' style='margin:0px;padding:0;'>
                    <img src="<?php echo $uni_icon;?>" alt="" class='img-responsive' width='150px' style='position:relative;top:-210px;left:30px;display:inline'>
                </div>
            </div>  
        </div>


        <?php
            // echo "<footer style='text-align:center;'>当前在线".$users_online."人<footer>";
            require('include/rightbar.php');
        ?>
</div>
</body>
</html>