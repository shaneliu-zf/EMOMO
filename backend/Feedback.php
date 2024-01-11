<?php
include_once "db.php";

class Feedback{
    public function __construct(){
        
    }
    public static function SaveFeedbacks($name,$email,$suggestion,$submitTime){
        $db = connectDB();
        $insertQuery = "INSERT INTO `Feedbacks` (`name`, `email`, `suggestion`,`date`) VALUES ('$name','$email','$suggestion','$submitTime')";
        $insertResult = mysqli_query($db, $insertQuery);
        mysqli_close($db);
    }

    public static function getFeedbacks(){
        $db = connectDB();
        $checkQuery = "SELECT * FROM `Feedbacks`";
        if ($checkResult = mysqli_query($db, $checkQuery)) {
            mysqli_close($db);
            return $checkResult;
        }
        else {
            echo "無任何商品";
            mysqli_close($db);
        }
    }

}