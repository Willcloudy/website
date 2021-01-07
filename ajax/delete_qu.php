<?php 
    include('../include/connection.php');

    $post_id = $_POST['quId'];
    $user_id = $_POST['userId'];

    $delete_qu = "DELETE from `question` WHERE `qu_id` = '$post_id' and `user_id` = '$user_id'";

    $delete_query = mysqli_query($con, $delete_qu);

    echo mysqli_error($con);
    if ($delete_query) {
        echo '';
    }else {
        echo '失败';
    }
    
?> 