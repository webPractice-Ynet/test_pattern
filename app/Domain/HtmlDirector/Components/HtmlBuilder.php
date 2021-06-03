<?php
namespace App\Domain\HtmlDirector\Components;
use App\Domain\HtmlDirector\Builder;
use Helper\Utils\Writer;

class HtmlBuilder extends Builder {
    private $file_name;
    private $writer = [];

    public function makeTitle ($str) {
        $file_name = $str.".html";
        $this-$writer = new Writer($file_name);

    }

    public function makeString ($str) {

    }

    public function makeItems ($array) {

    }

    public function close () {

    }

}