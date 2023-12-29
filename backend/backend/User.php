<?php

require_once "db.php";

class User{
    private $user_id;
    private $name;
    private $email;
    private $password;
    private $address;
    private $user_type;
    private bool $isRegistered;

    function __construct($name,$email,$password,$address,$user_type){
        $db = connectDB();
        $this->name = $name;
        $this->email = $email;
        $this->password = $password;
        $this->address = $address;
        $user_type = strtolower($user_type);
        $this->user_type = $user_type;
        $checkQuery = "SELECT COUNT(*) as count FROM `Customer_list` WHERE `email` = '$email'";
        $checkCount = "SELECT COUNT(*) AS TotalItems FROM `Customer_list`";
        $checkCountResult = mysqli_query($db,$checkCount);
        $row = mysqli_fetch_assoc($checkCountResult);
        $count = $row['TotalItems'];
        $this->user_id = $count;
        $checkResult = mysqli_query($db, $checkQuery);
        if ($checkResult) {
            $row = mysqli_fetch_assoc($checkResult);
            $count = $row['count'];

            if ($count == 0) {
                $this->isRegistered = false;
                // 不存在相同的 user_id，執行插入操作
                if ($user_type == 'admin'){
                    $insertQuery = "INSERT INTO `Customer_list` (`user_id`, `name`, `email`, `password`, `address`, `usertype`) VALUES ($this->user_id, '$name', '$email', '$password', '$address', '$user_type')";
                    $insertQuery2 = "INSERT INTO `Admin_list` (`user_id`) VALUES ($this->user_id)";
                    $insertResult2 = mysqli_query($db, $insertQuery2);
                }
                elseif($user_type == 'customer'){
                    $insertQuery = "INSERT INTO `Customer_list` (`user_id`, `name`, `email`, `password`, `address`, `usertype`) VALUES ($this->user_id, '$name', '$email', '$password', '$address', '$user_type')";
                }
                elseif($user_type == 'staff'){
                    $insertQuery = "INSERT INTO `Customer_list` (`user_id`, `name`, `email`, `password`, `address`, `usertype`) VALUES ($this->user_id, '$name', '$email', '$password', '$address', '$user_type')";
                    $insertQuery2 = "INSERT INTO `Staff_list` (`user_id`) VALUES ($this->user_id)";
                    $insertResult2 = mysqli_query($db, $insertQuery2);
                }
                $insertResult = mysqli_query($db, $insertQuery);
                
            }
            else{
                $this->isRegistered = true;
            }
            // 釋放資源
            mysqli_free_result($checkResult);
        }
        // 關閉資料庫連接
        mysqli_close($db);
    }

    public function getIsRegistered(){
        return $this->isRegistered;
    }

    public function getUser_id(){
        return $this->user_id;
    }

    public function getName(){
        return $this->name;
    }

    public function getEmail(){
        return $this->email;
    }

    public function getPassword(){
        return $this->password;
    }

    public function getAddress(){
        return $this->address;
    }

    public function getUserType(){
        return $this->user_type;
    }
}