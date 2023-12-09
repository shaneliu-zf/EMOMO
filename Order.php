<?php

class Order {
    private $product_list = [];
    private $coupon_list = [];
    private $status;
    private $order_date;
    private $arrival_date;
    private $address;

    public function getProductList(){
        return $this->product_list;
    }

    public function getCouponList(){
        return $this->coupon_list;
    }

    public function getStatus(){
        return $this->status;
    }
    
    public function getOrderDate(){
        return $this->order_date;
    }

    public function getArrivalDate(){
        return $this->arrival_date;
    }

    public function getAddress(){
        return $this->address;
    }

    public function __construct(ShoppingCart $cart) {
        $this->product_list = $cart->getProductList();
        $this->status = 'Pending'; // 訂單狀態預設為待處理
        $this->order_date = date('Y-m-d');  // 日期預設為今天
    }

    public function addCoupon(Coupon $coupon, $sum) {
        if ((($coupon->getRule_mode() == 'sum') && ($sum >= $coupon->getRule())) || (($coupon->getRule_mode() == 'amount') && (count($this->product_list) >= $coupon->getRule()))){
            if($coupon->getDiscount_mode() == 'minus'){
                return ($sum - $coupon->getDiscount());
            }
            elseif($coupon->getDiscount_mode() == 'percent'){
                return ($sum * $coupon->getDiscount());
            }
            else{
                die("Discount Error!");
            }
        }
        else{
            die("不符合資格");
        }
    }

    public function submitOrder($address) {
        $this->status = 'Submitted';
        $this->address = $address;
        $this->arrival_date = date('Y-m-d', strtotime('+7 days'));
        echo "Order submitted successfully.\n";
    }

    public function getOrderDetails() {
        return [
            'product_list' => $this->product_list,
            'coupon_list' => $this->coupon_list,
            'status' => $this->status,
            'order_date' => $this->order_date,
            'arrival_date' => $this->arrival_date,
            'address' => $this->address,
        ];
    }
}

?>
