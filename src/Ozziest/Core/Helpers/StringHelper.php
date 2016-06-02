<?php namespace Ozziest\Core\Helpers;

class StringHelper {
    
    public static function random($length = 10) 
    {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }
    
    public static function isAcceptable($string)
    {
        //   [A-Za-z0-9 _!ğüşıöçĞÜŞİÖÇ<>~{}`"#$₺€£%&½'|[\]()*+,\-.\\:\/;=?@^_]+
        return true;
    }

}