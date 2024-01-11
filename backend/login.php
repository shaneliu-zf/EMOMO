<?php
ini_set('display_errors','1');
error_reporting(E_ALL);
require_once "db.php";

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];
    $db = connectDB();
    $checkQuery = "SELECT COUNT(*) as count FROM `User_list` WHERE `email` = '$email' AND `password`='$password'";
    $checkResult = mysqli_query($db, $checkQuery);
    if ($checkResult){
        $row = mysqli_fetch_assoc($checkResult);
        $count = $row['count'];
        if ($count != 0) {
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

}
