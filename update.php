<?php
    include('include/connection.php');
//upload.php

if (isset($_POST['image'])) {

    $user = $_SESSION['user_email'];
    $get_user = "select * from users where user_email = '$user'";
    $run_user = mysqli_query($con, $get_user);
    $row = mysqli_fetch_array($run_user);
    $user_id = $row['user_id'];

    $data = $_POST['image'];

    $image_array_1 = explode(";", $data);

    $image_array_2 = explode(",", $image_array_1[1]);

    $data = base64_decode($image_array_2[1]);

    $image_name = '../img/avertar' . time() . '.png';

    file_put_contents($image_name, $data);

    $insert_image_name = 'img/avertar' . time() . '.png';

    echo $image_name;
    
    $img_query = "UPDATE `users` set `user_image` = '$insert_image_name' Where user_id = '$user_id'";
    
        echo "<script>alert('$error')</script>";
    
    


}


?>