<?php
ini_set('display_errors','1');
error_reporting(E_ALL);
require_once "header.php";
require_once "../../backend/User.php";

if(!isset($_COOKIE['user_id'])){
    echo '<meta http-equiv="refresh" content="0;url=login.php">';
    die();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // 確保有 action 參數
    if (isset($_POST['action'])) {
        $action = $_POST['action'];

        // 根據 action 的值執行相應的操作
        if ($action === 'saveChanges') {
            // 獲取 POST 數據
            $newName = $_POST['newName'];
            $newAddress = $_POST['newAddress'];
            $newPassword = $_POST['newPassword'];
            $confirmPassword = $_POST['confirmPassword'];

            $newPassword = md5($newPassword);
            $User = new User();
            $User->editUser($_COOKIE['user_id'],$newName,$newPassword,$newAddress);
            $response = ['status' => 'success'];
            echo json_encode($response);
        }
        else{
            http_response_code(400);
            echo 'Bad Request';
        }
    }
    else if (isset($_FILES['image'])) {
        $input_image = $_FILES['image']['name'];
        $image_array = explode('.', $input_image);
        $rand = rand(10000, 99999);
        $image_new_name = $image_array[0] . $rand . '.' . $image_array[1];
        $image_upload_path = "uploads/" . $image_new_name;
        $is_uploaded=move_uploaded_file($_FILES["image"]["tmp_name"],$image_upload_path);
        if($is_uploaded){
            //echo 'Image Successfully Uploaded';
        }
        else{
            echo 'Something Went Wrong!';
        }
        $image = "uploads/".$image_new_name;
        $User = new User();
        // 刪除檔案
        $origin_image = $User->getImage($_COOKIE['user_id']);
        if(file_exists($origin_image)){
            unlink($origin_image);
        }
        else{
            echo "檔案不存在";
        }
        // 新增檔案
        $User->changeImage($_COOKIE['user_id'],$image);
        $response = ['status' => 'success'];
        echo json_encode($response);
    }
    else {
        http_response_code(400);
        echo 'Bad Request';
    }
}
?>


<!DOCTYPE html>
<section class="page-header">
	<div class="container">
		<div class="row">
			<div class="col-md-12">
				<div class="content">
					<h1 class="page-name">會員資料</h1>
					<ol class="breadcrumb">
						<li><a href="index.html">首頁</a></li>
						<li class="active">會員中心</li>
                        <li>會員資料</li>
					</ol>
				</div>
			</div>
		</div>
	</div>
</section>


<section class="user-dashboard page-wrapper">
    <div class="container">
        <div class="border">
            <div class="row">
                <div class="col-md-3">
                    <div class="pull-left user-image" onmouseover="hoverImage(this)" onmouseout="unhoverImage(this)" onclick="showModal()">
								<?php
								include_once "../../backend/User.php";
								$NewUser = new User();
								$user_id = $_COOKIE['user_id'];
								$name = $NewUser->getName($user_id);
								$email = $NewUser->getEmail($user_id);
								$address = $NewUser->getAddress($user_id);
                                $image = $NewUser->getImage($user_id);
								echo
                                "<img class='img-circle' src='$image' alt='Image' style='width: 230px; height: 230px;'>
                                    </div>
                                </div>
                                <div class='col-md-6 d-flex align-items-center'>
                                    <div class='user-info text-center'>
                                        <p style='font-size: 1.5em; text-align: left;'><strong>Name:</strong> $name</p>
                                        <p style='font-size: 1.5em; text-align: left;'><strong>Email:</strong> $email</p>
                                        <p style='font-size: 1.5em; text-align: left;'><strong>Address:</strong> $address</p>
                                    </div>
                                </div>";
								?>
                                <div class="col-md-3 d-flex flex-column align-items-center justify-content-center" style="margin-top: auto; margin-bottom: 100px;">
                                <button class="btn btn-secondary btn-lg" onclick="showEditForm()">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-pencil-square" viewBox="0 0 16 16">
                                <path d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z"/>
                            <path fill-rule="evenodd" d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5z"/>
                        </svg>
                    </button>
                </div>
            </div>
        </div>
    </div>
</section>

<div class="modal fade" id="changeImageModal" tabindex="-1" role="dialog" aria-labelledby="changeImageModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document" aria-modal="true">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h3 class="modal-title" id="changeImageModalLabel">更換圖片</h3>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <!-- 添加上传照片的表单 -->
                <form id="uploadForm">
                    <div class="form-group">
                        <label for="photoUpload">上傳照片:</label>
                        <input type="file" class="form-control" id="photoUpload" accept="image/*">
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">取消</button>
                <!-- 添加保存更改按钮 -->
                <button type="button" class="btn btn-primary" onclick="changeImage()">儲存</button>
            </div>
        </div>
    </div>
</div>

<script>
    function showEditForm() {
        // 創建一個模態框
        var modalContent = `
            <div class="modal fade" id="editFormModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">編輯資訊</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <!-- 編輯信息的表單元素 -->
                            <form>
                                <div class="form-group">
                                    <label for="newName">新的名字：</label>
                                    <input type="text" class="form-control" id="newName">
                                </div>
                                <div class="form-group">
                                    <label for="newAddress">新的地址：</label>
                                    <input type="text" class="form-control" id="newAddress">
                                </div>
                                <div class="form-group">
                                    <label for="newPassword">新的密碼：</label>
                                    <input type="password" class="form-control" id="newPassword">
                                </div>
                                <div class="form-group">
                                    <label for="confirmPassword">確認密碼：</label>
                                    <input type="password" class="form-control" id="confirmPassword">
                                </div>
                            </form>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">取消</button>
                            <button type="button" class="btn btn-primary" onclick="saveChanges()">確定</button>
                        </div>
                    </div>
                </div>
            </div>
        `;

        // 刪除現有的模態框，以防止多個模態框的問題
        $('#editFormModal').remove();

        // 將模態框的 HTML 添加到頁面中
        $('body').append(modalContent);

        // 顯示模態框
        $('#editFormModal').modal('show');
    }

	function saveChanges() {
        // 獲取表單元素的值
        var newName = $('#newName').val();
        var newAddress = $('#newAddress').val();
        var newPassword = $('#newPassword').val();
        var confirmPassword = $('#confirmPassword').val();

        if(newPassword != confirmPassword){
            alert('密碼不一致');
        }
        else{
            // 使用 AJAX 將數據發送到同一個 PHP 文件
            $.ajax({
                type: 'POST',
                url: window.location.href,  // 使用當前頁面的 URL
                data: {
                    action: 'saveChanges',
                    newName: newName,
                    newAddress: newAddress,
                    newPassword: newPassword,
                    confirmPassword: confirmPassword
                },
                success: function(response) {
                        alert('編輯成功');
                        window.location.href = '/personal.php';
                },
                error: function(error) {
                    console.error('Error:', error);
                }
            });
        }
    }

    function showModal() {
        $('#changeImageModal').modal('show');
    }

    function changeImage() {
        var photoInput = document.getElementById('photoUpload');
        var photoFile = photoInput.files[0];
        var formData = new FormData();
        formData.append('image', photoFile);
        if (!photoFile){
            alert('請上傳圖片');
        }
        else{
            fetch(window.location.href, {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                console.log('Server Response:', data);
            })
            .catch(success => {
                alert('編輯成功');
                window.location.href = '/personal.php';
            })
            .catch(error => {
                console.error('Error:', error);
            })
        }
    }

    function hoverImage(element) {
    // 在悬浮时可以添加其他效果
        element.style.cursor = 'pointer';
        element.style.opacity = '0.8';
        element.style.cursor = 'pointer';
    }

    function unhoverImage(element) {
        // 恢复默认状态
        element.style.opacity = '1';
    }
</script>

</body>
</html>
<?php include_once "footer.php";?>
