<?php
namespace App\Domain\HtmlDirector\Components;
use App\Domain\HtmlDirector\Builder;
use Helper\Utils\Writer;

class HtmlBuilder extends Builder {
    private $file_name;
    private $writer;

    public function buildTitle ($str) {
        $file_name = $str.".txt";
        $this->writer = new Writer($file_name);
        $this->writer
            ->println("=======================================")
            ->println("「 $str 」");
    }

    public function buildString ($str) {
        $this->writer
            ->println("■ $str");
    }

    public function buildItems ($array) {

        foreach ($array as $element) {
            $this->writer->println("・$element");
        }

    }

    public function buildClose () {
        $this->writer
            ->println("=======================================")
            ->close();
    }

    public function getResult () {
        return $this->file_name;
    }

}