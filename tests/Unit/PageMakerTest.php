<?php
namespace Tests\Unit;

use Tests\BaseTest;
use App\Domain\PageMaker\PageMaker;
class PageMakerTest extends BaseTest {
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
    /*　ファサードパターンのClientがこのテストメソッド
    * @test
    */
    public function test_client_for_facade_pattern () {
        PageMaker::makeWelcomPage('hyuki@hyuki.com', 'welcom.html');
    }
}