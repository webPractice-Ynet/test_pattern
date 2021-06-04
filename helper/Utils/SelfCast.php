<?php declare(strict_types=1);

namespace Helper\Utils;

trait SelfCast {
    public static function selfCast($obj): self
    {
        if (!($obj instanceof self)) {
            throw new InvalidArgumentException("{$obj} is not instance of CastObject");
        }
        return $obj;
    }
}

