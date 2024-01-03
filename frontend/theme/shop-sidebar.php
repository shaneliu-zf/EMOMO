<?php
	ini_set('display_errors','1');
	error_reporting(E_ALL);
	include "header.php";
?>

<section class="products section">
	<div class="container">
		<div class="row">
			<div class="col-md-2">
			</div>
			<div class="col-md-9">
				<div class="row">
					<?php
					ini_set('display_errors','1');
					error_reporting(E_ALL);
					include_once "../../backend/Product.php";

					for($i=0;$i<Product::getAmount();$i++){
						// big image
						$img = Product::getImagebyID($i);
						echo "<div class='col-md-4 apple-product'><div class='product-item'><div class='product-thumb'>";
						echo "<img class='img-responsive' width='1080' height='1080' src='/$img' alt='product-img' />";
						echo "<div class='preview-meta'><ul><li><span  data-toggle='modal' data-target='#$i'>";
						echo "<i class='tf-ion-ios-search-strong'></i></span></li></ul></div></div>";
						echo "<div class='product-content'>";
						$name = Product::getNamebyID($i);
						$price = Product::getPricebyID($i);
						echo "<h4><a href='ProductDetail.php'>$name</a></h4>";
						echo "<p class='price'>$ $price</p>";
						echo "</div></div></div>";

						// magnifier
						echo "<div class='modal product-modal fade' id='$i'>";
						echo "<button type='button' class='close' data-dismiss='modal' aria-label='Close'>";
						echo "<i class='tf-ion-close'></i></button>";
						echo "<div class='modal-dialog ' role='document'>";
						echo "<div class='modal-content'><div class='modal-body'><div class='row'>";
						echo "<div class='col-md-8 col-sm-6 col-xs-12'><div class='modal-image'>";

						echo "<img class='img-responsive' width='1080' height='1080' src='/$img' alt='product-img' />";
						echo "</div></div><div class='col-md-4 col-sm-6 col-xs-12'><div class='product-short-details'>";
						$name = Product::getNamebyID($i);
						$price = Product::getPricebyID($i);
						$description = Product::getDescriptionbyID($i);
						echo "<h2 class='product-title'>$name</h2>";
						echo "<p class='product-price'>$ $price</p>";
						echo "<p class='product-short-description'><ul>$description</ul></p>";
						echo "<a href='ProductDetail.php' class='btn btn-transparent' style='font-weight:bold;'>商品詳細內容</a>";
						echo "</div></div></div></div></div></div></div>";
					}
					?>
				</div>
			</div>
		</div>
	</div>
</section>

<?php include "footer.php"; ?>
