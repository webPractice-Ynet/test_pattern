<?php
namespace App\Domain\HtmlFactory\Contracts;

abstract class Tray extends Item {
   protected $tray = [];
   public function __construct($caption, $url) {
      parent::__construct($caption);
   }

   public function add (Item $item) {
      $tray[] = $item;
      return $this;
   }
}