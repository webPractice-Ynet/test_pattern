<?php
namespace App\Domain\MessageOutPut\Components;
use  App\Domain\MessageOutPut\Product;

class MessageBox implements Product {
    private $mark;
    public function __construct ($mark) {
        $this->mark = $mark;
    }
    public function use ($arg) {
        echo("$this->mark $arg $this->mark"."\n");
    }

    public function createClone () :Product {
        $p = clone $this;
        return $p;
    }
}