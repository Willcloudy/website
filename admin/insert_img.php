<?php
include('../include/connection.php');
if (isset($_POST['submit'])) {
    $uni_name_zh = $_POST['uni_name_zh'];
    $uni_img = $_FILES['uni_img']['name'];
    $image_tmp = $_FILES['uni_img']['tmp_name'];
    $random_number = rand(1,1000);
    if(move_uploaded_file($image_tmp, '../img/avertar'.$uni_img)){
        $update = "UPDATE university SET uni_img = 'img/$uni_img' where uni_name_zh ='$uni_name_zh'";
                            
        $run = mysqli_query($con, $update);
    }else {
        echo 'false';
    }
    
}else {
    echo "no files";
}

?>