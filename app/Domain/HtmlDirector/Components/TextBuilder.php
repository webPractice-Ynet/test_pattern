<?php
namespace App\Domain\HtmlDirector\Components;
use App\Domain\HtmlDirector\Builder;
use Helper\Utils\Writer;

class TextBuilder extends Builder {
    private $file_name;
    private $writer;

    public function buildTitle ($str) {
        $file_name = $str.".html";
        $this->writer = new Writer($file_name);
        $this->writer
            ->println("<html>\n<head>\n<title>$str</title>\n</head>\n<body>\n")
            ->println("<h1>$str</h1>");
    }

    public function buildString ($str) {
        $this->writer
            ->println("<p>$str</p>");
    }

    public function buildItems ($array) {

        $this->writer->println("<ul>");

        foreach ($array as $element) {
            $this->writer->println(" <li>$element</li>");
        }

        $this->writer->println("</ul>");
    }

    public function buildClose () {
        $this->writer
            ->println("\n</body>\n</html>")
            ->close();
    }

    public function getResult () {
        return $this->file_name;
    }
}