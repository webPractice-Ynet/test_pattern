<?php
namespace App\Domain\MessageOutPut;
use App\Domain\MessageOutPut\Product;
class Manager {
    private $showcase = [];

    public function register(String $name, Product $data) {
        $this->showcase[$name] = $data;
    }
    
    public function regitsterList ($data_list) {
        foreach ($data_list as $data) {
            call_user_func_array([$this, "register"], $data);
        }
    }

    public function create(String $proto_name) :Product {
        $p = $this->showcase[$proto_name];
        return $p->createClone();
    }

    
}