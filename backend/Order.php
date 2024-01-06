<?php
ini_set('display_errors','1');
error_reporting(E_ALL);
require_once "db.php";

class Order {
    private $order_id;
    private $product_list = [];
    private $coupon_list = [];
    private $status;
    private $order_date;
    private $arrival_date;
    private $address;

    public function __construct(ShoppingCart $cart) {
        $this->product_list = $cart->getProductList();
        $this->status = 'Pending'; // 訂單狀態預設為待處理
        $this->order_date = date('Y-m-d');  // 日期預設為今天
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
        $address = $row['price'];
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

    public function submitOrder($address) {
        $this->status = 'Submitted';
        $this->address = $address;
        $this->arrival_date = date('Y-m-d', strtotime('+7 days'));
        echo "Order submitted successfully.\n";
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
}

?>
