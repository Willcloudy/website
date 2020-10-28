<?php
    include('../include/connection.php');
    if (!isset($_GET['uni_name_en'])) {
        header('location:in_info.php');
    }else{
        $uni_name_en = $_GET['uni_name_en'];
        $uni_name_zh = $_GET['uni_name_zh'];
        $check_uni = "SELECT * FROM university where uni_name_zh = '$uni_name_zh'";
        $run_uni = mysqli_query($con, $check_uni);

        $check = mysqli_num_rows($run_uni);

        if ($check == 1) {
            echo "<script>alert('university already exist')</script>";

            echo "<script>window.open('in_info.php', '_self')</script>";
            exit();
        }else {
            $uni_country = $_GET['uni_country'];
            $uni_location = $_GET['uni_location'];
            $uni_link = $_GET['uni_link'];

            $insert_uni = "INSERT INTO `university` (uni_name_en, uni_name_zh, uni_country, uni_location, uni_link) 
            VALUES ('$uni_name_en','$uni_name_zh','$uni_country','$uni_location','$uni_link')";
            $run_insert= mysqli_query($con, $insert_uni);

            $insert_rank = "INSERT INTO `rank` (uni_name_zh) VALUES ('$uni_name_zh')";
            $run_rank= mysqli_query($con, $insert_rank);
            echo "<script>window.open('in_img.php?uni_name_zh=$uni_name_zh', '_self')</script>";
        }
    }
?>
