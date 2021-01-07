<?php 
    include('../include/connection.php');

    $post_id = $_POST['postId'];
    $user_id = $_POST['userId'];

    if (!empty($post_id) and !empty($user_id)) {
        $select_shou = "SELECT * FROM `shoucang` WHERE post_id = '$post_id' and user_id = '$user_id' and type = 'post'";
        $select_query = mysqli_query($con, $select_shou);
        if (mysqli_num_rows($select_query) == 0 ) {
            $insert_shou = "INSERT INTO shoucang (post_id, user_id, date, type) values ('$post_id', '$user_id', NOW(), 'post')";
            $insert_query = mysqli_query($con, $insert_shou);

            echo mysqli_error($con);
            if ($insert_query) {
                echo '收藏成功';
            }else {
                echo '收藏错误';
            }
        }else {
            echo '请勿重复收藏';
        }
    }else {
        exit;
    }
    
    
    
?> 