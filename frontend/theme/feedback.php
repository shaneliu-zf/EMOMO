<?php
require_once "header.php";
require_once "../../backend/User.php";

if(!isset($_COOKIE['user_id']) || !(User::isStaff($_COOKIE['user_id']) || User::isAdmin($_COOKIE['user_id']))){
    echo '<meta http-equiv="refresh" content="0;url=login.php">';
    die();
}
?>

<!DOCTYPE html>



<section class="page-header">
	<div class="container">
		<div class="row">
			<div class="col-md-12">
				<div class="content">
					<h1 class="page-name">用戶回饋</h1>
					<ol class="breadcrumb">
						<li><a href="index.php">首頁</a></li>
						<li class="active">員工專區</li>
                        <li>用戶回饋</li>
					</ol>
				</div>
			</div>
		</div>
	</div>
</section>




<section class="client-feedback">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <!-- 表格 -->
                <div class="dashboard-wrapper user-dashboard">
                    <div class="table-responsive">
                        <table class="table feedback-table">
                            <thead>
                                <tr>
                                    <th>名字</th>
                                    <th>Email</th>
                                    <th>時間</th>
                                    <th>描述</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                include_once "../../backend/Feedback.php";
                                $result = Feedback::getFeedbacks();
                                while($row = $result->fetch_assoc()){
                                    $name = $row['name'];
                                    $email = $row['email'];
                                    $date = $row['date'];
                                    $suggestion = $row['suggestion'];
                                    echo "<tr class='feedback-item'>
                                    <td>$name</td>
                                    <td>$email</td>
                                    <td>$date</td>
                                    <td>$suggestion</td>
                                    </tr>";

                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>





  </body>
  </html>
  <?php include_once "footer.php"; ?>
