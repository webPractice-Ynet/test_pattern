<?php
namespace App\Domain\HtmlDirector\Components;
use App\Domain\HtmlDirector\Builder;
use Helper\Utils\Writer;

class CsvBuilder extends Builder {
    private $file_name;
    private $writer;
    private $count = 0;
    public function buildTitle ($str) {
        $file_name = $str.".csv";
        $this->writer = new Writer($file_name);
        $this->writer
            ->println("number, text");
    }

    public function buildString ($str) {
        $this->insertRow ($str);
    }

    public function buildItems ($array) {
        foreach ($array as $element) {
            $this->insertRow ($element);
        }
    }

    public function buildClose () {
        $this->writer->close();
    }

    public function getResult () {
        return $this->file_name;
    }

    private function insertRow ($str) {
        $this->writer->println("$this->count, $str");
        $this->count = $this->count + 1;
    }

}