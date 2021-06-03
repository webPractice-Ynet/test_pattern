<?php
namespace App\Domain\MessageOutPut;

interface Product {
    public function use ($arg);
    public function createClone () :Product;
}