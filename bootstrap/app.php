<?php
//起動
// require_once __DIR__."/../helper/functions/Utility.php";

function cordinateMethods ($target_flag, $executOnFlag, $result=null) {

    foreach ($executOnFlag as $flag => $execute) {
        //厳密にすると、true === 1, true === "true";これらエラーになる
        if ($target_flag == $flag ) {
            $result = $execute();
            break;
        }
    }
    return $result;
}
function bootMethod ($bind, $func, $args) {
    var_dump($args);
    if(gettype($func) === 'string' && method_exists($bind, $func)){
        return call_user_func_array([$bind, $func], $args);
    } else {
        return call_user_func_array($func->bindTo($bind), $args);
    }
}

function identity () {
    return function ($value){
        return $value;
    };
}