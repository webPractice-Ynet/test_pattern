<?php
namespace Tests\Unit;

use Tests\BaseTest;

use App\Domain\HtmlDirector\Director;

use App\Domain\HtmlDirector\Builder;
use App\Domain\HtmlDirector\Components\TextBuilder;
use App\Domain\HtmlDirector\Components\HtmlBuilder;

class HtmlDirectorTest extends BaseTest {
    public static function setUpBeforeClass(): void
    {
    }
    public static function tearDownAfterClass(): void
    {
    }

    public function setUp() :void
    {
       parent::setUp();
       echo("\n");

    }
    protected function tearDown() :void
    {
    }

    /* Builderパターン
    * @test
    */
    public function test_プレーンテキスト出力 () {
        
        $builder = new TextBuilder();
        $director = new Director($builder);

        $director->construct();
        $result = $builder->getResult();
        echo($result);
    }

    /* Builderパターン
    * @test
    */
    public function test_htmlテキスト出力 () {
        

    }
}