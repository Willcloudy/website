<?php 
    include('../include/connection.php');

    $follower_id = $_POST['follower'];
    $user_id = $_POST['userId'];

    if (isset($follower_id) and isset($user_id)) {
        $select_shou = "Delete FROM `follow` WHERE follower_id = '$follower_id' and user_id = '$user_id'";
        $select_query = mysqli_query($con, $select_shou);
        if ($select_query) {
                echo '取消成功';
        }else {
            echo '取消错误';
        }
    }else {
        exit;
    }
?> 