<?php
namespace App\Domain\HtmlDirector;

abstract class Builder {
    
    public abstract function makeTitle ($str);
    public abstract function makeString ($str);
    public abstract function makeItems ($array);
    public abstract function close ();
}