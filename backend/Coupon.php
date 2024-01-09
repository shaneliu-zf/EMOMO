<?php
ini_set('display_errors','1');
error_reporting(E_ALL);


require_once "db.php";

class Coupon{
    private $coupon_id;
    private $name;
    private $gift_code;
    private $date;
    private $rule_mode; // sum 、 amount
    private $rule; // 100 、 5
    private $discount_mode;  // minus 、 percent
    private $discount;

    function __construct(){}

    public function createNewCoupon($name,$code,$discountmode,$discount,$date,$rule,$rule_mode){
        $repeat = false;
        $db = connectDB();
        $checkQuery = "SELECT COUNT(*) as count FROM `Coupon_list` WHERE `giftcode` = '$code'";
        $checkCount = "SELECT COUNT(*) AS TotalItems FROM `Coupon_list`";
        $checkCountResult = mysqli_query($db,$checkCount);
        $row = mysqli_fetch_assoc($checkCountResult);
        $id = $row['TotalItems'];
        $checkResult = mysqli_query($db, $checkQuery);
        if ($checkResult) {
            $row = mysqli_fetch_assoc($checkResult);
            $count = $row['count'];
            if ($count == 0) {
                $repeat = false;
                // 不存在相同的 user_id，執行插入操作

                $insertQuery = "INSERT INTO `Coupon_list` (`id`, `name`, `giftcode`, `date` , `rule_mode` , `rule` , `discount_mode`, `discount`)
                 VALUES ($id, '$name', '$code', '$date' , '$rule_mode' ,'$rule', '$discountmode','$discount')";

                 
                $insertResult = mysqli_query($db, $insertQuery);
            }
            else{
                $repeat = true;
            }
            // 釋放資源
            mysqli_free_result($checkResult);
            mysqli_free_result($checkCountResult);
        }
        // 關閉資料庫連接
        mysqli_close($db);
        return $repeat;
    }

    public function getCouponId(){
        $db = connectDB();
        $sql = "SELECT `id` FROM `Coupon_list` ORDER BY `date` DESC";
        $result = mysqli_query($db,$sql);
        mysqli_close($db);
        return $result;
    }

    public function getCouponName($id){
        $db = connectDB();
        $sql = "SELECT * FROM `Coupon_list` WHERE `id` = $id";
        $result = mysqli_query($db,$sql);
        $row = mysqli_fetch_assoc($result);
        $name = $row['name'];
        mysqli_free_result($result);
        mysqli_close($db);
        return $name;
    }

    public function getCouponCode($id){
        $db = connectDB();
        $sql = "SELECT * FROM `Coupon_list` WHERE `id` = $id";
        $result = mysqli_query($db,$sql);
        $row = mysqli_fetch_assoc($result);
        $giftcode = $row['giftcode'];
        mysqli_free_result($result);
        mysqli_close($db);
        return $giftcode;
    }

    public function getCouponDate($id){
        $db = connectDB();
        $sql = "SELECT * FROM `Coupon_list` WHERE `id` = $id";
        $result = mysqli_query($db,$sql);
        $row = mysqli_fetch_assoc($result);
        $date = $row['date'];
        mysqli_free_result($result);
        mysqli_close($db);
        return $date;
    }

    public function getCouponRule($id){
        $db = connectDB();
        $sql = "SELECT * FROM `Coupon_list` WHERE `id` = $id";
        $result = mysqli_query($db,$sql);
        $row = mysqli_fetch_assoc($result);
        $rule = $row['rule'];
        mysqli_free_result($result);
        mysqli_close($db);
        return $rule;
    }

    public function getCouponRuleMode($id){
        $db = connectDB();
        $sql = "SELECT * FROM `Coupon_list` WHERE `id` = $id";
        $result = mysqli_query($db,$sql);
        $row = mysqli_fetch_assoc($result);
        $rule_mode = $row['rule_mode'];
        mysqli_free_result($result);
        mysqli_close($db);
        return $rule_mode;
    }

    public function getCouponDiscount($id){
        $db = connectDB();
        $sql = "SELECT * FROM `Coupon_list` WHERE `id` = $id";
        $result = mysqli_query($db,$sql);
        $row = mysqli_fetch_assoc($result);
        $discount = $row['discount'];
        mysqli_free_result($result);
        mysqli_close($db);
        return $discount;
    }

    public function getCouponDiscountMode($id){
        $db = connectDB();
        $sql = "SELECT * FROM `Coupon_list` WHERE `id` = $id";
        $result = mysqli_query($db,$sql);
        $row = mysqli_fetch_assoc($result);
        $discount_mode = $row['discount_mode'];
        mysqli_free_result($result);
        mysqli_close($db);
        return $discount_mode;
    }

    public static function discount($price, $gift_code){
        $db = connectDB();
        $sql = "SELECT * FROM `Coupon_list` WHERE `giftcode` = '$gift_code'";
        $result = mysqli_query($db,$sql);
        $row = mysqli_fetch_assoc($result);
        if ($row['discount_mode'] == "minus"){
            $price -= $row['discount'];
        }
        else{
            $price *= $row['discount'];
            $price /= 100;
        }
        return intval($price);
    }

    public static function checkIfCanUse($name,$total_price,$user_id){
        $db = connectDB();
        $sql = "SELECT * FROM `Coupon_list` WHERE `giftcode` = '$name'";
        $sql2 = "SELECT COUNT(*) AS TotalItems FROM `ShoppingCart` WHERE `user_id` = '$user_id'";
        $result2 = mysqli_query($db,$sql2);
        $row2 = mysqli_fetch_assoc($result2);
        $num = $row2['TotalItems'];
        $result = mysqli_query($db,$sql);
        while ($row = mysqli_fetch_assoc($result)){
            if($row['rule_mode'] == "sum"){
                if($total_price >= $row['rule']){
                    if ($row['discount_mode'] == "minus"){
                        $total_price -= $row['discount'];
                    }
                    else{
                        $total_price *= $row['discount'];
                        $total_price /= 100;
                    }
                }
            }
            else{
                if($num >= $row['rule']){
                    if ($row['discount_mode'] == "minus"){
                        $total_price -= $row['discount'];
                    }
                    else{
                        $total_price *= $row['discount'];
                        $total_price /= 100;
                    }
                }
            }
        }
        return intval($total_price);
    }


}