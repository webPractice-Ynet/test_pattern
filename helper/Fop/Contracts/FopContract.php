<?php declare(strict_types=1);
namespace Fop\Contracts;

abstract class FopContract {
    

    public $bind_target_past = null;
    public $bind_target;
    
    public function __construct($bind_target){
        $this->bind_target = $bind_target;
    }

    public function setBindTarget ($obj) {
        $this->bind_target_past = clone $this->bind_target;
        $this->bind_target = $obj;
    }

    public function rewindBindTarget () {
        $this->bind_target = clone $this->bind_target_past;
        $this->bind_target_past = null;
    }

    abstract protected function implementCurry ($leftFlag, $func, $firstArg);
    abstract protected function implementPartial ($leftFlag, $func, $firstArg);
}