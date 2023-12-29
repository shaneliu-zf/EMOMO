<?php
include_once "header.php";
ini_set('display_errors', '1');
error_reporting(E_ALL);
include_once "../../backend/Admin.php";

$NewAdmin = new Admin();

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $user_id = $_POST['user_id'];
	$NewAdmin->deleteStaff($user_id);
	echo "<script>alert('移除成功');</script>";
}
?>


<body id="body">



<section class="page-header">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="content">
                    <h1 class="page-name">員工列表</h1>
                    <ol class="breadcrumb">
                        <li><a href="index.html">Home</a></li>
                        <li class="active">my account</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="user-dashboard page-wrapper">
	<div class="container">
        <div class="row">
            <div class="col-md-6"> <!-- 調整為 col-md-6，使搜尋框顯示在左邊 -->
                <div class="mt-3">
                    <div class="custom-input-group">
						<input type="text" class="form-control" placeholder="搜尋員工" id="searchEmployee">
						<button class="btn btn-outline-primary" type="button" onclick="searchEmployee()">搜尋</button>
					</div>
                </div>
            </div>
            <div class="col-md-6 text-right mt-3"> <!-- 新增一半的欄位給搜尋框，使新增員工按鈕顯示在右邊 -->
                <button class="btn btn-primary" onclick="addNewEmployee()">新增員工</button>
            </div>
        </div>
    </div>

	<?php 
	ini_set('display_errors','1');
	error_reporting(E_ALL);
	include_once "../../backend/Admin.php";
	$Newadmin = New Admin();
	$result = $Newadmin->getStaffId();
	if ($result->num_rows > 0) {
		// 逐列輸出資料
		while($row = $result->fetch_assoc()) {
			$id = $row["user_id"];
			$name = $Newadmin->getStaffName($id);
			$address = $Newadmin->getStaffAddress($id);
			$email = $Newadmin->getStaffemail($id);
			echo "<form method='post' action='" . htmlspecialchars($_SERVER["PHP_SELF"]) . "'>";
			echo "<div class='container'>";
			echo "<div class='row'>";
			echo "<div class='col-md-12'>	";	  
			echo "<div class='dashboard-wrapper dashboard-user-profile hover'>";
			echo "<div class='media'>";
			echo "<div class='pull-left text-center'>";
			echo "<img class='media-object user-img' src='images/avater.jpg' alt='Image'>";
			echo "<a href='#x' class='btn btn-transparent mt-20'>Change Image</a>";
			echo "</div>";
			echo "<div class='media-body'>";
			echo "<ul class='user-profile-list' id='userProfileList'>";
			echo "<li><span>名字:$id</span><span id=userName></span></li>";
			echo "<li><span>地址:$address</span><span id=userAddress></span></li>";
			echo "<li><span>Email:$email</span><span id=userEmail></span></li>";
			echo "<input type='hidden' name='user_id' value='$id'>";
            echo "<button type='submit' class='product-remove'>移除</button>";
			echo "</ul>";
			echo "</div>";
			echo "</div>";
			echo "</div>";
			echo "</div>";
			echo "</div>";
			echo "</div>";
		}
	}
	
	
	
	?>
</section>

<script>
	function searchEmployee() {
        // 在這裡添加搜尋員工的相應邏輯
        const searchQuery = document.getElementById('searchEmployee').value;
        alert('搜尋員工: ' + searchQuery);
        // 可以在這裡加上執行搜尋的相應邏輯
    }
	
    function addNewEmployee() {
        window.location.href = "add-employee.php";
    }
</script>

<script>
    const userData = JSON.parse(localStorage.getItem('userData'));
    document.getElementById('userName').textContent = userData.name || '';
    document.getElementById('userAddress').textContent = userData.address || '';
    document.getElementById('userEmail').textContent = userData.email || '';
    document.getElementById('userPhone').textContent = userData.phone || '';
    document.getElementById('userID').textContent = userData.username || '';

    function deleteUserProfile(event) {
        event.preventDefault(); // 阻止默認行為

        const confirmDelete = confirm('確定要刪除此使用者嗎？');
        if (confirmDelete) {
            // 在這裡執行刪除使用者的操作
            // 這裡可以加上將使用者資訊清空的相應邏輯，例如：
            document.getElementById('userName').textContent = '';
            document.getElementById('userAddress').textContent = '';
            document.getElementById('userEmail').textContent = '';
            document.getElementById('userPhone').textContent = '';
            document.getElementById('userID').textContent = '';

            alert('User profile deleted');
            // 如果需要重新導向或執行其他操作，可以在這裡添加相應的邏輯
        }
    }
</script>













  </body>
  </html>

  <?php include "footer.php";?>