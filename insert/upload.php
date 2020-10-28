<?php
    include('../include/connection.php');
//upload.php

if (isset($_POST['image']) && isset($_POST['uni_name_zh'])) {

    $data = $_POST['image'];

    $uni_name_zh = $_POST['uni_name_zh'];

    $image_array_1 = explode(";", $data);

    $image_array_2 = explode(",", $image_array_1[1]);

    $data = base64_decode($image_array_2[1]);

    $image_name = '../img/' . time() . '.png';

    file_put_contents($image_name, $data);

    $insert_image_name = 'img/' . time() . '.png';

    echo $image_name;
    
    $img_query = "UPDATE `university` set `uni_icon` = '$insert_image_name' Where uni_name_zh = '$uni_name_zh'";
    if (!$run_img = mysqli_query($con, $img_query)) {
        $error = mysqli_error($con);
        echo "<script>alert('$error')</script>";
    }
    


}


?>