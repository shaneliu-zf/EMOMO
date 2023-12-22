<?php
    ini_set('display_errors','1');
    error_reporting(E_ALL);
    require_once "User.php";

    if ($_SERVER['REQUEST_METHOD'] == "POST"){
        $id = $_POST['id'];
        $name = $_POST['name'];
        $address = $_POST['address'];
        $email = $_POST['email'];
        $usertype = $_POST['usertype'];
        $password = $_POST['password'];
        $user = new User($id,$name,$email,$password,$address,$usertype);
        echo $id,$name,$email,$password,$address,$usertype;
    }
    
?>
