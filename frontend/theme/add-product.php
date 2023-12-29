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
                            <select id="productCategory" name="productCategory" class="form-control" required>
                                <option value="家電類">家電類</option>
                                <option value="食物類">食物類</option>
                                <option value="衣物類">衣物類</option>
                                <option value="其他">其他</option>
                            </select>
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

<?php include "footer.php";?>