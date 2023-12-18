<?php

class User{
    private $user_id;
    private $name;
    private $email;
    private $password;
    private $address;
    private $user_type;

    public function getUser_id(){
        return $this->user_id;
    }

    public function getName(){
        return $this->name;
    }

    public function getEmail(){
        return $this->email;
    }

    public function getPassword(){
        return $this->password;
    }

    public function getAddress(){
        return $this->address;
    }

    public function getUserType(){
        return $this->user_type;
    }
}