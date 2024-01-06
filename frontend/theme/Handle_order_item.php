<?php
include_once "../../backend/Product.php";
include_once "../../backend/Order.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // 获取 user_id 和 order_id
    $user_id = $_POST['user_id'];
    $order_id = $_POST['orderId'];

    $item_set = getItemList($order_id, $user_id);

    // 将 PHP 数组转换为 JSON 格式
    echo json_encode($item_set);
    exit;
}

function getItemList($order_id, $user_id)
{
    $item_set = Order::getOrderitems($order_id, $user_id);
    $products = array(); // 初始化数组

    while ($row = mysqli_fetch_assoc($item_set)) {
        $id = $row['product_id'];
        $product = array(
            'name' => Product::getNamebyID($id),
            'price' => Product::getPricebyID($id)
            // 添加其他字段...
        );
        $products[] = $product;
    }

    return $products;
}
?>
