<?php
@session_start();
include("include/connection.php");
    if (isset($_POST['sign_in'])) {
        $email = $_POST['email'];
        $pass = $_POST['password'];

        $mdpass = md5($pass);
        $select_user = "SELECT * FROM users WHERE user_email = '$email' AND user_password='$mdpass' AND status='1'";

        $query= mysqli_query($con, $select_user);
        $check_user = mysqli_num_rows($query);
        if ($check_user == 1) {
            $_SESSION['user_email'] = $email;
            echo "<script>window.open('home.php', '_self')</script>";
        }else{
            echo "<script>alert('Your Email or Password is incorrect $pass 和 $pass')</script>";
            echo "<script>window.open('home.php?from=login', '_self')</script>";
        }
    }
?>