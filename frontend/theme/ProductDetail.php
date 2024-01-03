<?php
ini_set('display_errors','1');
error_reporting(E_ALL);
require_once "../../backend/ShoppingCart.php";
require_once "header.php";

if ($_SERVER['REQUEST_METHOD'] == "POST"){
  $number = $_POST['number'];
  $product_id = 1;
  $user_id = 0;
  $Newcart = New ShoppingCart();
  $flag = $Newcart->addItem($number,$product_id,$user_id);
  if($flag){
    echo "<script>alert('新增成功');</script>";
  }
  else{
    echo "<script>alert('新增失敗，請重試');</script>";
  }
}
?>

<?php
ini_set('display_errors','1');
error_reporting(E_ALL);
include_once "../../backend/Product.php";

$id = $_GET['id'];
$name = Product::getNamebyID($id);
$image = Product::getImagebyID($id);
$price = Product::getPricebyID($id);
$description = Product::getDescriptionbyID($id);
echo "<section class='$id'><div class='container'><div class='row mt-20'><div class='col-md-5'><div class='$id-slider'>";
echo "<div id='carousel-custom' class='carousel slide' data-ride='carousel'><div class='carousel-outer'><!-- me art lab slider -->";
echo "<div class='carousel-inner '><div class='item active'>";
echo "<img src='$image' alt='圖片無法正常顯示' /></div></div></div>";
echo "<!-- thumb --></div></div></div>";
echo "<div class='col-md-7'><div class='$id-details'><h2>$name</h2><p class='product-price'>$$price</p><p class='product-description mt-20'>";
echo "<ul>$description</ul></p>";
?>

<form class="text-left clearfix" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
    <div class="form-group">
        <label for="number">數量:</label>
        <input type="number" class="form-control"  id="number" name="number" required>
    </div>
    <button type="submit" class="btn btn-main text-center">加入購物車</button>
</form>

</div></div></div></div></section><br><br><br><br>

<?php
    include "footer.php";
?>