<?php
ini_set('display_errors','1');
error_reporting(E_ALL);
require_once "header.php";
require_once "../../backend/Order.php";
require_once "../../backend/Product.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // 確保有 action 參數
    if (isset($_POST['action'])) {
        $action = $_POST['action'];

        // 根據 action 的值執行相應的操作
        if ($action === 'updateStatus') {
            // 獲取 POST 數據
            $newStatus = $_POST['status'];
			$id = $_POST['orderId'];

			if($newStatus == "Completed"){
				Order::updateArrivalDate($id);
			}
            Order::changeStatus($id,$newStatus);
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

<section class="page-header">
	<div class="container">
		<div class="row">
			<div class="col-md-12">
				<div class="content">
					<h1 class="page-name">我的訂單</h1>
					<ol class="breadcrumb">
						<li><a href="index.php">首頁</a></li>
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
									<th>Amount</th>
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
									include_once "../../backend/Product.php";
									include_once "../../backend/User.php";
									include_once "../../backend/Coupon.php";

									if (isset($_COOKIE['user_id'])){
										if(User::isAdmin($_COOKIE['user_id']) || User::isStaff($_COOKIE['user_id'])){
											$order_list = Order::getAllOrderDetails();
										}
										else{
											$order_list = Order::getOrderDetails($_COOKIE["user_id"]);
										}
										while ($row=mysqli_fetch_row($order_list)){
											$id = $row[0];
											$status = $row[1];
											$order_date = $row[2];
											$arrival_date = $row[3];
											$address = $row[4];
											$user_id = $row[5];
											$gift_code = $row[6];
											$Items = Order::getOrderitems($id, $user_id);
											$count = 0;
											$total_price = 0;
											while ($row=mysqli_fetch_row($Items)){
												$count += $row[4];
												$total_price += (Product::getPricebyID($row[3]) * $row[4]);
											}
											if($gift_code != "NULL"){
												$total_price = Coupon::discount($total_price, $gift_code);
											}
											switch ($status) {
												case "Completed":
													$color = "success";
													break;
												case "Pending":
													$color = "primary";
													break;
												case "Canceled":
													$color = "danger";
													break;
												case "Arrived":
													$color = "warning";
													break;
												case "Process":
													$color = "info";
													break;
											}
											echo "<tr>";
											echo "<td>".$id."</td>";
											echo "<td>".$order_date."</td>";
											echo "<td>$count</td>";
											echo "<td>$total_price</td>";
											echo "<td><span id='status$id' class='label label-$color'>$status</span></td>";
											echo "<td>";
											if(User::isAdmin($_COOKIE['user_id']) || User::isStaff($_COOKIE['user_id'])){
												echo "<a href='javascript:void(0);' class='btn btn-default' onclick='openModalAndChangeStatus(status$id,this)'><i class='fa-solid fa-clipboard-list fa-lg'></i></a>";
											}
											echo "<a href='javascript:void(0);' class='btn btn-default' onclick='showOrderDetails(this)'>View</a>";
											echo "</td>";
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

<div id="myModal" class="modal" >
    <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title" id="exampleModalLabel"><strong>Edit Status</strong></h3>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label for="statusSelect">Select Status:</label>
                    <select class="form-control" id="statusSelect">
                        <option value="label-success">Completed</option>
                        <option value="label-primary">Pending</option>
                        <option value="label-danger">Canceled</option>
                        <option value="label-warning">Arrived</option>
                        <option value="label-info">Process</option>
                    </select>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" onclick="updateStatus()">Update Status</button>
            </div>
        </div>
    </div>
</div>

<script>
	var orderId;

	function openModalAndChangeStatus(statusId,button) {
        // 使用 Bootstrap 的方法显示模态框
        $('#myModal').modal('show');
		var $tr = $(button).closest('tr');

        // 獲取該行的 Order ID
        orderId = $tr.find('td:eq(0)').text();

        // 存储当前订单状态标签的id
        currentStatusId = statusId;

        // 获取当前订单状态标签的文字
        var currentStatusText = document.getElementById(statusId).innerText;


        // 设置下拉菜单选中项为当前状态文字
        document.getElementById('statusSelect').value = currentStatusText;
    }

	function closeModal() {
        // 使用 Bootstrap 的方法关闭模态框
        $('#myModal').modal('hide');
    }

	function updateStatus() {
        var status = document.getElementById('statusSelect').options[document.getElementById('statusSelect').selectedIndex].text;


		$.ajax({
                type: 'POST',
                url: window.location.href,  // 使用當前頁面的 URL
                data: {
                    action: 'updateStatus',
                    status: status,
					orderId: orderId
                },
                success: function(response) {
                        alert('編輯成功');
                        window.location.href = '/order.php';
                },
                error: function(error) {
                    console.error('Error:', error);
                }
            });

        // 关闭模态框
        closeModal();
    }

    function showOrderDetails(button) {
        // 獲取該行(tr)的資料
        var $tr = $(button).closest('tr');

        // 獲取該行的 Order ID
        orderId = $tr.find('td:eq(0)').text();
        var orderData = {
            orderId: orderId,
            order_date: $tr.find('td:eq(1)').text(),
            amount: $tr.find('td:eq(2)').text(),
            totalPrice: $tr.find('td:eq(3)').text(),
            status: $tr.find('td:eq(4) span').text()
        };

		$.ajax({
			type: 'POST',
			url: 'Handle_order_item.php',
			data: {
				orderId: orderId
			},
			success: function(response) {
				var responseData = JSON.parse(response);
				console.log(responseData);
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
									<p><strong>Order Date:</strong> ${orderData.order_date}</p>
                    				${orderData.status === 'Completed' ? `<p><strong>Arrival Date:</strong> ${responseData[0].arrival_date}</p>` : ''}
									<p><strong>Amount:</strong> ${orderData.amount}</p>
									<p><strong>Total Price:</strong> ${orderData.totalPrice}</p>
									<p><strong>Status:</strong> ${orderData.status}</p>
									<p><strong>Address:</strong> ${responseData[0].address}</p>
									${responseData[0].gift_code === 'NULL' ? '' : `<p><strong>Gift Code:</strong> ${responseData[0].gift_code}</p>`}
									<hr>
									<p><strong>Ordered Items:</strong></p>
									<ul>
										${responseData.map(item => `<li>${item.name} - ${item.amount} * $${item.price}</li>`).join('')}
									</ul>
								</div>
								<div class="modal-footer">
									<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
								</div>
							</div>
						</div>
					</div>
				`;

				// 將模態框內容添加到 body 中
				$('body').append(modalContent);

				// 手動顯示模態框
				$('#orderDetailsModal').modal('show');
			},
			error: function(error) {
				console.error('Error:', error);
			}
		});
    }
</script>

<?php include "footer.php"; ?>
