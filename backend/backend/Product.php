<?php
include "db.php";

class Product{
    private $product_id;
    private $name;
    private $price;
    private $image;
    private bool $issucess;


    public function saveProduct($name,$price,$description,$image){
        $db = connectDB();
        $checkQuery = "SELECT COUNT(*) as count FROM `Product_list` WHERE `name` = '$name'";
        $checkCount = "SELECT COUNT(*) AS TotalItems FROM `Product_list`";
        $checkCountResult = mysqli_query($db,$checkCount);
        $row = mysqli_fetch_assoc($checkCountResult);
        $count = $row['TotalItems'];
        $id = $count + 1;
        $checkResult = mysqli_query($db, $checkQuery);
        if ($checkResult) {
            $row = mysqli_fetch_assoc($checkResult);
            $count = $row['count'];
            if ($count == 0){
                $this->issucess = true;
                $insertQuery = "INSERT INTO `Product_list` (`product_id`, `name`, `price`, `description`, `image`) VALUES ($id, '$name', '$price', '$description', '$image')";
                $insertResult = mysqli_query($db, $insertQuery);
            }
            else{
                $this->issucess = false;
            }
            mysqli_free_result($checkCountResult);
        }
        mysqli_close($db);
    }

    public function getIssucess(){
        return $this->issucess;
    }

    public function getProductId(){
        return $this->product_id;
    }

    public function getNamebyID($id){
        $db = connectDB();
        $sql = "SELECT * FROM `Product_list` WHERE `product_id` = $id";
        $result = mysqli_query($db,$sql);
        $row = mysqli_fetch_assoc($result);
        $name = $row['Name'];
        mysqli_free_result($result);
        mysqli_close($db);
        return $name;
    }

    public function getPricebyID($id){
        $db = connectDB();
        $sql = "SELECT * FROM `Product_list` WHERE `product_id` = $id";
        $result = mysqli_query($db,$sql);
        $row = mysqli_fetch_assoc($result);
        $price = $row['price'];
        mysqli_free_result($result);
        mysqli_close($db);
        return $price;
    }

    public function getImagebyID($id){
        $db = connectDB();
        $sql = "SELECT * FROM `Product_list` WHERE `product_id` = $id";
        $result = mysqli_query($db,$sql);
        $row = mysqli_fetch_assoc($result);
        $image = $row['image'];
        mysqli_free_result($result);
        mysqli_close($db);
        return $image;
    }
}