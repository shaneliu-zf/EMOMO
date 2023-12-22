<?php

require_once "db.php";

class User{
    private $user_id;
    private $name;
    private $email;
    private $password;
    private $address;
    private $user_type;

    function __construct($id,$name,$email,$password,$address,$user_type){
        $this->user_id = $id;
        $this->name = $name;
        $this->email = $email;
        $this->password = $password;
        $this->address = $address;
        $user_type = strtolower($user_type);
        print $user_type;
        $this->user_type = $user_type;
        $db = connectDB();
        if ($user_type == 'admin'){
            $checkQuery = "SELECT COUNT(*) as count FROM `Admin_list` WHERE `user_id` = $id";
        }
        elseif($user_type == 'customer'){
            $checkQuery = "SELECT COUNT(*) as count FROM `Customer_list` WHERE `user_id` = $id";
        }
        elseif($user_type == 'staff'){
            $checkQuery = "SELECT COUNT(*) as count FROM `Staff_list` WHERE `user_id` = $id";
        }
        $checkResult = mysqli_query($db, $checkQuery);
        if ($checkResult) {
            $row = mysqli_fetch_assoc($checkResult);
            $count = $row['count'];

            if ($count == 0) {
                // 不存在相同的 user_id，執行插入操作
                if ($user_type == 'admin'){
                    $insertQuery = "INSERT INTO `Admin_list` (`user_id`, `name`, `email`, `password`, `address`, `usertype`) VALUES ($id, '$name', '$email', '$password', '$address', '$user_type')";
                }
                elseif($user_type == 'customer'){
                    $insertQuery = "INSERT INTO `Customer_list` (`user_id`, `name`, `email`, `password`, `address`, `usertype`) VALUES ($id, '$name', '$email', '$password', '$address', '$user_type')";
                }
                elseif($user_type == 'staff'){
                    $insertQuery = "INSERT INTO `Staff_list` (`user_id`, `name`, `email`, `password`, `address`, `usertype`) VALUES ($id, '$name', '$email', '$password', '$address', '$user_type')";
                }
                $insertResult = mysqli_query($db, $insertQuery);
                
                if ($insertResult) {
                    echo "插入成功";
                } else {
                    echo "插入失敗: " . mysqli_error($db);
                }
            } else {
                // 存在相同的 user_id，返回錯誤
                echo "已存在相同的 user_id，請選擇其他 user_id";
            }

            // 釋放資源
            mysqli_free_result($checkResult);
        } else {
            echo "查詢失敗: " . mysqli_error($db);
        }

        // 關閉資料庫連接
        mysqli_close($db);
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