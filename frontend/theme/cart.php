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
                      <th class=""></th>
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
                  for ($i = 0;$i < $number;$i++){
                    $count = $NewCart->checkIfInCart($user_id,$i);
                    if($count != 0){
                      for ($j = 0; $j<$count;$j++){
                        $name = $NewCart->getProductName($i);
                        $price = $NewCart->getProductPrice($i);
                        $image = $NewCart->getProductImage($i);
                        echo "<form method='post' action='" . htmlspecialchars($_SERVER["PHP_SELF"]) . "'>";
                        echo "<tr class=''>";
                        echo "<td class=''>";
                        echo "<div class='product-info'>";
                        echo "<img width='80' src=$image alt='' />";
                        echo " <a href='#!'>$name</a>";
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
                  }
                  ?>
                  </tbody>
                </table>
                <a href="checkout.html" class="btn btn-main pull-right">結帳

				</a>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>



    <!-- 
    Essential Scripts
    =====================================-->
    
    <!-- Main jQuery -->
    <script src="plugins/jquery/dist/jquery.min.js"></script>
    <!-- Bootstrap 3.1 -->
    <script src="plugins/bootstrap/js/bootstrap.min.js"></script>
    <!-- Bootstrap Touchpin -->
    <script src="plugins/bootstrap-touchspin/dist/jquery.bootstrap-touchspin.min.js"></script>
    <!-- Instagram Feed Js -->
    <script src="plugins/instafeed/instafeed.min.js"></script>
    <!-- Video Lightbox Plugin -->
    <script src="plugins/ekko-lightbox/dist/ekko-lightbox.min.js"></script>
    <!-- Count Down Js -->
    <script src="plugins/syo-timer/build/jquery.syotimer.min.js"></script>

    <!-- slick Carousel -->
    <script src="plugins/slick/slick.min.js"></script>
    <script src="plugins/slick/slick-animation.min.js"></script>

    <!-- Google Mapl -->
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCC72vZw-6tGqFyRhhg5CkF2fqfILn2Tsw"></script>
    <script type="text/javascript" src="plugins/google-map/gmap.js"></script>

    <!-- Main Js File -->
    <script src="js/script.js"></script>
    


  </body>
  </html>
  <?php include "footer.php";?>