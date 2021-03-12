<?php

namespace App\Components;
use App\Components\ComponentsContracts\BaseComponents;

class CreateUserComponent extends BaseComponents {
    public function __construct(){
        parent::__construct();
    }

    protected function implement($args) {

        return true;
    }
}