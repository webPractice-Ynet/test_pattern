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

        $addUserId_10_plus = $fop->partial('addUserId', 10);
        $this->assertEquals(20, $addUserId_10_plus(10));
        $this->assertEquals(40, $addUserId_10_plus(30));

        $addUserId_20_plus_right = $fop->partialRight('addUserId', 20);
        $this->assertEquals(30, $addUserId_20_plus_right(10));
        $this->assertEquals(50, $addUserId_20_plus_right(30));

        $addUserId = $fop->curry('addUserId');
        $this->assertEquals(40, $addUserId(10)(30));
        $this->assertEquals(60, $addUserId(20)(40));

        $addUserId = $fop->curryRight('addUserId');
        $this->assertEquals(50, $addUserId(20)(30));
        $this->assertEquals(70, $addUserId(30)(40));
    }
}

class TestTarget {
    public function addUserId($base, $plus) {
        return $base + $plus;
    }

    public static function addUserId_static($base, $plus) {
        return $base + $plus;
    }
}