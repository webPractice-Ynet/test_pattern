<?php
namespace App\Domain\HtmlFactory\Contracts;


abstract class Factory {
    public static function getFactory($class_path) {
        return new $class_path();
    }

    public abstract function createLink($caption, $url);
    public abstract function createTray($caption);
    public abstract function createPage($title, $author);
}