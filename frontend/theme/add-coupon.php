<?php
ini_set('display_errors','1');
error_reporting(E_ALL);
require_once "header.php";
require_once "../../backend/Coupon.php";

if ($_SERVER['REQUEST_METHOD'] == "POST"){
  $name = $_POST['couponName'];
  $code = $_POST['couponCode'];
  $discount = $_POST['discountType'];
  $date = $_POST['date'];
  $rule = $_POST['rule'];
  $NewCoupon = new Coupon();
  $NewCoupon->createNewCoupon($name,$code,$rule,$discount,$date);
  $result = $NewCoupon->getIsRepeatedCode();
  if($result){
    echo "<script>alert('重複的優惠碼');</script>";
  }
  else{
    echo "<script>alert('新增成功');</script>";
  }
}
?>

<section class="add-coupon">
    <div class="container">
        <div class="row">
            <div class="col-md-6 col-md-offset-3">
                <div class="form-wrapper">
                    <h2 class="section-title">新增優惠卷</h2>
                    <form id="couponForm" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
					<div class="form-group">
                    <label for="couponName">優惠卷名字:</label>
                    <input type="text" id="couponName" name="couponName" required>
					</div>
					
					<div class="form-group">
                    <label for="couponCode">優惠碼:</label>
                    <input type="text" id="couponCode" name="couponCode" required>
					</div>
					
					<div class="form-group">
                    <label for="discountType">折扣:</label>
                    <input type="text" id="discountType" name="discountType" required>
					</div>
					
					<div class="form-group">
					<label for="rule">使用限制:</label>
                    <input type="text" id="rule" name="rule" required>
					</div>

					<div class="form-group">
                    <label for="date">截止日期:</label>
                    <input type="date" id="date" name="date" required>
					</div>
					
					<div class="form-group text-right">
                    <button type="submit">新增優惠卷</button>
					</div>
					</form>
                </div>
            </div>
        </div>
    </div>
</section>


  </body>
  </html>

<?php include "footer.php";?>






