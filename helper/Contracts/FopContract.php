<?php declare(strict_types=1);
namespace Helper\Contracts;

abstract class FopContract {
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
            return function ($func, $firstArg) use ($leftFlag) {
                return function ($arg) use ($leftFlag, $func, $firstArg) {
          
                    $args = cordinateMethods($leftFlag, [
                        1 => function() use ($firstArg, $arg) {
                            // var_dump("left");
                            return array_merge([$firstArg], [$arg]);
                        },
                        0 => function() use ($firstArg, $arg){
                            // var_dump("right");
                            return array_merge([$arg], [$firstArg]);
                        }
                    ]);

                    if(gettype($func) === 'string' && method_exists($this, $func)){
                        return call_user_func_array([$this, $func], $args);
                    } else {
                        return call_user_func_array($func->bindTo($this), $args);
                    }
                };
            };
        };

        return $f->bindTo($this->bind_target)()($func, $firstArg);
    }

    function executeBindedMethod2 ($leftFlag, $func, $firstArg) {
        $f = function () use ($leftFlag) {
            return function ($func, ...$firstArgs) use ($leftFlag) {
                return function (...$args) use ($leftFlag, $func, $firstArgs) {
                    //可変長引数を使うと、配列でやってくるから、階層を減らす
                    if (gettype($firstArgs[0]) === 'array') {
                        $firstArgs = array_shift($firstArgs);
                    }
                    if (gettype($args[0]) === 'array') {
                        $args = array_shift($args);
                    }

                    $args = cordinateMethods($leftFlag, [
                        1 => function() use (&$firstArgs, &$args) {
                            // var_dump("left");
                            return array_merge($firstArgs, $args);
                         
                        },
                        0 => function() use ($firstArgs, $args){
                            // var_dump("right");
                            return array_merge($args, $firstArgs);
                        }
                    ]);

                    if(gettype($func) === 'string' && method_exists($this, $func)){
                        return call_user_func_array([$this, $func], $args);
                    } else {
                        return call_user_func_array($func->bindTo($this), $args);
                    }
                };
            };
        };

        return $f->bindTo($this->bind_target)()($func, $firstArg);
    }

}