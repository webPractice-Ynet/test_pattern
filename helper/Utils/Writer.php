<?php declare(strict_types=1);

namespace Helper\Utils;

class Writer {
    private $file_pointer;

    public function __construct ($file_name, $path=STRAGE_PATH) {
        $file_path = $path."/".$file_name;
        touch($file_path);
        $this->file_pointer = fopen($file_path, 'w');
    }

    public function println ($data) {
        fwrite($this->file_pointer, $data."\n");
        return $this;
    }

    public function close () {
        fclose($this->file_pointer);
    }
}