<?php declare(strict_types=1);
namespace Fop;

use Fop\Contracts\FopContract;
use Fop\Components\FopImplement;

class Fop extends FopContract {
    use FopImplement;

    public function curry($func, $firstArg) {
        return $this->implementCurry(true, $func, $firstArg);
    }

    public function curryRight($func, $firstArg) {
        return $this->implementCurry(false, $func, $firstArg);
    }

    public function partial($func, $firstArg) {
        return $this->implementPartial(true, $func, $firstArg);
    }

    public function partialRight($func, $firstArg) {
        return $this->implementPartial(false, $func, $firstArg);
    }

    public function partial2($func, $firstArg) {
        return $this->implementPartial(true, $func, $firstArg, true);
    }

    public function validator($message, $func) {
        //バインドしてはいけない
        $obj = new Class (){
            public $message;
            public $messages = [];
            public $func;
            public function __invoke($arg) {
                
                logDump("制約チェック開始=====");
                
                
                $func = $this->func;
                $result = $func($arg);
                logDump("制約チェック終了=====");
                logDump($arg);
                if ($result) {
                    logDump("バリデート失敗");
                    //どこのメソッドでどの値がきた時に、どのエラーメッセージが出るか、明示したい。
                    //現状,validatorを使いまわした時、エラ〜メッセージと状況も結びつきがわからない
                    // $errorMessage = $arg." : ".$this->message;
                    array_push($this->messages, "aaaa");
                    return false;

                } else {
                    return $arg;
                }
            }
        };
        $obj->message = $message;
        $obj->func = $func;
        return $obj;
    }

    public function condition(...$validators) {
        $f = function ($func, ...$args) use ($validators) {

            logDump("condtion実行開始");
            if (gettype($args) !== 'array') {
                $args = [$args];
            }
     
            logDump($args);
            $result = [];
            foreach($validators as $isValid){
              
                $temp_reult = call_user_func_array('call_user_func_array', [[$isValid, '__invoke'], $args]);
            
            
                if ($temp_reult === false) {
                    // logDump("condition fail");
                    array_push($result, $isValid->message);
                }
            }
            
            if (count($result) >= 1) {
                return false;
            }
            logDump("bootMethod：conditon 最終");
            return call_user_func_array('bootMethod', [$this, $func, $args]);
        };
        return $f->bindTo($this->bind_target);
    }

    public function condition2(...$validators) {
      
        $f = function ($args) use ($validators) {//..args ここ怪しい→いや必要

            logDump("condtion実行開始");
            
            $func = \array_shift($args);
            logDump($args);

            $result = [];
            foreach($validators as $isValid){
              
                $temp_reult = call_user_func([$isValid, '__invoke'], $args);
            
            
                if ($temp_reult === false) {
                    // logDump("condition fail");
                    array_push($result, $isValid->message);
                }
            }
            
            if (count($result) >= 1) {
                return false;
            }
            logDump("bootMethod：conditon 最終");
            return bootMethod2($this, $func, $args);
        };

        return $f->bindTo($this->bind_target);
    }

    public function compose(...$funcs_array) {

        // return $this->implementCompose($funcs);

        $f = function ($arg) use ($funcs_array) {//ここ...付与
            // if ($last_func === null) {
            //     $last_func = identity();
            // }
            // array_push($funcs_array, identity());
            // if (gettype($arg) !== 'array') {
            //     $arg = [$arg];
            // }  
            foreach($funcs_array as $execute){
               
                logDump("bootMethod：compose ぐるぐる");
                $arg = bootMethod2($this, $execute, $arg);//ここ

                if ($arg == false) {
                    break;
                }
            }
            logDump("compose実行完了");
            logDump($arg);
            return $arg;
        };

        return $f->bindTo($this->bind_target);
    }

    public function composeRight(...$funcs) {

        $funcs = array_reverse($funcs);

        $f = function ($arg, $last_func=null) use ($funcs) {
            if ($last_func === null) {
                $last_func = identity();
            }
            array_push($funcs, $last_func);
            
            foreach($funcs as $func){
                if (gettype($arg) !== 'array') {
                    $arg = [$arg];
                }
                $arg = bootMethod($this, $func, $arg);
            }
            
            return $arg;
        };

        return $f->bindTo($this->bind_target);
    }
}
