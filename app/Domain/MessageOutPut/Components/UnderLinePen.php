<?php
namespace App\Domain\MessageOutPut\Components;
use  App\Domain\MessageOutPut\Product;

class UnderLinePen implements Product {
    private $line;
    public function __construct ($line) {
        $this->line = $line;
    }
    public function use ($arg) {
        echo("$arg"."\n");

        $count = 0;
        $underLine = "";
        while ($count < 20) {
            $underLine .= $this->line;
            ++$count;
        }
        $underLine .= "\n";
        
        echo($underLine);
    }
    public function createClone () :Product {
        $p = clone $this;
        return $p;
    }
}