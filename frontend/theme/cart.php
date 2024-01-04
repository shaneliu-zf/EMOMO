<?php
include_once "header.php";
ini_set('display_errors', '1');
error_reporting(E_ALL);
include_once "../../backend/ShoppingCart.php";

$NewCart = new ShoppingCart();

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $user_id = $_POST['user_id'];
    $product_id = $_POST['product_id'];

    $success = $NewCart->removeItem($user_id, $product_id);

    if ($success) {
        echo "<script>alert('移除成功');</script>";
    } else {
        echo "<script>alert('移除失敗');</script>";
    }
}
?>


<body id="body">

<section class="page-header">
	<div class="container">
		<div class="row">
			<div class="col-md-12">
				<div class="content">
					<h1 class="page-name">購物車</h1>
					<ol class="breadcrumb">
						<li><a href="shop-sidebar.php">首頁</a></li>
						<li class="active">購物車</li>
					</ol>
				</div>
			</div>
		</div>
	</div>
</section>

<div class="page-wrapper">
  <div class="cart shopping">
    <div class="container">
      <div class="row">
        <div class="col-md-8 col-md-offset-2">
          <div class="block">
            <div class="product-list">
              <form method="post">
                <table class="table">
                <thead>
                    <tr>
                      <th class="">商品名稱</th>

                      <th class="">價格</th>
                    
                    </tr>
                  </thead>
                  <tbody>
                  <?php
                  ini_set('display_errors','1');
                  error_reporting(E_ALL);
                  include_once "../../backend/ShoppingCart.php";
                  $NewCart = New ShoppingCart();
                  $number = $NewCart->getNumInProduct();
                  if(isset($_COOKIE['user_id'])) {
                    // 獲取 user_id
                    $user_id = $_COOKIE['user_id'];
                    }
                  $total_price = 0;
                  for ($i = 0;$i < $number;$i++){
                    $count = $NewCart->checkIfInCart($user_id,$i);
                    if($count != 0){
                        $name = $NewCart->getProductName($i);
                        $price = $NewCart->getProductPrice($i);
                        $image = $NewCart->getProductImage($i);
                        $price = $price * $count;
                        $total_price += $price;
                        echo "<form method='post' action='" . htmlspecialchars($_SERVER["PHP_SELF"]) . "'>";
                        echo "<tr class=''>";
                        echo "<td class=''>";
                        echo "<div class='product-info'>";
                        echo "<img width='80' src=$image alt='' />";
                        echo " <a href='#!'>$name x $count</a>";
                        echo "</div>";
                        echo "</td>";
                        echo "<td class=''>$price</td>";
                        echo "<td class=''>";
                        echo "<input type='hidden' name='user_id' value=' $user_id'>";
                        echo "<input type='hidden' name='product_id' value='$i'>";
                        echo "<button type='submit' class='product-remove'>移除</button>";
                        echo "</td>";
                        echo "</tr>";
                        echo "</form>";
                    }
                  }
                  echo "<tr class=''>";
                  echo "<td class=''>";
                  echo "<div class='product-info'>";
                  echo "";
                  echo " <a href='#!'></a>";
                  echo "</div>";
                  echo "</td>";
                  echo "<td class=''>$total_price</td>";
                  echo "<td class=''>";
                  echo "</td>";
                  echo "</tr>";
                  echo "</form>";
                  echo "</tbody>";
                  echo "</table>";
                  echo "<a href='checkout.php' class='btn btn-main pull-right'>結帳</a>";
                  
                  ?>
                
                
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

</body>
</html>
<?php include "footer.php";?>