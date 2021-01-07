<?php 
    include('../include/connection.php');

    $follower_id = $_POST['follower'];
    $user_id = $_POST['userId'];

    if (isset($follower_id) and isset($user_id)) {
        $select_shou = "SELECT * FROM `follow` WHERE follower_id = '$follower_id' and user_id = '$user_id'";
        $select_query = mysqli_query($con, $select_shou);
        if (mysqli_num_rows($select_query) == 0 ) {
            $insert_shou = "INSERT INTO follow (user_id,follower_id, date) values ('$user_id', '$follower_id', NOW())";
            $insert_query = mysqli_query($con, $insert_shou);

            echo mysqli_error($con);
            if ($insert_query) {
                echo '关注成功';
            }else {
                echo '关注错误';
            }
        }
    }else {
        exit;
    }
?> 