<?php
namespace App\Domain\HtmlFactory\Contracts;
use Helper\Utils\Writer;

abstract class Page {

   protected $title;
   protected $author;
   protected $content = [];
   
   public function __construct($title, $author) {
      $this->title = $title;
      $this->author = $author;
   }

   public function add (Item $item) {
      $content[] = $item;
      return $this;
   }

   public function output () {
      $file_name = $this->title;
      $writer = new Writer($file_name);
      $writer->println($this->makeHtml());
      $writer->close();
   }

   public abstract function makeHtml();
}