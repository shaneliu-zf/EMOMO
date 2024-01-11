<?php
include_once "header.php";
ini_set('display_errors', '1');
error_reporting(E_ALL);
include_once "../../backend/Admin.php";

if(!isset($_COOKIE['user_id']) || !User::isAdmin($_COOKIE['user_id'])){
    echo '<meta http-equiv="refresh" content="0;url=login.php">';
    die();
}

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
                    <h1 class="page-name">帳號列表</h1>
                    <ol class="breadcrumb">
                        <li><a href="shop-sidebar.php">首頁</a></li>
                        <li>帳號列表</li>
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
                        <input type="text" class="form-control" placeholder="搜尋帳號" id="searchEmployee">
                        <button class="btn btn-outline-primary" type="button" onclick="searchEmployee()">搜尋</button>
                    </div>
                </div>
            </div>
            <!--<div class="col-md-6 text-right mt-3">  新增一半的欄位給搜尋框，使新增員工按鈕顯示在右邊
                <button class="btn btn-primary" onclick="addNewEmployee()">新增員工</button>
            </div> -->
        </div>
    </div>

	<?php
	ini_set('display_errors','1');
	error_reporting(E_ALL);
	include_once "../../backend/Admin.php";
	$NewUser = new User();
	$result = $NewUser->getIdList();
	if ($result->num_rows > 0) {
        $searchQuery = isset($_POST['searchEmployee']) ? $_POST['searchEmployee'] : ''; // 从搜索框中获取搜索条件

        while($row = $result->fetch_assoc()) {
            $id = $row["user_id"];
            $name = $NewUser->getName($id);
            $email = $NewUser->getEmail($id);
            $address = $NewUser->getAddress($id);
            $image = $NewUser->getImage($id);
            // 在这里检查是否符合搜索条件
            if (empty($searchQuery) || stripos($name, $searchQuery) !== false) {
                // 符合搜索条件或搜索条件为空时显示
                echo "<form method='post' action='" . htmlspecialchars($_SERVER["PHP_SELF"]) . "'>";
                echo "<div class='container'>";
                echo "<div class='row'>";
                echo "<div class='col-md-12'>";
                echo "<div class='dashboard-wrapper dashboard-user-profile'>";
                echo "<div class='media'>";
                echo "<div class='pull-left text-center'>";
                echo "<img class='media-object user-img mt-3' style='width: 180px; height: 180px;' src='$image' alt='Image'>";
                echo "</div>";
                echo "<div class='media-body'>";
                echo "<ul class='user-profile-list' id='userProfileList'>";
                $user_type = $NewUser->getUserType($id);
                if($user_type=="customer"){
                    echo "<li class='h3' id='userName'><strong>顧客: </strong>$name</li>";
                }
                if($user_type=="staff"){
                    echo "<li class='h3' id='userName'><strong>員工: </strong>$name</li>";
                }
                if($user_type=="admin"){
                    echo "<li class='h3' id='userName'><strong>主管: </strong>$name</li>";
                }
                echo "<li class='h4' id='userAddress'><strong>地址 : </strong>$address</li>";
                echo "<li class='h4' id='userEmail'><strong>Email : </strong>$email</li>";

                echo "<input type='hidden' name='user_id' value='$id'>";
                //echo "<button type='submit' class='btn btn-danger'>移除</button>";
                echo "</ul>";
                echo "</div>";
                echo "</div>";
                echo "</div>";
                echo "</div>";
                echo "</div>";
                echo "</div>";
                echo "</form>";
            }
        }
    }



	?>
</section>

<script>
	function searchEmployee() {
        const searchQuery = document.getElementById('searchEmployee').value.toLowerCase();
        // 遍歷 user-profile-list 中的項目，根據搜尋查詢顯示/隱藏
        const userListItems = document.querySelectorAll('.user-profile-list li#userName');

        userListItems.forEach(item => {
            const userName = item.textContent.toLowerCase();
            const parentDiv = item.closest('.container'); // 找到最近的包裝容器
            if (userName.includes(searchQuery)) {
                parentDiv.style.display = 'block';
            } else {
                parentDiv.style.display = 'none';
            }
        });
    }

    function addNewEmployee() {
        window.location.href = "add-employee.php";
    }
    document.getElementById('searchEmployee').addEventListener('keydown', function(event) {
    if (event.key === 'Enter') {
        searchEmployee();
    }
    });
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
