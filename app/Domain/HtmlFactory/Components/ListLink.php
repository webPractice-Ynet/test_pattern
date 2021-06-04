<?php
namespace App\Domain\HtmlFactory\Components;
use App\Domain\HtmlFactory\Contracts\Link;

class ListLink extends Link {

    public function __construct($caption, $url) {
        parent::__construct($caption, $url);
    }

    public function makeHtml() {
        return '<li><a href="'.$this->url.'">'.$this->caption.'</a></li>'."\n";
    }
}
