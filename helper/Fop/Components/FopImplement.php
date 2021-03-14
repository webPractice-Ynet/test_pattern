<?php declare(strict_types=1);
namespace Fop\Components;


trait FopImplement {
    
    protected function implementCurry ($leftFlag, $func, $firstArg) {
        $f = function () use ($leftFlag) {
            return function ($func, $firstArg) use ($leftFlag) {
                return function ($arg) use ($leftFlag, $func, $firstArg) {
          
                    $args = cordinateMethods($leftFlag, [
                        1 => function() use ($firstArg, $arg) {
                            // //var_dump("left");
                            return array_merge([$firstArg], [$arg]);
                        },
                        0 => function() use ($firstArg, $arg){
                            // //var_dump("right");
                            return array_merge([$arg], [$firstArg]);
                        }
                    ]);

                    return bootMethod($this, $func, $args);

                };
            };
        };

        return $f->bindTo($this->bind_target)()($func, $firstArg);
    }

    protected function implementPartial ($leftFlag, $func, $firstArg) {
        $f = function () use ($leftFlag) {
            //可変長引数を使って配列化している。→[0]
            return function ($func, $firstArgs) use ($leftFlag) {

                return function ($args) use ($leftFlag, $func, $firstArgs) {//$argsにarrayを渡すにはどうしたら？
                    //可変長引数を使うと、配列でやってくるから、階層を減らす
                    //var_dump("partial １");//ここ！
                    //var_dump($args);
                   
                    if (gettype($firstArgs) !== 'array') {
                        $firstArgs = [$firstArgs];
                    }
                    if (gettype($args) !== 'array') {
                        $args = [$args];
                    }
                    

                    $args = cordinateMethods($leftFlag, [
                        1 => function() use ($firstArgs, $args) {
                            // //var_dump("left");
                            return array_merge($firstArgs, $args);
                         
                        },
                        0 => function() use ($firstArgs, $args){
                            // //var_dump("right");
                            return array_merge($args, $firstArgs);
                        }
                    ]);
                    //var_dump("bootMethod：partial ２");
                    //var_dump($args);
                    
                    //var_dump("bootMethod：partial 最終");
                    
                    return bootMethod($this, $func, $args);
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
}

