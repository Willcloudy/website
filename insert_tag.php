<?php

    $uni_info_query = "SELECT * FROM `university`";

    $run_uni_info = mysqli_query($con, $uni_info_query);
    echo mysqli_error($con);
    while($uni_info = mysqli_fetch_array($run_uni_info)){
        $uni_name_zh = $uni_info['zh'];
    }
?>