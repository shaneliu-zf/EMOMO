<?php
include_once "../../backend/Product.php";
include_once "../../backend/Order.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // 获取 user_id 和 order_id
    $order_id = $_POST['orderId'];
    $user_id = Order::getUserIDbyID($order_id);

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
            'arrival_date' => Order::getArrivalDatebyID($order_id),
            'address' => Order::getAddressbyID($order_id),
            'gift_code' => Order::getGiftCodebyID($order_id),
            'name' => Product::getNamebyID($id),
            'amount' => Order::getOrderSingleItemsCount($order_id, $user_id, $id),
            'price' => Product::getPricebyID($id)
            // 添加其他字段...
        );
        $products[] = $product;
    }

    return $products;
}
?>
