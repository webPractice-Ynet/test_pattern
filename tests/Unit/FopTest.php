<?php
namespace Tests\Unit;

use Tests\BaseTest;
use Fop\Fop;

class FopTest extends BaseTest {
    public $value = 2;
    public $fop;
    public $target_obj;
    
    public function setUp() :void
    {
       parent::setUp();
       $this->target_obj = new TestTarget();
       $this->fop = new Fop($this->target_obj);
    }


    /*
    * @test
    */
    function test_インスタンスメソッドを実行する場合() {
    
        // //staticは使用不可
        // $addUserId_10_plus = $fop->partial(true)('addUserId_static', 10);
        // $this->assertEquals(20, $addUserId_10_plus(10));
        // $this->assertEquals(40, $addUserId_10_plus(30));

        //インスタンスメソッドを実行する場合
        $addUserId = $this->fop->curry('addUserId', 10);
        $this->assertEquals(40, $addUserId(30));
        $this->assertEquals(50, $addUserId(40));

        $addUserId = $this->fop->curryRight('addUserId', 20);
        $this->assertEquals(50, $addUserId(30));
        $this->assertEquals(60, $addUserId(40));


        $addUserId_10_plus = $this->fop->partial('addUserId_array', 10);
        $this->assertEquals(40, $addUserId_10_plus([10,10,10]));
        $this->assertEquals(70, $addUserId_10_plus([20,20,20]));

        $addUserId_20_plus_right = $this->fop->partialRight('addUserId_array', [20, 20]);
        $this->assertEquals(80, $addUserId_20_plus_right([20, 20]));
        $this->assertEquals(100, $addUserId_20_plus_right([30, 30]));
        
    }


    /*
    * @test
    */
    function test_クロージャーを実行する場合() {
        
        $targetMethod = function($a, $b) {
            return $a * $b * $this->value;
        };

        //普通のクロージャーバインド
        $result = $targetMethod->call($this, 10, 10);
        $this->assertEquals(200, $result);

        $result = $targetMethod->call($this->target_obj, 10, 10);
        $this->assertEquals(300, $result);
        
        
        //$fop内部では$objがバインド済み。なので$this->value === 3;

        //curyyの場合
        $mutil_10_x = $this->fop->curry($targetMethod, 10);
        $this->assertEquals(300, $mutil_10_x(10));

        //patialの場合
        $targetMethod = function($a, $b, $c, $d) {
            return $a * $b * $this->value * $c * $d;
        };
        $mutil_10_x = $this->fop->partial($targetMethod, [10, 10]);
        $this->assertEquals(30000, $mutil_10_x([10, 10]));
    }
}

class TestTarget {
    public $value = 3;
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

