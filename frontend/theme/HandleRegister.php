<?php
    ini_set('display_errors','1');
    error_reporting(E_ALL);
    require_once "../../backend/User.php";
    include "header.php";
    if ($_SERVER['REQUEST_METHOD'] == "POST"){
        $name = $_POST['name'];
        $address = $_POST['address'];
        $email = $_POST['email'];
        $usertype = "Customer";
        $password = $_POST['password'];
        $Newuser = new User(0,$name,$email,$password,$address,$usertype);
    }
    $result = $Newuser->getIsRegistered();
    if($result){
        echo "<a href='/Register.php'>已註冊過或有相同email，點我跳轉回註冊介面</a>";
    }
    else{
        echo "<a href='/about.php'>註冊成功，點我跳轉回主頁</a>";
    }
    include "footer.php";
    
?>
