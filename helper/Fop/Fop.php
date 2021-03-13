<?php declare(strict_types=1);
namespace Fop;

use Fop\Contracts\FopContract;
use Fop\Components\FopImplement;

class Fop extends FopContract {
    use FopImplement;

    function curry($func, $firstArg) {
        return $this->implementCurry(true, $func, $firstArg);
    }

    function curryRight($func, $firstArg) {
        return $this->implementCurry(false, $func, $firstArg);
    }

    function partial($func, $firstArg) {
        return $this->implementPartial(true, $func, $firstArg);
    }

    function partialRight($func, $firstArg) {
        return $this->implementPartial(false, $func, $firstArg);
    }
}
