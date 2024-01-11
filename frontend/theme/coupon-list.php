<?php
ob_start();
ini_set('display_errors','1');
error_reporting(E_ALL);
require_once "header.php";
require_once "../../backend/Coupon.php";

if(!isset($_COOKIE['user_id'])){
    echo '<meta http-equiv="refresh" content="0;url=login.php">';
    die();
}

if ($_SERVER['REQUEST_METHOD'] == "POST"){
  $code = $_POST['code'];
  setcookie("coupon", $code, 0, "/");
  echo "<script>window.location.href = '/cart.php';</script>";
  ob_end_flush();
}
?>
<style>
    .coupon-section {
        margin-top: 50px;
    }

    .coupon-item {
        background-color: #f2f2f2; /* 淺灰色背景 */
        border: 2px solid #d1d1d1; /* 灰色邊框 */
        padding: 20px;
        margin-bottom: 20px;
        position: relative;
        border-radius: 15px; /* 圓角 */
        color: #333; /* 深灰色文字 */
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1); /* 淺陰影效果 */
    }

    .coupon-item h3 {
        color: #333;
        margin-bottom: 10px;
    }

    .coupon-code {
        display: block;
        margin-top: 10px;
        font-weight: bold;
        font-size: 20px;
        color: #e44d26; /* 標準橙色，可以根據需要更改 */
    }

    .coupon-date {
        position: absolute;
        bottom: 10px;
        right: 10px;
        color: #777;
    }
    .search-box {
    margin: 20px 0;
    display: flex;
    align-items: center;
    }

    #couponSearch {
        width: 180px; /* 調整搜尋框寬度 */
        padding: 10px;
        border: 2px solid #ccc; /* 淺灰色系邊框 */
        border-radius: 5px 5px 5px 5px;
        margin-right: 10px; /* 增加搜尋框右側間隔 */
        outline: none;
    }

    #couponSearch:focus {
        border-color: #999; /* 深灰色系邊框 */
    }

    .search-btn {
        background-color: #ccc; /* 淺灰色系背景 */
        color: #333; /* 深灰色系文字 */
        border: 2px solid #ccc; /* 淺灰色系邊框 */
        border-radius: 5px 5px 5px 5px;
        padding: 10px 15px;
        cursor: pointer;
    }

    .search-btn:hover {
        background-color: #999; /* 深灰色系濃化背景 */
        border-color: #999; /* 深灰色系濃化邊框 */
    }
    .search-box {
    display: flex;
    align-items: center;
    }

    #couponSearch {
        border-radius: 5px 0 0 5px; /* 左側圓角 */
        border: 1px solid #ccc;
        padding: 10px;
        width: 200px;
    }

    .search-btn {
        background-color: #ccc;
        color: #333;
        border: 1px solid #ccc;
        border-radius: 5px 5px 5px 5px; /* 右側圓角 */
        padding: 10px 15px;
        cursor: pointer;
    }

    .add-btn {
        background-color: #ccc;
        color: #333;
        border: 1px solid #ccc;
        border-radius: 5px; /* 圓角 */
        padding: 10px 15px;
        cursor: pointer;
        margin-left: auto; /* 將新增優惠卷按鈕推到最右邊 */
    }

    .add-btn:hover,
    .search-btn:hover {
        background-color: #999; /* 滑鼠懸停時的背景色 */
        border-color: #999; /* 滑鼠懸停時的邊框色 */
    }
</style>

<section class="page-header">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="content">
                    <h1 class="page-name">優惠卷</h1>
                    <ol class="breadcrumb">
                        <li><a href="index.php">首頁</a></li>
                        <li class="active">優惠卷</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
</section>

<div class="container">
    <div class="search-box">
        <!-- <input type="text" id="couponSearch" placeholder="Search by coupon name...">
        <button class="search-btn" onclick="searchCoupons()">Search</button> -->
        <?php
        if (isset($_COOKIE['user_id'])){
            if(User::isAdmin($_COOKIE['user_id']) || User::isStaff($_COOKIE['user_id'])){
                echo '<button class="add-btn" onclick="redirectToAddCoupon()">新增優惠卷</button>';
            }
        }
        ?>
    </div>
</div>
<section class="coupon-section">
<?php
ini_set('display_errors','1');
error_reporting(E_ALL);
include_once "../../backend/Coupon.php";
$Newcoupon = New Coupon();
$result = $Newcoupon->getCouponId();
if ($result->num_rows > 0) {
    $today = date("Y-m-d");
    // 逐列輸出資料
    while($row = $result->fetch_assoc()) {
        $id = $row["id"];
        $name = $Newcoupon->getCouponName($id);
        $code = $Newcoupon->getCouponCode($id);
        $date = $Newcoupon->getCouponDate($id);
        $rule = $Newcoupon->getCouponRule($id);
        $rule_mode = $Newcoupon->getCouponRuleMode($id);
        $discount = $Newcoupon->getCouponDiscount($id);
        $discount_mode = $Newcoupon->getCouponDiscountMode($id);
        if($rule_mode == "sum"){
            $text1 = "滿 $rule 元";
        }
        else{
            $text1 = "達 $rule 件";
        }
        if($discount_mode == "minus"){
            $text2 = " $discount 元";
        }
        else{
            $text2 = " $discount% ";
        }
        echo "<div class='container'>
                <div class='coupon-item'>
                    <h3>$name</h3>
                    <p>購物$text1";
        echo "可享額外$text2";
        echo "折扣。</p><span class='coupon-code'>$code</span><br/><span class='coupon-date'>截止日期：$date</span>";
        if($today <= $date){
            echo "<form action='" . htmlspecialchars($_SERVER["PHP_SELF"]) . "' method='post'>
        <input type='hidden' id='code' name='code' value='$code'>
        <button type='submit' class='btn btn-primary'>使用</button>
      </form>";

            //echo "<a class='btn btn-primary' id='usable-link' style='display: inline;'>使用</a>";
        }
        else{
            echo "<a class='expired-link' id='expired-link' style='color: red;'>無法使用，已逾期</a>";
        }
        echo "</div></div>";
    }
}

?>
</section>

<script>
    function redirectToAddCoupon() {
        window.location.href = 'add-coupon.php';
    }
</script>

</body>
</html>

<?php include "footer.php";?>
