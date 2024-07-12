<?php

class JsonFileManager {
    public static function create($filename, $data) {
        $json_data = json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
        file_put_contents($filename, $json_data);
    }
    
    public static function read($filename) {
        if (file_exists($filename)) {
            $json_data = file_get_contents($filename);
            $data = json_decode($json_data, true);
            return $data;
        } else {
            return false;
        }
    }
    
    public static function update($filename, $data) {
        self::create($filename, $data);
    }
    
    public static function delete($filename) {
        if (file_exists($filename)) {
            unlink($filename);
            return true;
        } else {
            return false;
        }
    }
}
