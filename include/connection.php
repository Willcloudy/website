<?php
    @header("Content-type:text/html;charset=utf8");
    //$con = mysqli_connect('localhost','mark','Hezhe123','mark') or die("Database error");
    $con = mysqli_connect('127.0.0.1','root','','willcloudy') or die("Database error");
    //$con = mysqli_connect('127.0.0.1','root','F05cc2f54163','willcloudy') or die("Database error");
    @$conn = mysqli_query("SET NAMES utf8");
?>
