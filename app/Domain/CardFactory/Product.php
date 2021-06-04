<?php
namespace App\Domain\CardFactory;
use  Helper\Utils\SelfCast;

//Factory Method : Product
abstract class Product {
    use SelfCast;
    public abstract function use ();
   
}