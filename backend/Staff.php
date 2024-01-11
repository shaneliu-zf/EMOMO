<?php
include_once "User.php";

class Staff extends User{

    function insertProduct(Product $product){
        $link = connectDB();
        $id = $product->getProductId();
        $name = $product->getName();
        $price = $product->getPrice();
        $image = $product->getImage();
        $sql = "INSERT INTO  `ProductList` (`product_id`,`name`, `price`,`image`) VALUE ($id,$name,$price,$image) ";
        // 用mysqli_query方法執行(sql語法)將結果存在變數中
        mysqli_query($link,$sql);
        mysqli_close($link); 
    }
    function editProduct(Product $product){
        $link = connectDB();
        $product_id = $product->getProductId();
        $name = $product->getName();
        $price = $product->getPrice();
        $image = $product->getImage();
        $sql = "UPDATE  `ProductList` SET `product_id` = $product_id, `name` = $name, `price` = $price, `image` = $image WHERE `id`= $product_id;";
        // 用mysqli_query方法執行(sql語法)將結果存在變數中
        mysqli_query($link,$sql);
        mysqli_close($link);
    }
    function deleteProduct($product_id){
        $link = connectDB();
        $sql = "DELETE FROM `ProductList` WHERE `id`= $product_id;";
        // 用mysqli_query方法執行(sql語法)將結果存在變數中
        mysqli_query($link,$sql);
        mysqli_close($link); 
    }
    function insertCoupon(Coupon $coupon){
        $link = connectDB();
        $coupon_id = $coupon->getCouponID();
        $name = $coupon->getName();
        $giftcode = $coupon->getGiftCode();
        $date = $coupon->getDate();
        $rule_mode = $coupon->getRule_mode();
        $rule = $coupon->getRule();
        $discount_mode = $coupon->getDiscount_mode();
        $discount = $coupon->getDiscount();
        $sql = "INSERT INTO  `CouponList` (`coupon_id`,`name`, `giftcode`,`date`,`rule_mode`,`rule`,`discount_mode`,`discount`) VALUE ($coupon_id,$name,$giftcode,$date,$rule_mode,$rule,$discount_mode,$discount) ";
        // 用mysqli_query方法執行(sql語法)將結果存在變數中
        mysqli_query($link,$sql);
        mysqli_close($link);
    }
    function editCoupon(Coupon $coupon){
        $link = connectDB();
        $coupon_id = $coupon->getCouponID();
        $name = $coupon->getName();
        $giftcode = $coupon->getGiftCode();
        $date = $coupon->getDate();
        $rule_mode = $coupon->getRule_mode();
        $rule = $coupon->getRule();
        $discount_mode = $coupon->getDiscount_mode();
        $discount = $coupon->getDiscount();
        $sql = "UPDATE  `CouponList` SET `coupon_id` = $coupon_id, `name` = $name, `giftcode` = $giftcode, `date` = $date, `rule_mode` = $rule_mode, `rule` = $rule, `discount_mode` = $discount_mode, `discount` = $discount WHERE `id`= $coupon_id;";
        // 用mysqli_query方法執行(sql語法)將結果存在變數中
        mysqli_query($link,$sql);
        mysqli_close($link);
    }
    function deleteCoupon($coupon_id){
        $link = connectDB();
        $sql = "DELETE FROM `CouponList` WHERE `id`= $coupon_id;";
        // 用mysqli_query方法執行(sql語法)將結果存在變數中
        mysqli_query($link,$sql);
        mysqli_close($link); 
    }

    function editOrder(Order $order){
        $link = connectDB();
        $order_id = $order->getOrderId();
        $product_list = $order->getProductList();
        $coupon_list = $order->getCouponList();
        $status = $order->getStatus();
        $order_date = $order->getOrderDate();
        $arrival_date = $order->getArrivalDate();
        $address = $order->getAddress();
        $sql = "UPDATE  `OrderList` SET `product_list` = $product_list, `coupon_list` = $coupon_list, `status` = $status, `order_date` = $order_date, `arrival_date` = $arrival_date, `address` = $address WHERE `id`= $order_id;";
        // 用mysqli_query方法執行(sql語法)將結果存在變數中
        mysqli_query($link,$sql);
        mysqli_close($link);
    }

    function deleteOrder($order_id){
        $link = connectDB();
        $sql = "DELETE FROM `OrderList` WHERE `id`= $order_id;";
        // 用mysqli_query方法執行(sql語法)將結果存在變數中
        mysqli_query($link,$sql);
        mysqli_close($link); 
    }
}