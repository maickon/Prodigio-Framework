<?php

namespace App\Helpers;

class Helper {

    public function curlRequest($url, $headers = null, $data = null) {
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        if ($headers) {
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        }
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_TIMEOUT, 10);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        if($data != null) {
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
        }
        return curl_exec($ch);
    }

	public function generateHash($password) {
	    $options = ['cost' => 12];
	    return password_hash($password, PASSWORD_BCRYPT, $options);
	}

	public function saveImage($request, $path, $field) {
        $response = [];
        if (isset($request[$field]) && is_array($request[$field]['full_path'])) {    
            foreach ($request[$field]['full_path'] as $key => $value) {
                $ext = pathinfo($request[$field]['full_path'][$key]);
                $newfile_name =  md5(uniqid(rand(), true)) . '.' . $ext['extension'];
                $image = new ImageManager($request[$field]['tmp_name'][$key]);
                $image->resize(500,500);
                $image->save(__DIR__ . $path . $newfile_name);
                $response[] = $newfile_name;
            }
        } else {
            $ext = pathinfo($request[$field]['full_path']);
            $newfile_name =  md5(uniqid(rand(), true)) . '.' . $ext['extension'];
            $image = new ImageManager($request[$field]['tmp_name']);
            $image->resize(500,500);
            $image->save(__DIR__ . $path . $newfile_name);
            $response[] = $newfile_name;
        }
        return $response;
    }

    public function deleteImages($item, $path, $field) {
        $file = new FileManager(__DIR__ . $path);
        $images = explode(',', $item[$field]);
        $response = false;
        foreach ($images as $image) {
            $response = $file->deleteFile($image);
        }
        return $response;
    }
}