<?php
namespace App\Domain\CardFactory\Components;
use App\Domain\CardFactory\Product;

//Factory Method : Concrete Product
class IDCard extends Product {
    private $number;
    private $owner;

    function __construct ($owner, $number) {
        // echo("========================\n");
        // var_dump($data);
        $this->number = $number;
        $this->owner = $owner;
    }
    

    public function getNumber () {
        return $this->number;
    }
    public function getOwner () {
        return $this->owner;
    }

    public function use () {

    }

}
