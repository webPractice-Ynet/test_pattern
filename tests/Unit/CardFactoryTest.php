<?php
namespace Tests\Unit;

use Tests\BaseTest;

// use App\Domain\CardFactory\Factory;
// use App\Domain\CardFactory\Product;
use App\Domain\CardFactory\Components\IDCardFactory;


class CardFactoryTest extends BaseTest {

    public static function setUpBeforeClass(): void {
    }

    public static function tearDownAfterClass(): void {
    }

    public function setUp() :void
    {
       parent::setUp();
       echo("\n");

    }

    protected function tearDown() :void {

    }

    /* Factory Methodパターン ※キャストできていない
    * @test
    */
    public function test_card () {

        $factory = new IDCardFactory();
        $data_list = [
            '結城博',
            'とむら',
            '佐藤花子'
        ];
        foreach ($data_list as $data) {
            $card = $factory->create($data);
            $card->use();
        }
        
        $card_table = $factory->getCardTable();
        var_dump($card_table);
    }

    
}