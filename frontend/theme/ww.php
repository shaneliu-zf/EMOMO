<?php
function getOrder(){
    class Order{
        public $order_id=0;
        public $date="";
        public $amount="";
        public $total_price=0;
        public $status="";
        function __construct($a,$b,$c,$d,$e){
            $this->order_id=$a;
            $this->date=$b;
            $this->amount=$c;
            $this->total_price=$d;
            $this->status=$e;
        }
    }

    $orders[] = new Order(1,"zcxc",3,4,5);
    $orders[] = new Order(2,"asdasd",4,5,6);
    $orders[] = new Order(3,"asd",4,5,6);
    $orders[] = new Order(4,"zx",4,5,6);
    $orders[] = new Order(5,"asdsd",4,5,6);
    $orders[] = new Order(6,"zcxc",3,4,5);
    $orders[] = new Order(7,"asdasd",4,5,6);
    $orders[] = new Order(8,"asd",4,5,6);
    $orders[] = new Order(9,"zx",4,5,6);
    $orders[] = new Order(10,"asdsd",4,5,6);
    $orders[] = new Order(11,"zcxc",3,4,5);
    $orders[] = new Order(12,"asdasd",4,5,6);
    $orders[] = new Order(13,"asd",4,5,6);
    $orders[] = new Order(14,"zx",4,5,6);
    $orders[] = new Order(15,"asdsd",4,5,6);

    return $orders;
}

?>
