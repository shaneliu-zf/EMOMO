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
    private $repeatedCode;

    function __construct(){}

    public function createNewCoupon($name,$code,$rule,$discount,$date){
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
                $this->repeatedCode = false;
                // 不存在相同的 user_id，執行插入操作

                $insertQuery = "INSERT INTO `Coupon_list` (`id`, `name`, `giftcode`, `date` , `rule` , `discount`)
                 VALUES ($id, '$name', '$code', '$date' , '$rule', '$discount')";

                 
                $insertResult = mysqli_query($db, $insertQuery);
            }
            else{
                $this->repeatedCode = true;
            }
            // 釋放資源
            mysqli_free_result($checkResult);
            mysqli_free_result($checkCountResult);
        }
        // 關閉資料庫連接
        mysqli_close($db);
    }

    public function getCouponId(){
        $db = connectDB();
        $sql = "SELECT `id` FROM `Coupon_list`";
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
}