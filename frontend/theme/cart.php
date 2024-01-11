<?php
include_once "header.php";
ini_set('display_errors', '1');
error_reporting(E_ALL);
include_once "../../backend/ShoppingCart.php";
include_once "../../backend/Order.php";

if(!isset($_COOKIE['user_id'])){
    echo '<meta http-equiv="refresh" content="0;url=login.php">';
    die();
}

if ($_SERVER['REQUEST_METHOD'] == "POST") {
  if(isset($_POST['checkout'])){
    $NewCart = new ShoppingCart();
    $Result = $NewCart->getAllProduct($user_id);
    if(mysqli_num_rows($Result) > 0){
      $NewUser = new User();
      $user_id = $_COOKIE['user_id'];
      $address = $NewUser->getAddress($user_id);
      if(isset($_COOKIE['coupon'])){
        $NewOrder = new Order($address, $user_id, $_COOKIE['coupon']);
      }
      else{
        $NewOrder = new Order($address, $user_id, 'NULL');
      }
      $order_id = Order::getCount() - 1;

      while($row=mysqli_fetch_row($Result)){
        $product_id = $row[1];
        if($NewOrder->isExist($order_id, $user_id, $product_id)){
          $NewOrder->updateAmount($order_id, $user_id, $product_id);
        }
        else{
          $NewOrder->checkOut($order_id, $user_id, $product_id);
        }
      }
      $NewCart->removeAll($user_id);

      echo "<script>alert('結帳成功');</script>";
      echo "<script>window.location.href = '/order.php';</script>";
    }
    else{
      echo "<script>alert('結帳失敗');</script>";
    }
  }
  else{
    $NewCart = new ShoppingCart();
    $user_id = $_POST['user_id'];
    $product_id = $_POST['product_id'];

    $success = $NewCart->removeItem($user_id, $product_id);

    if ($success) {
        echo "<script>alert('移除成功');</script>";
    } else {
        echo "<script>alert('移除失敗');</script>";
    }
  }
}
?>
<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>

<body id="body">

<section class="page-header">
	<div class="container">
		<div class="row">
			<div class="col-md-12">
				<div class="content">
					<h1 class="page-name">購物車</h1>
					<ol class="breadcrumb">
						<li><a href="index.php">首頁</a></li>
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
                      <th class="">數量</th>
                      <th class="">價格</th>

                    </tr>
                  </thead>
                  <tbody>
                  <?php
                  ini_set('display_errors','1');
                  error_reporting(E_ALL);
                  include_once "../../backend/ShoppingCart.php";
                  include_once "../../backend/Coupon.php";
                  include_once "../../backend/Product.php";
                  $NewCart = New ShoppingCart();
                  $number = Product::getMax();
                  if(isset($_COOKIE['user_id'])) {
                    // 獲取 user_id
                    $user_id = $_COOKIE['user_id'];
                    }
                  $total_price = 0;
                  for ($i = 0;$i < $number+1;$i++){
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
                        echo " <a href='#!'>$name</a>";
                        echo "</div>";
                        echo "</td>";
                        echo "<td class=''>&nbsp;$count</td>";
                        echo "<td class=''>$price</td>";
                        echo "<td class=''>";
                        echo "<input type='hidden' name='user_id' value=' $user_id'>";
                        echo "<input type='hidden' name='product_id' value='$i'>";
                        echo "<button type='submit' class='btn btn-danger'>移除</button>";
                        echo "</td>";
                        echo "</tr>";
                        echo "</form>";
                    }
                  }
                  echo "</tbody>";
                  echo "</table>";
                  echo "<div class='col text-right'>";
                  if(isset($_COOKIE['coupon'])){
                    $total_price_after_coupon = Coupon::checkIfCanUse($_COOKIE['coupon'],$total_price,$user_id);
                    if($total_price_after_coupon != $total_price){
                      echo "<p>原價：<span class='original-price'>$total_price</span></p>";
                      echo "<p>新價：<span class='new-price'>$total_price_after_coupon</span></p>";
                    }
                    else{
                      echo "<p><span class='new-price'>使用資格不符QQ</span></p>";
                      echo "<p>價格：<span class='new-price'>$total_price</span></p>";
                    }
                  }
                  else{
                    echo "<p>價格：<span class='new-price'>$total_price</span></p>";
                  }
                  echo "</div>";
                  echo "
                        <style>
                          .original-price {
                            position: relative;
                          }

                          .original-price::after {
                            content: '';
                            position: absolute;
                            top: 50%;
                            left: 0;
                            right: 0;
                            height: 1px;
                            background-color: black;
                            transform: translateY(-50%);
                            z-index: 1;
                          }

                          .original-price::before {
                            content: '';
                            position: absolute;
                            top: 0;
                            left: 0;
                            z-index: 2;
                            background-color: white;
                            padding: 0 5px;
                          }

                          .new-price {
                            position: relative;
                            z-index: 3;
                          }
                        </style>
                        <div class='container'>
                          <div class='row'>
                              <div class='col-md-7'>
                                  <a href='coupon-list.php' class='btn btn-main pull-right'>優惠卷</a>
                              </div>
                              <div class='col-md'>
                                <form action='' method='post'>
                                  <button type='submit' class='btn btn-main' name='checkout'>結帳</button>
                                </form>
                              </div>
                          </div>
                      </div>";
                  ?>

              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<script>
// 监听浏览器关闭或离开页面事件
$(window).on('beforeunload', function() {
    // 发送异步请求到服务器删除 cookie
    $.ajax({
        url: '/delete_cookie.php',  // 替换为实际的删除 cookie 的 PHP 脚本路径
        type: 'POST',
        data: {cookie_name: 'coupon'},  // 替换为实际的 cookie 名称
    });
});

</script>

</body>
</html>
<?php include "footer.php";?>
