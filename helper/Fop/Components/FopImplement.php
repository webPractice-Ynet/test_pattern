<?php declare(strict_types=1);
namespace Fop\Components;


trait FopImplement {
    
    protected function implementCurry ($leftFlag, $func, $firstArg) {
        $f = function () use ($leftFlag) {
            return function ($func, $firstArg) use ($leftFlag) {
                return function ($arg) use ($leftFlag, $func, $firstArg) {
          
                    $args = cordinateMethods($leftFlag, [
                        1 => function() use ($firstArg, $arg) {
                            // logDump("left");
                            return array_merge([$firstArg], [$arg]);
                        },
                        0 => function() use ($firstArg, $arg){
                            // logDump("right");
                            return array_merge([$arg], [$firstArg]);
                        }
                    ]);

                    return bootMethod($this, $func, $args);

                };
            };
        };

        return $f->bindTo($this->bind_target)()($func, $firstArg);
    }

    protected function implementPartial ($leftFlag, $func, $firstArg, $arrayFlag=false) {
        $f = function () use ($leftFlag, $arrayFlag) {
            //可変長引数を使って配列化している。→[0]
            return function ($func, $firstArgs) use ($leftFlag, $arrayFlag) {

                return function (...$args) use ($leftFlag, $func, $firstArgs, $arrayFlag) {
                    
                    logDump("partial １");//ここ！
                    logDump($args);
                   
                    if (gettype($firstArgs) !== 'array') {
                        $firstArgs = [$firstArgs];
                    }

                    if (count($args) === 1 && gettype($args[0]) === 'array') {
                        //可変長引数を使うと、配列でやってくるから、階層を減らす
                        $args = \array_shift($args);
                    }
                    // if (gettype($args) !== 'array') {
                    //     $args = [$args];
                    // }
                    
                    // \var_dump($args);
                    $args = cordinateMethods($leftFlag, [
                        1 => function() use ($firstArgs, $args) {
                            // logDump("left");
                            return array_merge($firstArgs, $args);
                         
                        },
                        0 => function() use ($firstArgs, $args){
                            // logDump("right");
                            return array_merge($args, $firstArgs);
                        }
                    ]);
                    logDump("bootMethod：partial ２");
                    logDump($args);
                    
                    logDump("bootMethod：partial 最終");

                    if ($arrayFlag) {
                        return bootMethod2($this, $func, $args);
                    } else {
                        return bootMethod($this, $func, $args);
                    }
                };

            };
        };

        return $f->bindTo($this->bind_target)()($func, $firstArg);
    }


    // public function implementCompose(...$funcs) {

    //     $f = function ($arg, $last_func) use ($funcs) {
            
    //         // if ($last_func === null) {
    //         //     $last_func = identity();
    //         // }
    //         array_push($funcs, $last_func);
            
    //         foreach($funcs as $func){
    //             if (gettype($arg) !== 'array') {
    //                 $arg = [$arg];
    //             }
    //             $arg = bootMethod($this, $func, $arg);
    //         }
            
    //         return $arg;
    //     };

    //     return $f->bindTo($this->bind_target);
    // }


    // public function implementCondition($flag=false, ...$validators) {

    //     $invoke = (function () use ($flag) {
    //         $callFunc = 'call_user_func';
    //         $bootMethod = 'bootMethod';
    //         if ($flag) {
    //             $callFunc .= '_array';
    //         } else {
    //             $bootMethod .= '2';
    //         }

    //         return [
    //             'callFunc' => $callFunc,
    //             'bootMethod' => $bootMethod
    //         ];
    //     })();

            
    //     $inner = function ($func, $args) use ($validators){

    //         $result = [];
    //         foreach($validators as $isValid){
              
    //             $temp_reult = call_user_func_array($callFunc, [[$isValid, '__invoke'], $args]);
            
            
    //             if ($temp_reult === false) {
    //                 // logDump("condition fail");
    //                 array_push($result, $isValid->message);
    //             }
    //         }
            
    //         if (count($result) >= 1) {
    //             return false;
    //         }
    //         logDump("bootMethod：conditon 最終");
    //         return $bootMethod('bootMethod', [$this, $func, $args]);
    //     };

    //     $f = null;
    //     if (!$flag) {

    //         $invokes = $getInvoker();
    //         $f = function ($func, ...$args) use ($validators, $getArgs) {
    //             if (gettype($args) !== 'array') {
    //                 $args = [$args];
    //             }
    //             return $inner($func, $args);
    //         };
    //     } else {
    //         $invokes = $getInvoker();
    //         $f = function ($args) use ($validators, $getArgs) {
    //             $func = \array_shift($args);
    //             return $inner($func, $args);
    //         };
    //     }
        
    //     return $f->bindTo($this->bind_target);
    // }
}

