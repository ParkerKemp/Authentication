<?php

class Utils {

    public static function jsTag($url, $noCache = true) {
        return '<script src="' . ($noCache ? self::obfuscatedUrl($url) : $url) . '"></script>';
    }

    public static function cssTag($url, $noCache = true, $media = "screen") {
        return '<link href="' . ($noCache ? self::obfuscatedUrl($url) : $url) . '" rel="stylesheet" media="' . $media . '" />';
    }
    
    private static function obfuscatedUrl($url){
        return $url . (strpos($url, '?') === false ? '?' : '&') . '__=' . self::getGuid();
    }

    public static function getGuid() {
        if (function_exists('com_create_guid')) {
            return com_create_guid();
        } else {
            mt_srand((double) microtime() * 10000); //optional for php 4.2.0 and up.
            $charid = strtoupper(md5(uniqid(rand(), true)));
            $hyphen = chr(45); // "-"
            $uuid = substr($charid, 0, 8) . $hyphen
                    . substr($charid, 8, 4) . $hyphen
                    . substr($charid, 12, 4) . $hyphen
                    . substr($charid, 16, 4) . $hyphen
                    . substr($charid, 20, 12);
            return $uuid;
        }
    }
    
    public static function toHex($data){
        return strtoupper(bin2hex($data));
    }
}
