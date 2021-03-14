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


    /*
    * @test
    */
    function test_条件付きメソッドを実行する場合() {

        //validator
        $zero = $this->fop->validator(
            "0 は使用不可です。",
            function ($arg) {
                // \var_dump("0　不可：".$arg." : ".($arg === 0));
                return $arg === 0;
            }
        );
        $isNumber = $this->fop->validator(
            "引数は数値である必要があります。",
            function ($arg) {
                // \var_dump("文字　不可：".!is_numeric($arg));
                // var_dump(!is_numeric($arg));
                return !is_numeric($arg);
            }
        );

        //validatorを直接的に組み込んだ場合
        // $sqr = function ($arg) use ($zero, $isNumber) {
        //     if (!$zero($arg)) {
        //         var_dump($zero->message);
        //         return false;
        //     }
        //     if (!$isNumber($arg)) {
        //         var_dump($isNumber->message);
        //         return false;
        //     }
        //     return $arg * $arg;
        // };

        // $this->assertEquals(9, $sqr(3));
        // $this->assertEquals(false, $sqr(0));
        // $this->assertEquals(false, $sqr("aa"));

        //validatorを内部に組み込んだ場合
        $valid = $this->fop->condition1($zero, $isNumber);
        $this->assertEquals(10, $valid(identity(), 10) );
        $this->assertEquals(false, $valid(identity(), 0));
        $this->assertEquals(false, $valid(identity(), "aa"));

        //インスタンスメソッドを実行する場合
        $this->assertEquals(100, $valid('sqr', 10) );
        $this->assertEquals(20, $valid('addUserId', 10, 10) );
    }

    /*
    * @test
    */
    function test_事前条件付きメソッドをpartialで実行する場合() {
        //validator
        $zero = $this->fop->validator(
            "0 は使用不可です。",
            function ($arg) {
                // \var_dump("0　不可：".$arg." : ".($arg === 0));
                return $arg === 0;
            }
        );
        $isNumber = $this->fop->validator(
            "引数は数値である必要があります。",
            function ($arg) {
                // \var_dump("文字　不可：".!is_numeric($arg));
                // var_dump(!is_numeric($arg));
                return !is_numeric($arg);
            }
        );
        $valid = $this->fop->condition1($zero, $isNumber);

        $sqr = function ($num) {
            return $num * $num;
        };

        $checkedSqr = $this->fop->partial($valid, $sqr);//(function, function)となっていて難しい
        $this->assertEquals(100, $checkedSqr(10));//valid(sqr, 10)となり、conditionの引数の並びと一致する。
        $this->assertEquals(false, $checkedSqr(0));
        $this->assertEquals(false, $checkedSqr("str"));

        //事前条件を追加
        $isEven = $this->fop->validator(
            "引数は偶数である必要があります。",
            function ($arg) {
                return $arg%2 !== 0;
            }
        );

        $sillySquare = $this->fop->partial(
            $this->fop->condition1($isEven),
            $checkedSqr
        );

        $this->assertEquals(4, $sillySquare(2));
        $this->assertEquals(false, $sillySquare(3));
        $this->assertEquals(false, $checkedSqr(0));
        $this->assertEquals(false, $checkedSqr("str"));

        //インスタンスメソッドの場合
        $checkedSqr2 = $this->fop->partial($valid, 'sqr');
        $sillySquare2 = $this->fop->partial(
            $this->fop->condition1($isEven),
            $checkedSqr2
        );
        $this->assertEquals(4, $sillySquare2(2));
    }

    /*
    * @test
    */
    function test_関数を順次実行する場合() {

        $add_1 = function($value) {
            return ++$value;
        };
        $add_2 = function($value) {
            return $value + 2;
        };

        //クロージャーだけの場合
        $composeAdd = $this->fop->compose($add_1, $add_2, $add_2);
        $this->assertEquals(5, $composeAdd(0, identity()));

        //インスタンスメソッドだけの場合
        $composeAdd = $this->fop->compose("add_1", "add_2", "add_2");
        $this->assertEquals(6, $composeAdd(0, 'add_1'));

        //混合の場合
        $composeAdd = $this->fop->compose("add_1", $add_2, "add_2");
        $this->assertEquals(5, $composeAdd(0, identity()));

    }

    /*
    * @test
    */
    function test_事前と事後の条件付きメソッドを実行する場合() {

        //validator
        $zero = $this->fop->validator(
            "0 は使用不可です。",
            function ($arg) {
                return $arg === 0;
            }
        );

        $isNumber = $this->fop->validator(
            "引数は数値である必要があります。",
            function ($arg) {
                return !is_numeric($arg);
            }
        );

        $isEven = $this->fop->validator(
            "結果は偶数である必要があります。",
            function ($arg) {
                return $arg%2 !== 0;
            }
        );

        $pre_Condition = $this->fop->condition1($isEven);
        $post_Condition = $this->fop->condition1($zero, $isNumber);

        $checkedSqr = $this->fop->compose(
            $this->fop->partial(
                $pre_Condition, //事前条件
                'sqr' //バリデート後の実行するインスタンスメソッド
            ),
            $this->fop->partial(
                $post_Condition, //事後条件
                identity()
            )
        );

        $this->assertEquals(4, $checkedSqr(2, identity()));
        // $this->assertEquals(false, $megaCheckedSqr(5));
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

    public function add_1($num) {
        return ++$num;
    }

    public function add_2($num) {
        return $num + 2;
    }
    public function sqr($num) {
        return $num * $num;
    }
}

