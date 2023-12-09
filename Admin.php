<?php


class Admin extends Staff{
    function insertStaff(Staff $staff){
        $link = ConnectToDataBase("mydb");
        $id = $staff->getUser_id();
        $name = $staff->getName();
        $email = $staff->getEmail();
        $password = $staff->getPassword();
        $address = $staff->getAddress();
        $type = $staff->getUserType();
        $sql = "INSERT INTO  `StaffList` (`user_id`,`name`, `email`,`password`,`address`,`usertype`) VALUE ($id,$name,$email,$password,$address,$type) ";
        // 用mysqli_query方法執行(sql語法)將結果存在變數中
        mysqli_query($link,$sql);
        mysqli_close($link); 
    }
    function deleteStaff($user_id){
        $link = ConnectToDataBase("mydb");
        $sql = "DELETE FROM `StaffList` WHERE `id`= $user_id;";
        // 用mysqli_query方法執行(sql語法)將結果存在變數中
        mysqli_query($link,$sql);
        mysqli_close($link); 
    }

}