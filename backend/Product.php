<?php
include_once "db.php";

class Product{
    private $product_id;
    private $name;
    private $price;
    private $image;
    private bool $issucess;

    public function saveProduct($name,$price,$description,$image){
        $db = connectDB();
        $checkQuery = "SELECT COUNT(*) as count FROM `Product_list` WHERE `name` = '$name'";
        $checkCount = "SELECT * FROM `Product_list` ORDER BY `product_id` DESC LIMIT 0, 1";
        $checkCountResult = mysqli_query($db,$checkCount);
        if ($row = mysqli_fetch_assoc($checkCountResult)) {
            // 當有資料時，取得第一個商品的 product_id
            $firstProductId = $row['product_id'];
            $id = $firstProductId + 1;
        } 
        else {
            echo "沒有商品資料";
        }
        $checkResult = mysqli_query($db, $checkQuery);
        if ($checkResult) {
            $row = mysqli_fetch_assoc($checkResult);
            $count = $row['count'];
            if ($count == 0){
                $this->issucess = true;

                $insertQuery = "INSERT INTO `Product_list` (`product_id`, `name`, `price`, `description`, `image`)
                VALUES ($id, '$name', '$price', '$description', '$image')";

                $insertResult = mysqli_query($db, $insertQuery);
            }
            else{
                $this->issucess = false;
            }
            mysqli_free_result($checkCountResult);
        }
        mysqli_close($db);
    }

    public function deleteProduct($id){
        $db = connectDB();
        $delete = "DELETE FROM `Product_list` WHERE `product_id` = $id";
        mysqli_query($db,$delete);
        mysqli_close($db);
    }

    public function getIssucess(){
        return $this->issucess;
    }

    public function getProductId(){
        return $this->product_id;
    }

    public static function getNamebyID($id){
        $db = connectDB();
        $sql = "SELECT * FROM `Product_list` WHERE `product_id` = $id";
        $result = mysqli_query($db,$sql);
        $row = mysqli_fetch_assoc($result);
        $name = NULL;
        if(self::checkIfInList($id)){
            $name = $row['name'];
        }
        mysqli_free_result($result);
        mysqli_close($db);
        return $name;
    }

    public static function getPricebyID($id){
        $db = connectDB();
        $sql = "SELECT * FROM `Product_list` WHERE `product_id` = $id";
        $result = mysqli_query($db,$sql);
        $row = mysqli_fetch_assoc($result);
        if(self::checkIfInList($id)){
            $price = $row['price'];
        }
        else{
            $price = 0;
        }
        mysqli_free_result($result);
        mysqli_close($db);
        return $price;
    }

    public static function getImagebyID($id){
        $db = connectDB();
        $sql = "SELECT * FROM `Product_list` WHERE `product_id` = $id";
        $result = mysqli_query($db,$sql);
        $row = mysqli_fetch_assoc($result);
        $image = $row['image'];
        mysqli_free_result($result);
        mysqli_close($db);
        return $image;
    }

    public static function getDescriptionbyID($id){
        $db = connectDB();
        $sql = "SELECT * FROM `Product_list` WHERE `product_id` = $id";
        $result = mysqli_query($db,$sql);
        $row = mysqli_fetch_assoc($result);
        $description = $row['description'];
        mysqli_free_result($result);
        mysqli_close($db);
        return $description;
    }

    public static function getAmount(){
        $db = connectDB();
        $checkCount = "SELECT COUNT(*) AS TotalItems FROM `Product_list`";
        $checkCountResult = mysqli_query($db,$checkCount);
        $row = mysqli_fetch_assoc($checkCountResult);
        $count = $row['TotalItems'];
        mysqli_free_result($checkCountResult);
        mysqli_close($db);
        return $count;
    }

    public static function getMax(){
        $db = connectDB();
        $checkCount = "SELECT Max(`product_id`) AS MaxNum FROM `Product_list`;";
        $checkCountResult = mysqli_query($db,$checkCount);
        $row = mysqli_fetch_assoc($checkCountResult);
        $Max = $row['MaxNum'];
        mysqli_free_result($checkCountResult);
        mysqli_close($db);
        return $Max;
    }

    public static function checkIfInList($id){
        $db = connectDB();
        $checkCount = "SELECT COUNT(*) AS Num FROM `Product_list` WHERE `product_id` = '$id';";
        $checkCountResult = mysqli_query($db,$checkCount);
        $row = mysqli_fetch_assoc($checkCountResult);
        $Num = $row['Num'];
        mysqli_free_result($checkCountResult);
        mysqli_close($db);
        if($Num == 0){
            return false;
        }
        else {
            return true;
        }
    }

    public static function getAll(){
        $db = connectDB();
        $checkQuery = "SELECT * FROM `Product_list` ORDER BY `product_id`";
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
