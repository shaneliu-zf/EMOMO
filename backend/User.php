<?php

require_once "db.php";

class User{
    private $user_id;
    private $name;
    private $email;
    private $password;
    private $address;
    private $user_type;
    private $image;
    private bool $isRegistered;

    function __construct(){}

    public function createNewUser($name,$email,$password,$address,$user_type){
        $db = connectDB();
        $this->name = $name;
        $this->email = $email;
        $this->password = $password;
        $this->address = $address;
        $user_type = strtolower($user_type);
        $this->user_type = $user_type;
        $checkQuery = "SELECT COUNT(*) as count FROM `User_list` WHERE `email` = '$email'";
        $checkCount = "SELECT MAX(user_id)+1 AS TotalItems FROM `User_list`";
        $checkCountResult = mysqli_query($db,$checkCount);
        $row = mysqli_fetch_assoc($checkCountResult);
        $count = $row['TotalItems'];
        $finalNumberQuery = "SELECT * FROM `User_list` ORDER BY `user_id` DESC LIMIT 0, 1";
        $getfinalNumber  = mysqli_query($db, $finalNumberQuery);
        if ($getfinalNumber) {
            $row = mysqli_fetch_assoc($getfinalNumber);
            $final = $row['user_id'];
        }
        else {
            echo "Error: " . mysqli_error($db);
        }
        if($final == ($count - 1)){
            $this->user_id = $count;
        }
        else{
            $missNumber = "SELECT product_id + 1 AS missing_id
                            FROM Product_list
                            WHERE NOT EXISTS (
                                SELECT 1
                                FROM Product_list P
                                WHERE P.product_id = Product_list.product_id + 1
                            )
                            ORDER BY product_id
                            LIMIT 1";

            $getMissNumber = mysqli_query($db, $missNumber);

            if ($getMissNumber) {
                // 檢查結果集是否存在
                if ($row = mysqli_fetch_assoc($getMissNumber)) {
                    $miss = $row['missing_id'];
                    $this->user_id = $miss;
                }
                else {
                    echo "No missing number found.";
                }
            }
            else {
                // 處理 mysqli_query 失敗的情況
                echo "Error: " . mysqli_error($db);
            }
        }
        $checkResult = mysqli_query($db, $checkQuery);
        if ($checkResult) {
            $row = mysqli_fetch_assoc($checkResult);
            $count = $row['count'];

            if ($count == 0) {
                $this->isRegistered = false;
                // 不存在相同的 user_id，執行插入操作
                if ($user_type == 'admin'){
                    $insertQuery = "INSERT INTO `User_list` (`user_id`, `name`, `email`, `password`, `address`, `usertype`, `image`) VALUES ($this->user_id, '$name', '$email', '$password', '$address', '$user_type', 'images/duck.jpg')";
                    $insertQuery2 = "INSERT INTO `Admin_list` (`user_id`) VALUES ($this->user_id)";
                    $insertResult2 = mysqli_query($db, $insertQuery2);
                }
                elseif($user_type == 'customer'){
                    $insertQuery = "INSERT INTO `User_list` (`user_id`, `name`, `email`, `password`, `address`, `usertype`, `image`) VALUES ($this->user_id, '$name', '$email', '$password', '$address', '$user_type', 'images/duck.jpg')";
                }
                elseif($user_type == 'staff'){
                    $insertQuery = "INSERT INTO `User_list` (`user_id`, `name`, `email`, `password`, `address`, `usertype`, `image`) VALUES ($this->user_id, '$name', '$email', '$password', '$address', '$user_type', 'images/duck.jpg')";
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

    public function loginCheck($email,$password){
        $db = connectDB();
        $query = "SELECT * FROM `User_list` WHERE `email` = '$email' AND `password` = '$password'";
        $checkResult = mysqli_query($db, $query);
        $flag = false;
        $user_id = -1;
        if (mysqli_num_rows($checkResult) > 0) {
            $row = mysqli_fetch_assoc($checkResult);
            $user_id = $row['user_id'];
            mysqli_free_result($checkResult);
            $flag = true;
        }
        mysqli_close($db);
        $result = array($flag,$user_id);
        return $result;
    }

    public function editUser($user_id,$name,$password,$address){
        $db = connectDB();
        $this->name = $name;
        $this->password = $password;
        $this->address = $address;
        $updateQuery = "UPDATE `User_list` SET
                        `name` = '$name',
                        `password` = '$password',
                        `address` = '$address'
                        WHERE `user_id` = '$user_id'";

        $result = mysqli_query($db, $updateQuery);

        // 關閉資料庫連接
        mysqli_close($db);
    }

    public function getIsRegistered(){
        return $this->isRegistered;
    }

    public function getUser_id(){
        return $this->user_id;
    }

    public function getName($id){
        $db = connectDB();
        $sql = "SELECT * FROM `User_list` WHERE `user_id` = $id";
        $result = mysqli_query($db,$sql);
        $row = mysqli_fetch_assoc($result);
        $name = $row['name'];
        mysqli_free_result($result);
        mysqli_close($db);
        return $name;
    }

    public function getEmail($id){
        $db = connectDB();
        $sql = "SELECT * FROM `User_list` WHERE `user_id` = $id";
        $result = mysqli_query($db,$sql);
        $row = mysqli_fetch_assoc($result);
        $email = $row['email'];
        mysqli_free_result($result);
        mysqli_close($db);
        return $email;
    }

    public function getImage($id){
        $db = connectDB();
        $sql = "SELECT * FROM `User_list` WHERE `user_id` = $id";
        $result = mysqli_query($db,$sql);
        $row = mysqli_fetch_assoc($result);
        $image = $row['image'];
        mysqli_free_result($result);
        mysqli_close($db);
        return $image;
    }

    public function getPassword(){
        return $this->password;
    }

    public function getAddress($id){
        $db = connectDB();
        $sql = "SELECT * FROM `User_list` WHERE `user_id` = $id";
        $result = mysqli_query($db,$sql);
        $row = mysqli_fetch_assoc($result);
        $address = $row['address'];
        mysqli_free_result($result);
        mysqli_close($db);
        return $address;
    }

    public function getUserType($id){
        $db = connectDB();
        $sql = "SELECT * FROM `User_list` WHERE `user_id` = $id";
        $result = mysqli_query($db,$sql);
        $row = mysqli_fetch_assoc($result);
        $address = $row['usertype'];
        mysqli_free_result($result);
        mysqli_close($db);
        return $address;
    }

    public static function isAdmin($id){
        $db = connectDB();
        $sql = "SELECT * FROM `Admin_list` WHERE user_id = $id";
        $result = mysqli_query($db, $sql);
        $row = mysqli_fetch_assoc($result);
        if($row == null){
            mysqli_free_result($result);
            mysqli_close($db);
            return false;
        }
        else{
            mysqli_free_result($result);
            mysqli_close($db);
            return true;
        }
    }

    public function getIdList(){
        $db = connectDB();
        $sql = "SELECT `user_id` FROM `User_list`";
        $result = mysqli_query($db,$sql);
        mysqli_close($db);
        return $result;
    }

    public static function isStaff($id){
        $db = connectDB();
        $sql = "SELECT * FROM `Staff_list` WHERE user_id = $id";
        $result = mysqli_query($db, $sql);
        $row = mysqli_fetch_assoc($result);
        if($row == null){
            mysqli_free_result($result);
            mysqli_close($db);
            return false;
        }
        else{
            mysqli_free_result($result);
            mysqli_close($db);
            return true;
        }
    }

    public function changeImage($user_id,$image){
        $db = connectDB();
        $this->$image = $image;
        $updateQuery = "UPDATE `User_list` SET `image` = '$image' WHERE `user_id` = '$user_id'";

        $result = mysqli_query($db, $updateQuery);

        // 關閉資料庫連接
        mysqli_close($db);
    }
}
