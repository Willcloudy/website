<?php 
include('connection.php');
if (isset($_GET['id'])) {
    header('Content-type: application/json; charset=UTF-8');
    $post_id = $_GET['id'];
    $user_id = $_GET['userid'];
    $select_post = "SELECT `post_like` FROM `posts` WHERE post_id = $post_id";
    $select_query = mysqli_query($con, $select_post);
    echo mysqli_error($con);
    $row = mysqli_fetch_array($select_query);
    $post_like = $row['post_like'];
    $update_like = $post_like + 1;

    $insert_like = "INSERT INTO like_post (post_id, user_id, like_date) values ('$post_id', '$user_id',NOW())";
    $insert_query = mysqli_query($con, $insert_like);

    $like_post = "UPDATE `posts` SET `post_like` = $update_like WHERE post_id = $post_id";
    $update_query = mysqli_query($con, $like_post);


    echo mysqli_error($con);
    if ($update_query) {
        echo '{"status": 1}';
    }else {
        echo '{"status": 2}';
    }

}
?> 