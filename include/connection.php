<?php
    @header("Content-type:text/html;charset=utf8");
    //$con = mysqli_connect('localhost','markeymark','Hezhe123','markeymark') or die("Database error");
    $con = mysqli_connect('127.0.0.1','root','','willcloudy') or die("Database error");
    @$conn = mysqli_query("SET NAMES utf8");
?>