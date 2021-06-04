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
    logDump(__FUNCTION__);
    logDump($args);
    if(gettype($func) === 'string' && method_exists($bind, $func)){
        return call_user_func_array([$bind, $func], $args);
    } else {
        return call_user_func_array($func->bindTo($bind), $args);
    }
}

function bootMethod2 ($bind, $func, $args) {
    logDump(__FUNCTION__);
    logDump($args);
    if(gettype($func) === 'string' && method_exists($bind, $func)){
        return call_user_func([$bind, $func], $args);
    } else {
        return call_user_func($func->bindTo($bind), $args);
    }
}

function identity () {
    return function ($value){
        return $value;
    };
}

function logDump ($value) {
    if (false) {
        var_dump($value);
    }
}

function array_push_roop ($data_list, &$target_list) {
    foreach ($data_list as $data_list) {
        array_push($target_list, $data_list);
    }
}


define('STRAGE_PATH', 'storage');