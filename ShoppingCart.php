<?php

class ShoppingCart {
    private $shopping_cart_id;
    private $product_list = [];

    public function __construct() {
        $this->shopping_cart_id = uniqid('cart_');
    }

    public function addProduct($product_id, $product_name, $price, $quantity = 1) {
        // 檢查產品是否在購物車中
        if (isset($this->product_list[$product_id])) {
            // 如果是，增加產品數量
            $this->product_list[$product_id]['quantity'] += $quantity;
        } 
        else {
            // 如果不是，添加產品到購物車
            $this->product_list[$product_id] = [
                'product_name' => $product_name,
                'price' => $price,
                'quantity' => $quantity,
            ];
        }

        echo "Product added to the shopping cart.\n";
    }

    public function submit() {

    }

    public function getProductList() {
        return $this->product_list;
    }
}

?>
