<?php declare(strict_types=1);

namespace Helper\Utils;

trait Singleton {
    private static $singleton = null;
    private function __construct () {
    }

    //マルチスレッドは非対応
    public static function getInstance () {
        if (is_null($singleton)) {
            $class = __CLASS__;
            self::$singleton = new $class();
        }

        return self::$singleton;
    }
}

