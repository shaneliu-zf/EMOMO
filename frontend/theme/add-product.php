<?php
ini_set('display_errors','1');
error_reporting(E_ALL);
require_once "header.php";
require_once "../../backend/Product.php";

// || !(User:isStaff($_COOKIE['user_id']) || User::isAdmin($_COOKIE['user_id']))

if(!isset($_COOKIE['user_id']) || !(User::isStaff($_COOKIE['user_id']) || User::isAdmin($_COOKIE['user_id']))){
    echo '<meta http-equiv="refresh" content="0;url=login.php">';
    die();
}

if ($_SERVER['REQUEST_METHOD'] == "POST"){
    $name = $_POST['name'];
    $price = $_POST['price'];
    $description = $_POST['description'];
    $input_image=$_FILES['image']['name'];
    //echo $input_image;
    $image_array=explode('.',$input_image);
    $rand=rand(10000,99999);
    $image_new_name=$image_array[0].$rand.'.'.$image_array[1];
    $image_upload_path="uploads/".$image_new_name;
    $is_uploaded=move_uploaded_file($_FILES["image"]["tmp_name"],$image_upload_path);
    if($is_uploaded){
        //echo 'Image Successfully Uploaded';
    }
    else{
        echo 'Something Went Wrong!';
    }
    $image = "uploads/".$image_new_name;
    $Newproduct = new Product();
    $Newproduct->saveProduct($name,$price,$description,$image);
    $result = $Newproduct->getIssucess();
    if($result){
    echo "<script>alert('新增成功');</script>";
    }
    else{
    echo "<script>alert('重複的名字');</script>";
    }
}
?>

<!-- Main Menu Section -->
<section class="add-product section">
    <div class="container">
        <div class="row">
            <div class="col-md-6 col-md-offset-3">
                <div class="form-wrapper">
                    <h2 class="section-title">新增商品</h2>
                    <form  id="addProductForm" class="text-left clearfix" method="post" enctype="multipart/form-data" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
                        <!-- 在這裡添加您的表單字段 -->
                        <div class="form-group">
                            <label for="name">商品名稱：</label>
                            <input type="text" id="name" name="name" class="form-control" required>
                        </div>

                        <div class="form-group">
                            <label for="price">商品價格：</label>
                            <input type="number" id="price" name="price" class="form-control" required min="0">
                        </div>

                        <div class="form-group">
                            <label for="description">商品描述：</label>
                            <textarea id="description" name="description" class="form-control" required ></textarea>
                        </div>

                        <div class="form-group">
                            <label for="image">上傳圖片：</label>
                            <input type="file" id="image" name="image" accept="image/*">
                        </div>

                        <!-- 根據需要添加更多字段 -->

                        <div class="form-group text-right">
                            <button type="submit" class="btn btn-primary">新增商品</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>

<?php include "footer.php";?>
