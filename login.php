<?php
require_once "db.php";

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];
    $db = connectDB();
    $checkQuery = "SELECT * FROM `user` WHERE `email`='$email' AND `password`='$password'";
    $checkResult = mysqli_query($db, $checkQuery);
    if ($checkResult) {
        $msg = 'success';
    } 
    else {
        $msg = 'failed';
        echo "Error <br />";
    }

    mysqli_close($db);

    echo "$msg <br />";
    echo "Email is: $email <br />";
    echo "User password is: $password";
}