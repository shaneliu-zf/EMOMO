<?php include_once "header.php"; ?>

<?php
ini_set('display_errors','1');
error_reporting(E_ALL);
require_once "../../backend/Product.php";
require_once "../../backend/ShoppingCart.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // 確保有 action 參數
    if (isset($_POST['action'])) {
        $action = $_POST['action'];

        // 根據 action 的值執行相應的操作
        if ($action === 'delete') {
            // 獲取 POST 數據
            $id = $_POST['id'];

            $Product = new Product();
            $Product->deleteProduct($id);
			$Cart = new ShoppingCart();
			if($Cart->isExist($id)){
				$Cart->removeAllItem($id);
			}
            $response = ['status' => 'success'];
            echo json_encode($response);
        }
        else{
            http_response_code(400);
            echo 'Bad Request';
        }
    }
    else {
        http_response_code(400);
        echo 'Bad Request';
    }
}
?>

<section class="products section">
	<div class="container">
		<div class="row">
			<!-- 商品搜尋文字框 -->
            <div class="row">
                <div class="custom-input-group">
                    <input type="text" class="form-control" id="searchInputItem" name="search" placeholder="搜尋商品" onkeydown="searchOnEnter(event)">
                    <button type="button" class="btn btn-primary" onclick="searchProduct()">搜尋</button>
                </div>
            </div>

            <br /><br /><br />
			<div class="col-md-1">
			</div>
			<div class="col-md-10">
				<div class="row">
					<?php
					ini_set('display_errors', '1');
					error_reporting(E_ALL);
					include_once "../../backend/Product.php";
					include_once "../../backend/User.php";

					$searchQuery = isset($_GET['search']) ? $_GET['search'] : ''; // 從 URL 取得搜尋關鍵字
					$products = Product::getAll();

					while ($row = mysqli_fetch_row($products)) {
						// big image
						$id = $row[0];
						$name = $row[1];
						$price = $row[2];
						$description = $row[3];
						$img = $row[4];

						if (empty($searchQuery) || stripos($name, $searchQuery) !== false) {
							echo "<div class='col-md-4 apple-product'><div class='product-item'><div class='product-thumb'>";
							echo "<img class='img-responsive' style='width: 300px; height: 300px;' src='/$img' alt='product-img' />";
							echo "<div class='preview-meta'><ul><li><span  data-toggle='modal' data-target='#$id'>";
							echo "<i class='tf-ion-ios-search-strong'></i></span></li>";
							if (isset($_COOKIE['user_id'])) {
								if (User::isAdmin($_COOKIE['user_id']) || User::isStaff($_COOKIE['user_id'])) {
									echo "
											<li>
												<span class='delete-btn' data-id='$id' style='cursor: pointer;'>
													<i class='bi bi-arrow-down-square'></i>
													<svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='currentColor' class='bi bi-arrow-down-square' viewBox='0 0 16 16'>
													<path fill-rule='evenodd' d='M15 2a1 1 0 0 0-1-1H2a1 1 0 0 0-1 1v12a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1V2zM0 2a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v12a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V2zm8.5 2.5a.5.5 0 0 0-1 0v5.793L5.354 8.146a.5.5 0 1 0-.708.708l3 3a.5.5 0 0 0 .708 0l3-3a.5.5 0 0 0-.708-.708L8.5 10.293V4.5z'/>
													</svg>
												</span>
											</li>";
								}
							}
							echo "</ul></div></div>";
							echo "<div class='product-content'>";
							echo "<h4><a href='ProductDetail.php?id=$id'>$name</a></h4>";
							echo "<p class='price'>$ $price</p>";
							echo "</div></div></div>";

							// magnifier
							echo "<div class='modal product-modal fade' id='$id'>";
							echo "<button type='button' class='close' data-dismiss='modal' aria-label='Close'>";
							echo "<i class='tf-ion-close'></i></button>";
							echo "<div class='modal-dialog ' role='document'>";
							echo "<div class='modal-content'><div class='modal-body'><div class='row'>";
							echo "<div class='col-md-8 col-sm-6 col-xs-12'><div class='modal-image'>";
							echo "<img class='img-responsive' style='width: 500px; height: 500px;' src='/$img' alt='product-img' />";
							echo "</div></div><div class='col-md-4 col-sm-6 col-xs-12'><div class='product-short-details'>";
							echo "<h2 class='product-title'>$name</h2>";
							echo "<p class='product-price'>$ $price</p>";
							echo "<p class='product-short-description'><ul>$description</ul></p>";
							echo "<a href='ProductDetail.php?id=$id' class='btn btn-transparent' style='font-weight:bold;'>商品詳細內容</a>";
							echo "</div></div></div></div></div></div></div>";
						}
					}
					?>
				</div>
			</div>
		</div>
	</div>
</section>

<script>
	function searchOnEnter(event) {
		if (event.key === 'Enter') {
			searchProduct();
		}
	}
	 function searchProduct() {
		const searchQuery = document.getElementById('searchInputItem').value.toLowerCase();
		const productListItems = document.querySelectorAll('.apple-product');

		productListItems.forEach(item => {
			const productName = item.querySelector('h4 a').textContent.toLowerCase();
			if (productName.includes(searchQuery)) {
				item.style.display = 'block';
			} else {
				item.style.display = 'none';
			}
		});
	}
    $('.delete-btn').on('click', function() {
        var id = $(this).data('id');

        $.ajax({
            url: window.location.href,
            method: 'POST',
            data: { action: 'delete', id: id },
            success: function(response) {
                alert('刪除成功');
				window.location.href = '/index.php';
            },
            error: function(error) {
                console.error('Error:', error);
            }
        });
    });
</script>

<?php include "footer.php"; ?>
