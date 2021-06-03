<?php
namespace App\Domain\PageMaker\Components;

class HtmlWriter {
    private $writer = [];

    public function title (String $title) {
        $tags = [
            "<html>",
            "<head>",
            "<title>$title</title>",
            "</head>",
            "<body>\n",
            "<h1>$title</h1>\n"
        ];
        array_push_roop($tags, $this->writer);
    }

    public function paragraph ($msg) {
        if (gettype($msg) === 'String') {
            $this->writer[] = $msg;
            return;
        }

        if (gettype($msg) === 'array') {
            array_push_roop($msg, $this->writer);
        }
    }
} 