<?php
namespace Tests\Unit;

use Tests\BaseTest;

use App\Domain\MessageOutPut\Manager;

use App\Domain\MessageOutPut\Product;
use App\Domain\MessageOutPut\Components\MessageBox;
use App\Domain\MessageOutPut\Components\UnderLinePen;

class MessageOutPutTest extends BaseTest {
    public static function setUpBeforeClass(): void
    {
    }
    public static function tearDownAfterClass(): void
    {
    }

    public function setUp() :void
    {
       parent::setUp();

    }
    protected function tearDown() :void
    {
    }

    /* Prototypeパターン
    * @test
    */
    public function test_テキスト出力 () {

        //準備
        $maneger = new Manager();
        $data_list = [
            [
                'name' => 'strong message',
                'data' => new UnderLinePen('-'),
            ],
            [
                'name' => 'warning box',
                'data' => new MessageBox('*'),
            ],
            [
                'name' => 'slash box',
                'data' => new MessageBox('/'),
            ],
        ];
   
        $maneger->regitsterList($data_list);
        echo("\n");

        // 生成
        $p1 = $maneger->create('strong message');
        $p1->use('Hello, World.');

        $p2 = $maneger->create('warning box');
        $p2->use('Hello, World.');

        $p3 = $maneger->create('slash box');
        $p3->use('Hello, World.');


    }
}