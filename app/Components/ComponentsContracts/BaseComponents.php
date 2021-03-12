<?php
namespace App\Components\ComponentsContracts;
abstract class BaseComponents {

    public function __construct(){
    }
    
    public function execute($args) {
        return $this->implement($args);
    }

    abstract protected function implement($args);
}