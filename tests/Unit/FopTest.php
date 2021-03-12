<?php
namespace Tests\Unit;

use Tests\BaseTest;
use Helper\Fop;

class FopTest extends BaseTest {
    public $var;
    /*
    * @test
    */
    function testPartial() {
        $fop = new Fop(new TestTarget());
        // //staticは使用不可
        // $addUserId_10_plus = $fop->partial(true)('addUserId_static', 10);
        // $this->assertEquals(20, $addUserId_10_plus(10));
        // $this->assertEquals(40, $addUserId_10_plus(30));

        $addUserId_10_plus = $fop->partial('addUserId_array', 10);
        $this->assertEquals(40, $addUserId_10_plus([10,10,10]));
        $this->assertEquals(70, $addUserId_10_plus([20,20,20]));

        $addUserId_20_plus_right = $fop->partialRight('addUserId_array', [20, 20]);
        $this->assertEquals(80, $addUserId_20_plus_right([20, 20]));
        $this->assertEquals(100, $addUserId_20_plus_right([30, 30]));

    //     $addUserId = $fop->curry('addUserId', 10);
    //     $this->assertEquals(40, $addUserId(30));
    //     $this->assertEquals(50, $addUserId(40));

    //     $addUserId = $fop->curryRight('addUserId', 20);
    //     $this->assertEquals(50, $addUserId(30));
    //     $this->assertEquals(60, $addUserId(40));
    }
}

class TestTarget {
    public function addUserId_array($base, $plus1, $plus2, $plus3) {
        return $base + $plus1 + $plus2 + $plus3;
    }
    public function addUserId($base, $plus) {
        return $base + $plus;
    }
    public static function addUserId_static($base, $plus) {
        return $base + $plus;
    }
}