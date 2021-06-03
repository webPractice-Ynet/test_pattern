<?php declare(strict_types=1);

namespace Helper\Utils;

class Writer {
    public function __construct ($file_name, $path="/storage") {
        $file_path = $path."/".$file_name;
        touch($file_path);
    }

}