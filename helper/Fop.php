<?php declare(strict_types=1);
namespace Helper;

class Fop {
    public $bind_target_past = null;
    public $bind_target;
    
    public function __construct($bind_target){
        $this->bind_target = $bind_target;
    }

    public function setBindTarget ($obj) {
        $this->bind_target_past = clone $this->bind_target;
        $this->bind_target = $obj;
    }

    public function rewindBindTarget () {
        $this->bind_target = clone $this->bind_target_past;
        $this->bind_target_past = null;
    }

    function executeBindedMethod1 ($leftFlag, $func, $firstArg) {
        $f = function () use ($leftFlag) {
            return function ($func, ...$firstArgs) use ($leftFlag) {
                return function (...$args) use ($leftFlag, $func, $firstArgs) {
                    if (gettype($firstArgs) !== 'array') {
                        $firstArgs = [$firstArgs];
                    }
                    if (gettype($args) !== 'array') {
                        $args = [$args];
                    }

                    $args = cordinateMethods($leftFlag, [
                        1 => function() use ($firstArgs, $args) {
                            // var_dump("left");
                            return array_merge($firstArgs, $args);
                        },
                        0 => function() use ($firstArgs, $args){
                            // var_dump("right");
                            return array_merge($args, $firstArgs);
                        }
                    ]);


                    return call_user_func_array([$this, $func], $args);
                };
            };
        };

        return $f->bindTo($this->bind_target)()($func, $firstArg);
    }

    function executeBindedMethod2 ($leftFlag, $func) {
        $f = function () use ($leftFlag) {
            return function ($func) use ($leftFlag) {
                return function ($firstArgs) use ($leftFlag, $func){
                    return function ($args) use ($leftFlag, $func, $firstArgs) {
                        if (gettype($firstArgs) !== 'array') {
                            $firstArgs = [$firstArgs];
                        }
                        if (gettype($args) !== 'array') {
                            $args = [$args];
                        }

                        $args = cordinateMethods($leftFlag, [
                            1 => function() use ($firstArgs, $args) {
                                // var_dump("left");
                                return array_merge($firstArgs, $args);
                            },
                            0 => function() use ($firstArgs, $args){
                                // var_dump("right");
                                return array_merge($args, $firstArgs);
                            }
                        ]);
                        return call_user_func_array([$this, $func], $args);
                    };
                };

            };
        };

        return $f->bindTo($this->bind_target)()($func);
    }

    function curry($func) {
        return $this->executeBindedMethod2(true, $func);
    }

    function curryRight($func) {
        return $this->executeBindedMethod2(false, $func);
    }

    function partial($func, $firstArg) {
        return $this->executeBindedMethod1(true, $func, $firstArg);
    }

    function partialRight($func, $firstArg) {
        return $this->executeBindedMethod1(false, $func, $firstArg);
    }

}
