<?php
namespace App\Domain\CardFactory;

use  Helper\Utils\SelfCast;

//Factory Method : Creator
abstract class Factory {
    use SelfCast;
    
    public final function create($data) {
        
        $p = $this->createProduct($data);
        $this->registerProduct($p);
        
        return $p;
    }

    public abstract function createProduct ($data);
    public abstract function registerProduct ($product);
}