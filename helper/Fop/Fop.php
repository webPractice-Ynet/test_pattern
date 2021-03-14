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

    public function validator($message, $func) {
        //バインドしてはいけない
        $obj = new Class (){
            public $message;
            public $messages = [];
            public $func;
            public function __invoke($arg) {
                
                $func = $this->func;
                $result = $func($arg);

                if ($result) {
                    //どこのメソッドでどの値がきた時に、どのエラーメッセージが出るか、明示したい。
                    //現状,validatorを使いまわした時、エラ〜メッセージと状況も結びつきがわからない
                    $errorMessage = $arg." : ".$this->message;
                    array_push($this->messages, $errorMessage);
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

    public function condition1(...$validators) {
        $f = function ($func, ...$args) use ($validators) {
            if (gettype($args[0]) === 'array') {
                $args = array_shift($args);
            }

            $result = [];
            foreach($validators as $isValid){
                $temp_reult = call_user_func_array([$isValid, '__invoke'], $args);
                if ($temp_reult === false) {
                    // var_dump("condition fail");
                    array_push($result, $isValid->message);
                }
            }
            
            if (count($result) >= 1) {
                return false;
            }

            return bootMethod($this, $func, $args);
        };

        return $f->bindTo($this->bind_target);
    }

    public function compose(...$funcs) {

        // return $this->implementCompose($funcs);

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
