<?php
include('connection.php');


$sql = "select uni_icon, uni_id from `university`";
$run_uni_icon = mysqli_query($con, $sql);
$r = 0;
while($row = mysqli_fetch_array($run_uni_icon)){

    $str = $row['uni_icon'];
    $uni_id = $row['uni_id'];

    $str = str_replace(array("\r\n", "\r", "\n"), "", $str);  
    $pattern='/<img.+src=\"?(.+\.(jpg|gif|bmp|bnp|png))\"?.+>/i';
    preg_match_all($pattern,$str,$match);
    
    $uni_icon = implode($match[1]);
    echo $r +=1;
    echo "<br>";
    $uni_icon_query = "UPDATE `university` SET `uni_icon`= '$uni_icon' where uni_id =  $uni_id";
    $update_uni_icon = mysqli_query($con,$uni_icon_query);
    echo mysqli_error($con);
}

