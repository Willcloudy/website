<?php 
    include('../include/connection.php');

    $post_id = $_POST['postId'];
    $user_id = $_POST['userId'];
    if (!empty($post_id) and !empty($user_id)) {
        $delete_shou_post = "DELETE from `shoucang` where `user_id` = '$user_id' and `type`='post' and `post_id` ='$post_id'";
        
        $delete_query = mysqli_query($con, $delete_shou_post);
        if ($delete_query){
            echo '删除成功';
        }else {
            echo '执行失败';
        }
    }else {
        echo "未接收到数据";
    }

    
    
?> 