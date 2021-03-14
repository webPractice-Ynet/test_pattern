<?php
namespace App\Components\Contracts;
abstract class BaseComponentContract {

    public function __construct(){
    }
    
    public function execute($args) {
        return $this->implement($args);
    }

    abstract protected function implement($args);
}