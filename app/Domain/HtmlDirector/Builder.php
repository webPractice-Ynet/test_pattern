<?php
namespace App\Domain\HtmlDirector;

abstract class Builder {
    private $init = false;
    public abstract function buildTitle ($str);
    public abstract function buildString ($str);
    public abstract function buildItems ($array);
    public abstract function buildClose ();


    public function makeTitle ($str) {
        if ($this->init === false) {
            $this->buildTitle($str);
            $this->init = true;
        }
    }
    
    public function makeString ($str) {
        if ($this->init === true) {
            $this->buildString($str);
        }
    }
    public function makeItems ($array) {
        if ($this->init === true) {
            $this->buildItems($array);
        }
    }

    public function close () {
        if ($this->init === true) {
            $this->buildClose();
        }
    }
}