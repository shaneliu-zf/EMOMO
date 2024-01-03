<?php
ini_set('display_errors','1');
error_reporting(E_ALL);
require_once "db.php";
require_once "Product.php";
class ShoppingCart {

    private $shopping_cart_id;
    private $product_list = [];

    public function __construct() {
        
    }

    public function addItem($number,$product_id,$user_id){
        $flag = false;
        $db = connectDB();
        $insertQuery = "INSERT INTO `ShoppingCart` (`user_id`, `product_id`) VALUES ($user_id, $product_id)";
        for ($i = 1; $i < $number; $i++) {
            // 在循环中构建多个 VALUES 子句
            $insertQuery .= "($user_id, $product_id)";
        
            // 添加逗号和空格以分隔多个 VALUES 子句
            if ($i < $number - 1) {
                $insertQuery .= ", ";
            }
        }
        $result = mysqli_query($db, $insertQuery);
        if($result !== false){
            $flag = true;
        }
        mysqli_close($db);
        return $flag;
    }

    public function removeItem($user_id, $product_id) {
        $db = connectDB();

        // Assuming your table has a primary key named 'id'
        $deleteQuery = "DELETE FROM `ShoppingCart` WHERE `user_id` = $user_id AND `product_id` = $product_id";

        $result = mysqli_query($db, $deleteQuery);

        mysqli_close($db);

        return $result;
    }

    public function checkIfInCart($user_id,$product_id){
        $db = connectDB();
        $checkQuery = "SELECT COUNT(*) as count FROM `ShoppingCart` WHERE `user_id` = $user_id AND `product_id` = $product_id";
        $checkResult = mysqli_query($db, $checkQuery);
        $row = mysqli_fetch_assoc($checkResult);
        $count = $row['count'];
        if($count > 0){
            mysqli_free_result($checkResult);
            return $count;
        }
        else{
            mysqli_free_result($checkResult);
            return $count;
        }
        mysqli_close($db);
    }

    public function getNumInProduct(){
        $db = connectDB();
        $checkCount = "SELECT COUNT(*) AS TotalItems FROM `Product_list`";
        $checkCountResult = mysqli_query($db,$checkCount);
        $row = mysqli_fetch_assoc($checkCountResult);
        $count = $row['TotalItems'];
        mysqli_free_result($checkCountResult);
        mysqli_close($db);
        return $count;
    }

    public function getProductPrice($product_id){
        $NewProduct = New Product();
        $price = $NewProduct->getPricebyID($product_id);
        return $price;
    }

    public function getProductName($product_id){
        $NewProduct = New Product();
        $name = $NewProduct->getNamebyID($product_id);
        return $name;
    }

    public function getProductImage($product_id){
        $NewProduct = New Product();
        $image = $NewProduct->getImagebyID($product_id);
        return $image;
    }

    public function submit() {
    }

    public function getProductList() {
        return $this->product_list;
    }
}

?>
