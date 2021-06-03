<?php
namespace App\Domain\PageMaker\Components;

class Database {
    private function __construct () {
    }

    public static function getProps ($file_name) {

        $result = false;
        // try {
        //     $file_name = self::formatFileUrl($file_name);
        //     $json =  self::getJsonData($file_name);
        //     if ($json === false) {
        //         throw new Exception('失敗');
        //     }
        //     $result = json_decode($json,true);

        // } catch (Exception $e) {

        //     $result = false;
        // }
        
        return $result;

    }


    private static function formatFileUrl ($file_name) {
        return './'.$file_name.".json";
    } 

    private static function getJsonData ($file_url) {
        $result = false;

        // try {
        //     $json = file_get_contents($file_url);
        //     $result = mb_convert_encoding($json, 'UTF8', 'ASCII,JIS,UTF-8,EUC-JP,SJIS-WIN');
            
        // } catch (Exception $e) {
           
        // }
        return $result;
    }
}