<?php
if($webpage == 'home'){
    include("include/connection.php");
}elseif ($webpage == 2) {
    include("../include/connection.php");
}

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
        echo "<script>alert('邮箱或者密码错误(或是账号妹有激活)')</script>";
        echo "<script>window.open('home.php', '_self')</script>";
    }
}
?>