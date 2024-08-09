<?php

namespace core;

class CacheControl {

    static function getBaseUrl() {
        $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? 'https' : 'http';
        $host = $_SERVER['HTTP_HOST'];
        return "$protocol://$host";
    }

    public static function setHeaders($fileType, $url) {
        $headers = headers_list();
        $set = false;

        foreach($headers as $header) {
            if (strpos($header, 'Cache-Control') !== false && strpos($header, $url) !== false) {
                $set = true;
                break;
            }
        }

        if (!$set) {
            $time = 3600;
            $expires = gmdate("D, d M Y H:i:s", time() + $time) . " GMT";
            $cacheControl = 'max-age='.$time.', public';

            header("Cache-Control: $cacheControl");
            header("Expires: $expires");
            header("X-Custom-URL: $url");

            if ($fileType != 'html') {
                header("Content-Type: $fileType");
            }
        }
    }

    public static function setAllHeaders($fileType, $urls) {
        foreach ($urls as $url) {
            self::setHeaders($fileType, $url);
        }
    }

    public static function getUrls($dir, $on_dir = false) {
        $path = __DIR__ . "/../public/" . $dir . "/*";
        $files = glob($path);
        $filesWithPrefix = array_map(function($file) use ($dir) {
            return self::getBaseUrl() . $dir . '/' . basename($file);
        }, $files);
        return $filesWithPrefix;
    }

    public static function clearCacheHeaders() {
        header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
        header("Cache-Control: post-check=0, pre-check=0", false);
        header("Pragma: no-cache");
        header("Expires: Fri, 01 Jan 1990 00:00:00 GMT");
    }

}
