<?php
include_once "header.php";
?>


<section class="page-header">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="content">
                    <h1 class="page-name">優惠卷</h1>
                    <ol class="breadcrumb">
                        <li><a href="index.html">首頁</a></li>
                        <li class="active">所有優惠卷</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
</section>

<div class="container">
    <div class="search-box">
        <input type="text" id="couponSearch" placeholder="Search by coupon name...">
        <button class="search-btn" onclick="searchCoupons()">Search</button>
        <button class="add-btn" onclick="redirectToAddCoupon()">新增優惠卷</button>
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
    // 逐列輸出資料
    while($row = $result->fetch_assoc()) {
        $id = $row["id"];
        $name = $Newcoupon->getCouponName($id);
        $code = $Newcoupon->getCouponCode($id);
        $date = $Newcoupon->getCouponDate($id);
        $rule = $Newcoupon->getCouponRule($id);
        $discount = $Newcoupon->getCouponDiscount($id);
        echo "<div class='container'>";
        echo "<div class='coupon-item'>";
        echo "<h3>$name</h3>";
        echo "<p>$rule</p>";
        echo "<span class='coupon-code'>$discount</span>";
        echo "</br>";
        echo "<span class='coupon-date'>截止日期：$date</span>";
        echo "</div>";
        echo "</div>";
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