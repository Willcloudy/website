<?php 
    include('../include/connection.php');

    $post_id = $_POST['postId'];
    $user_id = $_POST['userId'];

    $delete_qu = "DELETE from `posts` WHERE `post_id` = '$post_id' and `user_id` = '$user_id'";

    $delete_query = mysqli_query($con, $delete_qu);

    echo mysqli_error($con);
    if ($delete_query) {
        echo '成功'.mysqli_error($con);;
    }else {
        echo '失败';
    }
    
?> 