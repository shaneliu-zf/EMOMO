<?php include "header.php"; ?>

<section class="page-header">
	<div class="container">
		<div class="row">
			<div class="col-md-12">
				<div class="content">
					<h1 class="page-name">我的訂單</h1>
					<ol class="breadcrumb">
						<li><a href="shop-sidebar.php">首頁</a></li>
						<li class="active">我的訂單</li>
					</ol>
				</div>
			</div>
		</div>
	</div>
</section>
<section class="user-dashboard page-wrapper">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <ul class="list-inline dashboard-menu text-center">
                    <li><a href="dashboard.html">Dashboard</a></li>
                    <li><a class="active" href="order.html">Orders</a></li>
                    <li><a href="address.html">Address</a></li>
                    <li><a href="profile-details.html">Profile Details</a></li>
                </ul>
            </div>
        </div>
    </div>

    <div class="container">
        <div class="row">
            <div class="col-md-12">
				<div class="form-inline">
					<div class="mb-3">
					<input type="text" class="form-control" placeholder="Search by Order ID" id="searchInput">
					<button class="search-btn" type="button" id="searchButton">
						<span class="tf-ion-ios-search-strong"></span>
					</button>
					</div>
				</div>
            </div>
        </div>
    </div>

    <div class="container">
		<div class="row">
			<div class="col-md-12">
				<!-- 分頁控制元件 -->
				<div id="pagination" class="text-center mb-3"></div>
				
				<!-- 表格 -->
				<div class="dashboard-wrapper user-dashboard">
					<div class="table-responsive">
						<table class="table">
							<!-- thead 和 tbody 部分不變，只在 tbody 中顯示當前頁的訂單 -->
							<thead>
								<tr>
									<th>Order ID</th>
									<th>Date</th>
									<th>Items</th>
									<th>Total Price</th>
									<th>Status</th>
									<th></th>
								</tr>
							</thead>
							<tbody id="ordersTableBody">
								<!-- Your table rows here -->
								<?php
									ini_set('display_errors','1');
									error_reporting(E_ALL);
									include_once "../../backend/Order.php";

									if (isset($_COOKIE['user_id'])){
										$order_list = Order::getOrderDetails($_COOKIE["user_id"]);
										while ($row=mysqli_fetch_row($order_list)){
											$id = $row[0];
											$status = $row[1];
											$order_date = $row[2];
											$arrival_date = $row[3];
											$address = $row[4];
											$user_id = $row[5];
											$gift_code = $row[6];
											echo "<tr>";
											echo "<td>".$id."</td>";
											echo "<td>".$arrival_date."</td>";
											echo "<td>2</td>";
											echo "<td>$99.00</td>";
											echo "<td><span class='label label-primary'>$status</span></td><td>";
											echo "<input type='hidden' name='id' value='$id'>";
											echo "<a href='javascript:void(0);' class='btn btn-default' onclick='showOrderDetails(this)'>View</a></td>";
											echo "</tr>";
										}
									}
									else{
										echo "<script>alert('尚未登入');</script>";
										echo "<script>window.location.href = '/login.php';</script>";
									}
								?>
							</tbody>
						</table>
					</div>
				</div>
				<br>
				<!-- 第二個分頁控制元件 -->
				<div id="pagination2" class="text-center mt-3"></div>
			</div>
		</div>
	</div>
</section>


<script>
    function showOrderDetails(button) {
        // 獲取該行(tr)的資料
        var $tr = $(button).closest('tr');

        // 獲取該行的 Order ID
        var orderId = $tr.find('td:eq(0)').text();
        var orderData = {
            orderId: orderId,
            date: $tr.find('td:eq(1)').text(),
            amount: $tr.find('td:eq(2)').text(),
            totalPrice: $tr.find('td:eq(3)').text(),
            status: $tr.find('td:eq(4) span').text()
        };

        // 檢查是否已存在相同的模態框，如果存在則刪除
        $('#orderDetailsModal').remove();

        // 將資料填充至模態框中
        var modalContent = `
            <div class="modal fade" id="orderDetailsModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Order Details - ${orderData.orderId}</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <p><strong>Order ID:</strong> ${orderData.orderId}</p>
                            <p><strong>Date:</strong> ${orderData.date}</p>
                            <p><strong>Amount:</strong> ${orderData.amount}</p>
                            <p><strong>Total Price:</strong> ${orderData.totalPrice}</p>
                            <p><strong>Status:</strong> ${orderData.status}</p>
							<?php
								ini_set('display_errors','1');
								error_reporting(E_ALL);
								include_once "../../backend/Order.php";

								if ($_SERVER['REQUEST_METHOD'] == "POST"){
									$id = $_POST['id'];
									$address = Order::getAddressbyID($id);
								}
								echo "<p><strong>Address:</strong>$address</p>";
							?>
                            <hr>
                            <p><strong>Ordered Items:</strong></p>
                            <ul>
                                ${renderOrderedItems(orderId)}
                            </ul>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        </div>
                    </div>
                </div>
            </div>
        `;

        // 將模態框的 HTML 添加到頁面中
        $('body').append(modalContent);

        // 顯示模態框
        $('#orderDetailsModal').modal('show');
    }

    // 渲染訂單中的商品列表
    function renderOrderedItems(orderId) {
        // 在這裡你可以根據 orderId 從後端取得相應的商品列表資訊
        // 我做個範例而已 這裡可能以後要去爬資料庫的資料
        var itemsHtml = `
            <li>Product 1 - 2 x $99.00</li>
            <li>Product 2 - 1 x $51.00</li>
            <!-- 更多商品行... -->
        `;
        return itemsHtml;
    }
</script>

<?php include "footer.php"; ?>