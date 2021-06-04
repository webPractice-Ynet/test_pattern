<?php
namespace Tests\Unit;

use Tests\BaseTest;

use App\Domain\HtmlFactory\Contracts\Factory;
// use App\Domain\CardFactory\Product;
// use App\Domain\HtmlFactory\Components\IDCardFactory;


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

    /* Abstract Factory Methodパターン 
    * @test
    */
    public function test_html () {

        $class_path = "";
        $factory = Factory::getFactory($class_path);

        $data_list = [
            '朝日新聞' => 'https://www.asahi.com/',
            '読売新聞' => 'https://www.yomiuri.co.jp/',
            'Yahoo!' => 'https://www.yahoo.com/',
            'Yahoo!japan'=> 'https://www.yahoo.co.jp/',
            'Exite' => 'https://www.excite.com/',
            'Google' => 'https://www.google.com/'
        ];

        $link_list = [];
        foreach ($data_list as $name => $link) {
            $link_list[] = $factory->createLink($name, $link);
        }

        $tray_news = $factory->createTray('新聞');
        $tray_news
            ->add($link_list[0])
            ->add($link_list[1]);

        $tray_yahoo = $factory->createTray('Yahoo');
        $tray_yahoo
            ->add($link_list[2])
            ->add($link_list[3]);

        $tray_search = $factory->createTray('サーチエンジン');
        $tray_search
            ->add($tray_yahoo)
            ->add($link_list[4])
            ->add($link_list[5]);

        $page = $factory->createPage('LinkPage', '結城 博');
        $page
            ->add($tray_news)
            ->add($tray_search)
            ->output();

    }

    
}