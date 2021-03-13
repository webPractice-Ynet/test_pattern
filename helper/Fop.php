<?php declare(strict_types=1);
namespace Helper;
use Helper\Contracts\FopContract;

class Fop extends FopContract {

    function curry($func, $firstArg) {
        return $this->executeBindedMethod1(true, $func, $firstArg);
    }

    function curryRight($func, $firstArg) {
        return $this->executeBindedMethod1(false, $func, $firstArg);
    }

    function partial($func, $firstArg) {
        return $this->executeBindedMethod2(true, $func, $firstArg);
    }

    function partialRight($func, $firstArg) {
        return $this->executeBindedMethod2(false, $func, $firstArg);
    }

}
