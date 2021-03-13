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