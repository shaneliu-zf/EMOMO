<?php

require_once "db.php";
require_once "Staff.php";

class Admin extends Staff{
    function __construct(){}

    public function getStaffId(){
        $db = connectDB();
        $sql = "SELECT `user_id` FROM `Staff_list`";
        $result = mysqli_query($db,$sql);
        mysqli_close($db);
        return $result;
    }

    public function getStaffName($id){
        $db = connectDB();
        $sql = "SELECT * FROM `User_list` WHERE `user_id` = $id";
        $result = mysqli_query($db,$sql);
        $row = mysqli_fetch_assoc($result);
        $name = $row['name'];
        mysqli_free_result($result);
        mysqli_close($db);
        return $name;
    }

    public function getStaffAddress($id){
        $db = connectDB();
        $sql = "SELECT * FROM `User_list` WHERE `user_id` = $id";
        $result = mysqli_query($db,$sql);
        $row = mysqli_fetch_assoc($result);
        $address = $row['address'];
        mysqli_free_result($result);
        mysqli_close($db);
        return $address;
    }

    public function getStaffemail($id){
        $db = connectDB();
        $sql = "SELECT * FROM `User_list` WHERE `user_id` = $id";
        $result = mysqli_query($db,$sql);
        $row = mysqli_fetch_assoc($result);
        $email = $row['email'];
        mysqli_free_result($result);
        mysqli_close($db);
        return $email;
    }

    public function getStaffimage($id){
        $db = connectDB();
        $sql = "SELECT * FROM `User_list` WHERE `user_id` = $id";
        $result = mysqli_query($db,$sql);
        $row = mysqli_fetch_assoc($result);
        $image = $row['image'];
        mysqli_free_result($result);
        mysqli_close($db);
        return $image;
    }

    public function deleteStaff($user_id){
        $db = connectDB();

        $sql = "DELETE FROM `Staff_list` WHERE `user_id`= $user_id;";
        $sql2 = "DELETE FROM `User_list` WHERE `user_id`= $user_id;";


        // 用mysqli_query方法執行(sql語法)將結果存在變數中
        mysqli_query($db,$sql);
        mysqli_query($db,$sql2);
        mysqli_close($db);
    }
}
