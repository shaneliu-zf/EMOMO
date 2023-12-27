<?php

    include "header.php";
    include "ww.php";

?>

<section class="page-header">
	<div class="container">
		<div class="row">
			<div class="col-md-12">
				<div class="content">
					<h1 class="page-name">Dashboard</h1>
					<ol class="breadcrumb">
						<li><a href="index.html">Home</a></li>
						<li class="active">my account</li>
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
                    <li><a href="dashboard.php">Dashboard</a></li>
                    <li><a class="active" href="order.php">Orders</a></li>
                    <li><a href="address.php">Address</a></li>
                    <li><a href="profile-details.php">Profile Details</a></li>
                </ul>
            </div>
        </div>
    </div>

    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="input-group mb-3">
                    <input type="text" class="form-control" placeholder="Search by Order ID" id="searchInput">
                    <br /><br />
                    <div class="input-group-append">
						<button class="btn btn-outline-secondary" type="button" id="searchButton">Search</button>
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
									<th>amount</th>
									<th>Total Price</th>
									<th>Status</th>
									<th></th>
								</tr>
							</thead>
							<tbody id="ordersTableBody">
								<!-- Your table rows here -->
                                <?php

                                $orders = getOrder();
                                $order_list_size = count($orders);

                                for($i=0;$i<$order_list_size;$i++){
                                    echo "<tr>";
                                    echo "<td>".$orders[$i]->order_id."</td>";
                                    echo "<td>".$orders[$i]->date."</td>";
                                    echo "<td>".$orders[$i]->amount."</td>";
                                    echo "<td>".$orders[$i]->total_price."</td>";
                                    echo "<td>".$orders[$i]->status."</td>";
									echo "<td><a href='order.html?order_id=".$orders[$i]->order_id."' class='btn btn-default'>View</a></td>";
                                    echo "</tr>";
                                }

                                ?>
							</tbody>
						</table>
					</div>
				</div>
                <br />

				<!-- 第二個分頁控制元件 -->
				<div id="pagination2" class="text-center mt-3"></div>
			</div>
		</div>
	</div>
</section>


<?php include "footer.php"; ?>
