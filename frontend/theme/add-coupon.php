<?php
ini_set('display_errors','1');
error_reporting(E_ALL);
require_once "header.php";
require_once "../../backend/Coupon.php";

if(!isset($_COOKIE['user_id']) || !(User::isStaff($_COOKIE['user_id']) || User::isAdmin($_COOKIE['user_id']))){
    echo '<meta http-equiv="refresh" content="0;url=login.php">';
    die();
}

if ($_SERVER['REQUEST_METHOD'] == "POST"){
  $name = $_POST['couponName'];
  $code = $_POST['couponCode'];
  $discountmode = $_POST['discountType'];
  $discount = $_POST['discountAmount'];
  $date = $_POST['expiryDate'];
  $rule = $_POST['minimumAmount'];
  $rule_mode = $_POST['rule'];
  $NewCoupon = new Coupon();
  $result = $NewCoupon->createNewCoupon($name,$code,$discountmode,$discount,$date,$rule,$rule_mode);
  if($result){
    echo "<script>alert('重複的優惠碼');</script>";
  }
  else{
    echo "<script>alert('新增成功');</script>";
  }
}
?>


<!DOCTYPE html>

  <!-- 在<head>標籤中添加以下CSS -->
    <style>
        /* 新增優惠卷表單樣式 */
        .add-coupon {
            padding: 60px 0;
            background-color: #f9f9f9;
        }

        .add-coupon form {
            background-color: #fff;
            padding: 60px;
            border-radius: 5px;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
        }

        .add-coupon label {
            display: block;
            margin-bottom: 8px;
            font-size: 16px;
            color: #333;
        }

        .add-coupon input,
        .add-coupon textarea,
        .add-coupon select {
            height: 50px;
			width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ddd;
            border-radius: 3px;
            font-size: 14px;
        }

        /* 固定描述框的高度並禁止縮放 */
        .add-coupon textarea {
            height: 150px; /* 調整高度 */
            resize: none; /* 禁止縮放 */
        }

        .add-coupon button {
        background-color: #28a745;
        color: #fff;
        padding: 10px 20px;
        border: none;
        border-radius: 3px;
        cursor: pointer;
        font-size: 16px;
        float: right; /* 將按鈕浮動到右邊 */
    	}

        .add-coupon button:hover {
            background-color: #218838;
        }

		#error-msg {
            color: red;
            display: none;
        }

		select#rule {
            height: 50px; /* Set the desired height */
            /* Additional styling for better visibility */
            padding: 8px;
            font-size: 16px;
        }

		select#discountType {
            height: 50px; /* Set the desired height */
            /* Additional styling for better visibility */
            padding: 8px;
            font-size: 16px;
        }
    </style>

</head>

<body id="body">

	<section class="add-coupon">
		<div class="container">
			<div class="row">
				<div class="col-md-10 col-md-offset-1">
                <div class="form-wrapper">
                <h2 class="section-title">新增優惠卷</h2>
					<form id="couponForm" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
						<label for="couponName">優惠卷名字:</label>
						<input type="text" id="couponName" name="couponName" required>

						<label for="couponCode">優惠碼:</label>
						<input type="text" id="couponCode" name="couponCode" required>

						<label for="discountType">折扣方式:</label>
						<select id="discountType" name="discountType" required>
							<option value="">選擇折扣方式</option>
							<option value="minus">金額</option>
							<option value="percent">百分比數</option>
						</select>

						<label for="discountAmount">金額或%數:</label>
						<input type="text" id="discountAmount" name="discountAmount" placeholder="請輸入金額或%數" required>

						<label for="rule">使用規則</label>
						<select id="rule" name="rule" required>
							<option value="">選擇使用規則</option>
							<option value="sum">滿額折扣</option>
							<option value="amount">數量達標</option>
						</select>

						<label for="minimumAmount">需達金額</label>
						<input type="text" id="minimumAmount" name="minimumAmount" pattern="[0-9]+" title="請輸入整數" placeholder="請輸入需達金額" required>
						<div id="error-msg">請輸入整數</div>

						<script>
							document.getElementById('minimumAmount').addEventListener('input', function() {
								var isValid = this.checkValidity();

								if (!isValid) {
									document.getElementById('error-msg').style.display = 'block';
								} else {
									document.getElementById('error-msg').style.display = 'none';
								}
							});
						</script>

						<label for="expiryDate">截止日期:</label>
						<input type="date" id="expiryDate" name="expiryDate" required>

						<button type="submit">新增優惠卷</button>
					</form>
				</div>
                </div>
			</div>
		</div>
	</section>

  </body>
  </html>


  <?php include "footer.php";?>
