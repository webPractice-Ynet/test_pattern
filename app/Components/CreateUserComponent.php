<?php

namespace App\Components;
use App\Components\Contracts\BaseComponentContract;

class CreateUserComponent extends BaseComponentContract {
    public function __construct(){
        parent::__construct();
    }

    protected function implement($args) {
        $args = $this->getInfo($args);
        $args = $this->checkInfo($args);
        $args = $this->updateInfo($args);

        return $args;
    }

    private function getInfo($data) {
       return $data;
    }

    private function checkInfo($data) {
        return $data;
    }

    private function updateInfo($data) {
        return $data;
    }
}