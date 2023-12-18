<?php

class Product{
    private $product_id;
    private $name;
    private $price;
    private $image;

    public function getProductId(){
        return $this->product_id;
    }

    public function getName(){
        return $this->name;
    }

    public function getPrice(){
        return $this->price;
    }

    public function getImage(){
        return $this->image;
    }
}