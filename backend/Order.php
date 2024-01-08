<?php
ini_set('display_errors','1');
error_reporting(E_ALL);
require_once "db.php";
include_once "Product.php";

class Order {
    private $order_id;
    private $product_list = [];
    private $coupon_list = [];
    private $status;
    private $order_date;
    private $arrival_date;
    private $address;

    public function __construct($address, $user_id, $gift_code) {
        $db = connectDB();
        $countQuery = "SELECT COUNT(*) AS count FROM `Order_list`";
        $countResult = mysqli_query($db, $countQuery);
        $row = mysqli_fetch_assoc($countResult);
        $count = $row['count'];
        $today = date("Y-m-d");
        $sevenDaysLater = date("Y-m-d", strtotime($today . "+7 days"));
        $insertQuery = "INSERT INTO `Order_list` (`user_id`, `status`, `order_date`, `arrival_date`, `address`, `user_id`, `gift_code`) 
                        VALUES ($count, 'Pending', $today, $sevenDaysLater, $address, $user_id, $gift_code)";
        mysqli_query($db, $insertQuery);
        mysqli_close($db);
    }

    public function checkOut($order_id, $user_id, $product_id) {
        $flag = false;
        $db = connectDB();
        $countQuery = "SELECT COUNT(*) AS count FROM `Ordered_product_list`";
        $countResult = mysqli_query($db, $countQuery);
        $row = mysqli_fetch_assoc($countResult);
        $count = $row['count'];
        $insertQuery = "INSERT INTO `Ordered_product_list` (`id`, `order_id`, `user_id`, `product_id`, `amount`) 
                        VALUES ($count, $order_id, $user_id, $product_id, 1)";
        $insertResult = mysqli_query($db, $insertQuery);
        if($insertResult !== false){
            $flag = true;
        }
        mysqli_close($db);
        return $flag;
    }

    public  function updateAmount($order_id, $user_id, $product_id) {
        $db = connectDB();
        $sql = "UPDATE `Ordered_product_list` SET `amount` = `amount` + 1 WHERE `order_id` = '$order_id' AND `user_id` = '$user_id' AND `product_id` = '$product_id'";
        $result = mysqli_query($db,$sql);
        mysqli_close($db);
    }

    public  function isExist($order_id, $user_id, $product_id) {
        $db = connectDB();
        $sql = "SELECT * FROM `Ordered_product_list` WHERE `order_id` = '$order_id' AND `user_id` = '$user_id' AND `product_id` = '$product_id'";
        $result = mysqli_query($db,$sql);
        mysqli_close($db);
        return $result;
    }

    public static function getCount(){
        $db = connectDB();
        $sql = "SELECT COUNT(*) AS count FROM `Order_list`";
        $result = mysqli_query($db,$sql);
        $row = mysqli_fetch_assoc($result);
        $count = $row['count'];
        mysqli_free_result($result);
        mysqli_close($db);
        return $count;
    }

    public static function getStatusbyID($id){
        $db = connectDB();
        $sql = "SELECT * FROM `Order_list` WHERE `id` = $id";
        $result = mysqli_query($db,$sql);
        $row = mysqli_fetch_assoc($result);
        $status = $row['status'];
        mysqli_free_result($result);
        mysqli_close($db);
        return $status;
    }
    
    public static function getOrderDatebyID($id){
        $db = connectDB();
        $sql = "SELECT * FROM `Order_list` WHERE `id` = $id";
        $result = mysqli_query($db,$sql);
        $row = mysqli_fetch_assoc($result);
        $order_date = $row['order_date'];
        mysqli_free_result($result);
        mysqli_close($db);
        return $order_date;
    }

    public static function getArrivalDatebyID($id){
        $db = connectDB();
        $sql = "SELECT * FROM `Order_list` WHERE `id` = $id";
        $result = mysqli_query($db,$sql);
        $row = mysqli_fetch_assoc($result);
        $arrival_date = $row['arrival_date'];
        mysqli_free_result($result);
        mysqli_close($db);
        return $arrival_date;
    }

    public static function getAddressbyID($id){
        $db = connectDB();
        $sql = "SELECT * FROM `Order_list` WHERE `id` = $id";
        $result = mysqli_query($db,$sql);
        $row = mysqli_fetch_assoc($result);
        $address = $row['address'];
        mysqli_free_result($result);
        mysqli_close($db);
        return $address;
    }

    public static function getPricebyID($id){
        $db = connectDB();
        $sql = "SELECT * FROM `Order_list` WHERE `id` = $id";
        $result = mysqli_query($db,$sql);
        $row = mysqli_fetch_assoc($result);
        $price = $row['price'];
        mysqli_free_result($result);
        mysqli_close($db);
        return $price;
    }

    public static function addCoupon(Coupon $coupon, $sum) {
        if ((($coupon->getRule_mode() == 'sum') && ($sum >= $coupon->getRule())) || (($coupon->getRule_mode() == 'amount') && (count($this->product_list) >= $coupon->getRule()))){
            if($coupon->getDiscount_mode() == 'minus'){
                return ($sum - $coupon->getDiscount());
            }
            elseif($coupon->getDiscount_mode() == 'percent'){
                return ($sum * $coupon->getDiscount());
            }
            else{
                die("Discount Error!");
            }
        }
        else{
            die("不符合資格");
        }
    }

    public static function changeStatus($id, $status) {
        $db = connectDB();
        $sql = "UPDATE `Order_list` SET `status` = '$status' WHERE `id` = '$id'";
        $result = mysqli_query($db,$sql);
        mysqli_close($db);
    }

    public static function updateArrivalDate($id) {
        $db = connectDB();
        $today = date("Y-m-d");
        $sql = "UPDATE `Order_list` SET `arrival_date` = '$today' WHERE `id` = '$id'";
        $result = mysqli_query($db,$sql);
        mysqli_close($db);
    }

    public static function getOrderDetails($user_id) {
        $db = connectDB();
        $checkQuery = "SELECT * FROM `Order_list` WHERE user_id = $user_id";
        if ($checkResult = mysqli_query($db, $checkQuery)) {
            mysqli_close($db);
            return $checkResult;
        }
        else {
            echo "無任何商品";
            mysqli_close($db);
        }
    }

    public static function getOrderitems($order_id,$user_id) {
        $db = connectDB();
        $checkQuery = "SELECT * FROM `Ordered_product_list` WHERE `user_id` = '$user_id' AND `order_id` = '$order_id'";
        if ($checkResult = mysqli_query($db, $checkQuery)) {
            mysqli_close($db);
            return $checkResult;
        }
        else {
            echo "無任何商品";
            mysqli_close($db);
        }
    }

    public static function getOrderSingleItemsCount($order_id,$user_id,$product_id) {
        $db = connectDB();
        $checkQuery = "SELECT * FROM `Ordered_product_list` WHERE `user_id` = '$user_id' AND `order_id` = '$order_id' AND `product_id` = '$product_id'";
        $checkResult = mysqli_query($db, $checkQuery);
        $row = mysqli_fetch_assoc($checkResult);
        $amount = $row['amount'];
        mysqli_free_result($checkResult);
        mysqli_close($db);
        return $amount;
    }

    public static function getPriceOfOrder($order_id){
        $db = connectDB();
        $check2 = "SELECT `product_id` FROM `Ordered_product_list` WHERE `order_id` = '$order_id'";
        $checkResult2 = mysqli_query($db, $check2);
        $total_price = 0;
    
        while ($row = mysqli_fetch_assoc($checkResult2)){
            $total_price += Product::getPricebyID($row['product_id']);
        }
    
        mysqli_free_result($checkResult2);
        mysqli_close($db);
        return $total_price;
    }
    
    public static function getPriceArrayOfChart(){
        $db = connectDB();
        $check = "SELECT DISTINCT `order_id` FROM `Ordered_product_list`";
        $checkResult = mysqli_query($db, $check);
        $products = array(); // 初始化数组
    
        while ($row = mysqli_fetch_assoc($checkResult)) {
            $order_id = $row['order_id'];
            $product = array(
                'date' => self::getOrderDatebyID($order_id),
                'price' => self::getPriceOfOrder($order_id),
                // 添加其他字段...
            );
            $products[] = $product;
        }
    
        usort($products, array('self', 'compareDates'));
        mysqli_free_result($checkResult);
        mysqli_close($db);
        return $products;
    }
    

    public static function getProductSalesArrayOfChart(){
        $db = connectDB();
        for ($i = 0; $i < Product::getAmount();$i++){
            $checkCount = "SELECT COUNT(*) AS TotalItems FROM `Ordered_product_list` WHERE `product_id` = '$i'";
            $result = mysqli_query($db,$checkCount);
            $row = mysqli_fetch_assoc($result);
            $count = $row['TotalItems'];
            $product = array(
                'id' => $i,
                'num' => $count,
                // 添加其他字段...
            );
            $products[] = $product;
            mysqli_free_result($result);
        }
        mysqli_close($db);
        return $products;
    }

    public static function compareDates($a, $b) {
        return strtotime($a['date']) - strtotime($b['date']);
    }
}

?>
