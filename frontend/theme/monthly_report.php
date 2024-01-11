<?php
include_once "header.php";
include_once "../../backend/Order.php";
$data = Order::getPriceArrayOfChart();
$num = Order::getProductSalesArrayOfChart();

if(!isset($_COOKIE['user_id']) || !User::isAdmin($_COOKIE['user_id'])){
    echo '<meta http-equiv="refresh" content="0;url=login.php">';
    die();
}

// 将数据转换为 JSON 格式
$json_data = json_encode($data);
$json_num = json_encode($num);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>銷售統計圖表</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        .total-price {
            font-size: 24px;
            color: #333;
            text-align: center;
            margin-top: 10px;
            margin-left: 20px;
        }

        #totalPriceDisplay {
            font-weight: bold;
            color: #e44d26; /* 或者你喜欢的颜色 */
        }
        .total-item {
            font-size: 24px;
            color: #333;
            text-align: center;
            margin-top: 10px;
            margin-left: 20px;
        }

        #totalItem {
            font-weight: bold;
            color: #e44d26; /* 或者你喜欢的颜色 */
        }
        .header-container {
            display: flex;
            justify-content: space-between;
            align-items: baseline;
            margin-bottom: 10px;
        }
        .total-price {
            white-space: nowrap; /* 防止文字換行 */
        }
        .chart-header {
            font-family: 'Arial', sans-serif;
            font-size: 36px;
            font-weight: bold;
            margin-bottom: 20px;
            position: relative;
            display: inline-block;
            color: transparent;
            background-image: linear-gradient(45deg, #e74c3c, #f39c12, #d35400, #e67e22);
            background-size: 400%;
            animation: rainbow-text 3s linear infinite;
            -webkit-background-clip: text;
            background-clip: text;
        }

        .chart-container {
            width: 80%;
            margin: 20px auto;
            background-color: #f5f7fa;
            border-radius: 8px;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
            padding: 20px;
            box-sizing: border-box;
        }

        .chart-container .month-selector {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 10px;
            text-align: center;
            width: 100%; /* 让其宽度为100% */
            margin: 0 auto; /* 在水平方向上居中 */
        }

        .chart-container .month-selector button {
            font-size: 18px;
            padding: 8px 12px;
            background-color: #3498db;
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            margin: 0 5px; /* 增加一些间距 */
        }

        .chart-container .current-month {
            font-size: 18px;
            font-weight: bold;
            color: #333;
        }

        @keyframes rainbow-text {
            0% {
                background-position: 0%;
            }

            100% {
                background-position: 400%;
            }
        }
    </style>
</head>
<body>

    <!-- 创建一个 canvas 元素用于显示折线图 -->
    <div class="chart-container container">
        <div class="header-container">
            <h1 class="chart-header">逐月銷售訂單數量</h1>

            <!-- 新增顯示價錢的文字元素 -->
            <div class="total-price">
                <strong>總價:</strong><span id="totalPriceDisplay">0</span>
            </div>
        </div>
        <!-- 月份選擇器
        <div class="month-selector">
            <button onclick="adjustMonth(-1)">←</button>
            <div class="current-month">
                <input type="hidden" id="monthRange" value="1">
                <span id="displayMonth">1月</span>
            </div>
        </div> -->
        <canvas id="lineChart1"></canvas>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            // 在網頁載入時計算總和並更新顯示
            updateTotalPrice();
        });
        function updateTotalPrice() {
            var jsonDataa =jsonData.map(item => item.price);  // 請確保 jsonData 包含要計算的數據
            var totalPrice = calculateTotal(jsonDataa);
            document.getElementById('totalPriceDisplay').textContent = totalPrice;
        }
        function adjustMonth(direction) {
        // 取得目前的月份值
        var monthRange = document.getElementById('monthRange');
        var currentMonth = parseInt(monthRange.value);

        // 調整月份
        var newMonth = currentMonth + direction;

        // 確保新月份在合理範圍內（1到12）
        if (newMonth < 1) {
            newMonth = 12;
        } else if (newMonth > 12) {
            newMonth = 1;
        }

        // 更新輸入元素的值
        monthRange.value = newMonth;

        // 更新月份
        updateMonth();
        }

        function updateMonth() {
            // 取得選擇的月份
            var selectedMonth = document.getElementById('monthRange').value;

            // 更新顯示的月份文字
            document.getElementById('displayMonth').innerText = selectedMonth;

            // 根據需要執行相應的操作，例如重新繪製圖表
            // 在這裡你需要根據月份值進行相應的操作
            console.log("Selected Month: " + selectedMonth);
        }
        // 将 PHP 中的 JSON 数据传递给 JavaScript
        var jsonData = <?php echo $json_data; ?>;

        // 创建折线图
        var ctx1 = document.getElementById('lineChart1').getContext('2d');
        var lineChart1 = new Chart(ctx1, {
            type: 'line',
            data: {
                labels: jsonData.map(item => item.date),
                datasets: [{
                    label: '訂單定額',
                    data: jsonData.map(item => item.price),
                    backgroundColor: 'rgba(75, 192, 192, 0.2)',
                    borderColor: 'rgba(75, 192, 192, 1)',
                    borderWidth: 2,
                    fill: false

                }]
            },
            options: {
                plugins: {
                    title: {
                        display: true,
                        text: '1月',
                        font: {
                            size: 24,
                            weight: 'bold',
                            family: 'Arial, sans-serif'
                        },
                        color: '#333'
                    },
                },
                scales: {
                    x: {
                        title: {
                            display: true,
                            text: "日期",
                            font: {
                                size: 36,
                                weight: 'bold',
                                family: 'Arial, sans-serif'
                            }
                        }
                    },
                    y: {
                        beginAtZero: true,
                        title: {
                            display: true,
                            text:"價錢",
                            font: {
                                size: 36,
                                weight: 'bold', // 加粗
                                family: 'Arial, sans-serif' //
                            }
                        }
                    }
                }
            }
        });
        function calculateTotal(data) {
            var total = 0;
            total = data.reduce((acc, val) => acc + val, 0);
            return total;
        }
    </script>

    <div class="chart-container container">
        <div class="header-container">
            <h1 class="chart-header">各商品銷售數量</h1>
            <!-- 新增顯示價錢的文字元素 -->
            <div class="total-item">
                <strong>總數量:</strong><span id="totalItem">0</span>
            </div>
        </div>
        <canvas id="barChart"></canvas>
    </div>

    <script>
        // 将 PHP 中的 JSON 数据传递给 JavaScript
        var jsonNum = <?php echo $json_num; ?>;

        // 创建直方图
        var ctx2 = document.getElementById('barChart').getContext('2d');
        var barChart = new Chart(ctx2, {
            type: 'bar',
            data: {
                labels: jsonNum.map(item => item.id),
                datasets: [{
                    label: '商品銷售額',
                    data: jsonNum.map(item => item.num),
                    borderWidth: 1,
                    backgroundColor: 'rgba(75, 192, 192, 0.2)',
                    borderColor: 'rgba(75, 192, 192, 1)',
                }]
            },
            options: {
            scales: {
                x: {
                    type: 'linear',
                    position: 'bottom',
                    title: {
                        display: true,
                        text: '商品名稱',
                        font: {
                                size: 36,
                                weight: 'bold',
                                family: 'Arial, sans-serif'
                            }
                    }
                },
                y: {
                    beginAtZero: true,
                    title: {
                        display: true,
                        text: '數量',
                        font: {
                                size: 36,
                                weight: 'bold',
                                family: 'Arial, sans-serif'
                            }
                    }
                }
            }
        }
        });
        document.addEventListener("DOMContentLoaded", function() {
            // 在網頁載入時計算總和並更新顯示
            updateTotalItem();
        });
        function updateTotalItem() {
            var jsonDataa =jsonNum.map(item => item.num);  // 請確保 jsonData 包含要計算的數據
            var totalitem = calculateTotalItem(jsonDataa);
            document.getElementById('totalItem').textContent = totalitem;
        }
        function calculateTotalItem(data) {
            var total_item = 0;
            total_item = data.reduce((acc, val) => acc + parseInt(val), 0);
            return total_item;
        }
    </script>

</body>
</html>

<?php include_once "footer.php";?>
