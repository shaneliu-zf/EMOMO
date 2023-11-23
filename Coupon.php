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
}