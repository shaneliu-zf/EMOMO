<?php

class Coupon{
    private $coupon_id;
    private $name;
    private $gift_code;
    private $date;
    private $rule_mode; // sum 、 amount
    private $rule; // 100 、 5
    private $discount_mode;  // minus 、 percent
    private $discount;

    public function getRule_mode() {
        return $this->rule_mode;
    }

    public function getRule() {
        return $this->rule;
    }

    public function getDiscount_mode() {
        return $this->discount_mode;
    }

    public function getDiscount() {
        return $this->discount;
    }

    public function getCouponID(){
        return $this->coupon_id;
    }

    public function getName(){
        return $this->name;
    }

    public function getGiftCode(){
        return $this->gift_code;
    }

    public function getDate(){
        return $this->date;
    }
}