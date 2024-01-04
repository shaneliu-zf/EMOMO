<?php include_once "../../backend/ShoppingCart.php";?>
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
  <title>EMOMO | E-commerce</title>

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
  <link rel="stylesheet" href="css/style.css?v=<?php echo time(); ?>">

</head>

<body id="body">

<!-- Start Top Header Bar -->
<section class="top-header">
	<div class="container">
		<div class="row">
			<div class="col-md-4 col-xs-12 col-sm-4">
				 
			</div>
			<div class="col-md-4 col-xs-12 col-sm-4">
				<!-- Site Logo -->
				<div class="logo text-center">
					<a href="shop-sidebar.php">
						<!-- replace logo here -->
						<svg width="135px" height="29px" viewBox="0 0 165 29" version="1.1" xmlns="http://www.w3.org/2000/svg"
							xmlns:xlink="http://www.w3.org/1999/xlink">
							<g id="Page-1" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd" font-size="40"
								font-family="AustinBold, Austin" font-weight="bold">
								<g id="Group" transform="translate(-108.000000, -297.000000)" fill="#000000">
									<text id="AVIATO">
										<tspan x="108.94" y="325">EMOMO</tspan>
									</text>
								</g>
							</g>
						</svg>
					</a>
				</div>
			</div>
			<div class="col-md-4 col-xs-12 col-sm-4">
				<ul class="top-menu text-right list-inline">
					<!-- Search -->
					<li class="dropdown search dropdown-slide">
						<a href="#!" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown">
							<i class="tf-ion-ios-search-strong"></i>
							搜尋
						</a>
						<ul class="dropdown-menu search-dropdown">
							<li>
								<form action="post"><input type="search" class="form-control" placeholder="Search..."></form>
							</li>
						</ul>
					</li><!-- / Search -->
					
					<!-- Cart -->
					<li class="dropdown cart-nav dropdown-slide">
						<?php
						if (isset($_COOKIE['user_id'])){
							echo "<a href='cart.php' class='dropdown-toggle' data-hover='dropdown'><i class='tf-ion-android-cart'></i> 購物車</a>";
							echo "<div class='dropdown-menu cart-dropdown'>";
							$total_price = 0;
							$NewCart = new ShoppingCart();
							$user_id = $_COOKIE['user_id'];
							$number = $NewCart->getNumInProduct();
							echo "<div class='media'>";
							for ($i = 0;$i < $number;$i++){
								$count = $NewCart->checkIfInCart($user_id,$i);
								if($count != 0){
									$name = $NewCart->getProductName($i);
									$price = $NewCart->getProductPrice($i);
									$image = $NewCart->getProductImage($i);
									$price = $price * $count;
									$total_price += $price;
									echo "<a class='pull-center' href='ProductDetail.php?id=$i'>";
									echo "<img class='media-object' src='$image' alt='image' />";
									echo "</a>";
									echo "<div class='media-body'>";
									echo "<h4 class='media-heading'><a href='ProductDetail.php?id=$i'>$name</a></h4>";
									echo "<div class='cart-price'>";
									echo "<span>$count x</span>";
									echo "<span>$price</span>";
									echo "</div>";
									echo "<h5><strong>$$price</strong></h5>";
								}
							  }
							echo "<div class='cart-summary'>";
							echo "<h3><span>Total</span>";
							echo "<span class='total-price'>$$total_price</span></h3>";
							echo "</div>";
							echo "<ul class='text-center cart-buttons'>";
							echo "<li><a href='cart.php' class='btn btn-small btn-solid-border'>View Cart</a></li>";
							echo "<li><a href='checkout.php' class='btn btn-small btn-solid-border'>Checkout</a></li>";
							echo "</ul>";
							echo "</div>";
						}
						else{
							echo "<a href='/login.php' class='dropdown-toggle' data-toggle='dropdown' data-hover='dropdown'><i class='tf-ion-android-cart'></i> 購物車</a>";
						}
						?>
						

					</li><!-- / Cart -->
					
					<li class="dropdown search dropdown-slide">
						<a href="javascript:void(0);" onclick="logout()" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown">
							<i class="tf-ion-android-person"></i>
							<?php
								if (isset($_COOKIE['user_id'])) {
									echo "登出";
								} else {
									echo "登入";
								}
							?>
						</a>
					</li>
				</ul><!-- / .nav .navbar-nav .navbar-right -->
			</div>
		</div>
	</div>
</section>
<!-- Header -->

<!-- Main Menu Section -->
<section class="menu">
	<nav class="navbar navigation">
		<div class="container">
			<div class="navbar-header">
				<h2 class="menu-title">Main Menu</h2>
				<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar"
					aria-expanded="false" aria-controls="navbar">
					<span class="sr-only">Toggle navigation</span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</button>

			</div><!-- / .navbar-header -->

			<!-- Navbar Links -->
			<div id="navbar" class="navbar-collapse collapse text-center">
				<ul class="nav navbar-nav">

					<!-- 首頁 -->
					<li class="dropdown ">
						<a href="shop-sidebar.php"> 首頁 </a>
					</li><!-- / 首頁 -->


					<!-- 我的訂單 -->
					<li class="dropdown ">
						<?php
							if (isset($_COOKIE['user_id'])){
								echo "<a href='/order.php'>我的訂單</a>";
							}
							else{
								echo "<a href='/login.php'>我的訂單</a>";
							}
						?>
					</li><!-- / 我的訂單 -->


					<!-- 會員中心 -->
					<li class="dropdown dropdown-slide">
						<a href="#!" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-delay="350"
							role="button" aria-haspopup="true" aria-expanded="false">會員中心<span
								class="tf-ion-ios-arrow-down"></span></a>
						<div class="dropdown-menu">
							<ul>
								<?php
									if (isset($_COOKIE['user_id'])){
										echo "<li><a href='/dashboard.php'>會員資料</a></li>";
									}
									else{
										echo "<li><a href='/login.php'>會員資料</a></li>";
									}
								?>
								<li><a href="contact.php">聯繫客服</a></li>
							</ul>
						</div><!-- / .dropdown-menu -->
					</li><!-- / 會員中心 -->

					<!-- Home -->
					<li class="dropdown ">
						<a href="about.php"> 關於我們 </a>
					</li><!-- / Home -->

			</div>
			<!--/.navbar-collapse -->
		</div><!-- / .container -->
	</nav>
</section>

<script>
function logout() {
    // 清除 user_id Cookie
    document.cookie = "user_id=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/;";

    // 其他登出相關處理...

    // 跳轉到登出後的頁面或首頁
    window.location.href = 'login.php';  // 修改為你的登出後頁面
}
</script>