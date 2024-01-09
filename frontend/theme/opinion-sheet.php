<?php
ini_set('display_errors','1');
error_reporting(E_ALL);
require_once "header.php";
require_once "../../backend/Feedback.php";

if ($_SERVER['REQUEST_METHOD'] == "POST"){
  $name = $_POST['name'];
  $email = $_POST['email'];
  $suggestion = $_POST['message'];
  $submitTime = $_POST['submit_time'];

  Feedback::SaveFeedbacks($name,$email,$suggestion,$submitTime);
  echo "<script>alert('提交成功，感謝您的建議');</script>";
}
?>

<!DOCTYPE html>

<section class="page-header">
	<div class="container">
		<div class="row">
			<div class="col-md-12">
				<div class="content">
					<h1 class="page-name">聯繫客服</h1>
					<ol class="breadcrumb">
						<li><a href="index.php">首頁</a></li>
						<li class="active">會員中心</li>
                        <li>聯繫客服</li>
					</ol>
				</div>
			</div>
		</div>
	</div>
</section>




<section class="client-feedback">
    <div class="container">
        <div class="row">
            <div class="col-md-6 col-md-offset-3">
                <div class="section-title text-center">
                    <h2><strong>回饋建議</strong></h2>
                    <p>有問題或建議？請告訴我們！</p>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6 col-md-offset-3">
                <!-- 客服表單 -->
                <form  method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
                    <div class="form-group">
                        <label for="name" style="font-size: 18px;">姓名：</label>
                        <input type="text" class="form-control" id="name" name="name" required>
                    </div>
                    <div class="form-group">
                        <label for="email" style="font-size: 18px;">電子郵件：</label>
                        <input type="email" class="form-control" id="email" name="email" required>
                    </div>
                    <div class="form-group">
                        <label for="message" style="font-size: 18px;">問題或建議：</label>
                        <textarea class="form-control" id="message" name="message" rows="4" required></textarea>
                    </div>
                    <input type="hidden" name="submit_time" id="submitTimeField">

                    <button type="submit" class="btn btn-primary float-right" onclick="setSubmitTime()">提交</button>
                </form>

                <!-- 電話資訊 -->
                <div class="contact-info" style="margin-top: 20px;">
                    <p style="font-size: 18px;">聯絡電話：0129-12323-123123</p>
                    <p style="font-size: 18px;">辦公時間：週一至週五 9:00 AM - 5:00 PM</p>
                </div>
            </div>
        </div>

    </div>
</section>

<script>
    // 在提交表单前设置提交时间
    function setSubmitTime() {
        // 获取当前时间
        var currentTime = new Date().toLocaleString();

        // 将时间添加到隐藏字段中
        document.getElementById('submitTimeField').value = currentTime;
    }
</script>


  </body>
  </html>

  <?php include_once "footer.php"; ?>