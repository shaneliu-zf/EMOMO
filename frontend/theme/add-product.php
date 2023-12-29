<?php
ini_set('display_errors','1');
error_reporting(E_ALL);
require_once "header.php";
require_once "../../backend/Product.php";

if ($_SERVER['REQUEST_METHOD'] == "POST"){
  $name = $_POST['name'];
  $price = $_POST['price'];
  $description = $_POST['description'];
  $image = $_POST['image'];
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
<!DOCTYPE html>

<!--
 // WEBSITE: https://themefisher.com
 // TWITTER: https://twitter.com/themefisher
 // FACEBOOK: https://www.facebook.com/themefisher
 // GITHUB: https://github.com/themefisher/
-->

<html lang="en">
<head>

  <!-- Basic Page Needs
  ================================================== -->
  <meta charset="utf-8">
  <title>Aviato | E-commerce template</title>

  <!-- Mobile Specific Metas
  ================================================== -->
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="description" content="Construction Html5 Template">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=5.0">
  <meta name="author" content="Themefisher">
  <meta name="generator" content="Themefisher Constra HTML Template v1.0">
  
  <!-- Favicon -->
  <link rel="shortcut icon" type="image/x-icon" href="images/favicon.png" />
  
  <!-- Themefisher Icon font -->
  <link rel="stylesheet" href="plugins/themefisher-font/style.css">
  <!-- bootstrap.min css -->
  <link rel="stylesheet" href="plugins/bootstrap/css/bootstrap.min.css">
  
  <!-- Animate css -->
  <link rel="stylesheet" href="plugins/animate/animate.css">
  <!-- Slick Carousel -->
  <link rel="stylesheet" href="plugins/slick/slick.css">
  <link rel="stylesheet" href="plugins/slick/slick-theme.css">
  
  <!-- Main Stylesheet -->
  <link rel="stylesheet" href="css/style.css">

  <!-- 在<head>標籤中添加以下CSS -->
<style>
    /* 新增商品表單樣式 */
    .add-product {
        padding: 60px 0;
        background-color: #f9f9f9;
    }

    .add-product form {
        background-color: #fff;
        padding: 30px;
        border-radius: 5px;
        box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
    }

    .add-product label {
        display: block;
        margin-bottom: 8px;
    }

    .add-product input,
    .add-product textarea {
        width: 100%;
        padding: 10px;
        margin-bottom: 15px;
        border: 1px solid #ddd;
        border-radius: 3px;
    }

    /* 固定描述框的高度並禁止縮放 */
    .add-product textarea {
        height: 100px; /* 調整高度 */
        resize: none; /* 禁止縮放 */
    }

    .add-product button {
        background-color: #28a745;
        color: #fff;
        padding: 10px 20px;
        border: none;
        border-radius: 3px;
        cursor: pointer;
    }

    .add-product button:hover {
        background-color: #218838;
    }
</style>

</head>

<body id="body">






<!-- Main Menu Section -->
<section class="add-product section">
    <div class="container">
        <div class="row">
            <div class="col-md-6 col-md-offset-3">
                <div class="form-wrapper">
                    <h2 class="section-title">新增商品</h2>
                    <form class="text-left clearfix" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
                        <!-- 在這裡添加您的表單字段 -->
                        <div class="form-group">
                            <label for="name">商品名稱：</label>
                            <input type="text" id="name" name="name" class="form-control" required>
                        </div>

                        <div class="form-group">
                            <label for="price">商品價格：</label>
                            <input type="number" id="price" name="price" class="form-control" required>
                        </div>

                        <div class="form-group">
                            <label>商品類別：</label>
                            <select id="productCategory" name="productCategory" class="form-control" required onchange="checkCategory(this)">
                                <option value="家電類">家電類</option>
                                <option value="食物類">食物類</option>
                                <option value="衣物類">衣物類</option>
                                <option value="其他">其他</option>
                            </select>
                        </div>

                        <div id="otherCategoryInput" style="display: none;" class="form-group">
                            <label for="otherCategory">其他類別：</label>
                            <input type="text" id="otherCategory" name="otherCategory" class="form-control">
                        </div>

                        <div class="form-group">
                            <label for="description">商品描述：</label>
                            <textarea id="description" name="description" class="form-control" required></textarea>
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

<script>
    function checkCategory(select) {
        var otherCategoryInput = document.getElementById('otherCategoryInput');
        otherCategoryInput.style.display = (select.value === '其他') ? 'block' : 'none';
    }
</script>



<?php include "footer.php";?>