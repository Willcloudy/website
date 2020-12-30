<?php
    include('include/connection.php');
    
$id = $_POST['delete_id'];
$query = mysqli_query($con, "DELETE FROM question WHERE qu_id='$id'");


?>