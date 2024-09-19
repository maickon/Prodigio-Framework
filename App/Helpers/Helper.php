<?php

namespace App\Helpers;
use core\ImageManager;
use core\FileManager;
use Exception;

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

    public function verifyPassword($password, $hashedPassword) {
        return password_verify($password, $hashedPassword);
    }

    public function saveFile($request, $path, $field) {
        $response = [];
        if (isset($request[$field]) && empty($request[$field]['full_path'][0])) {
            return false;
        }

        if (isset($request[$field]) && is_array($request[$field]['full_path'])) {
            foreach ($request[$field]['full_path'] as $key => $value) {
                $ext = pathinfo($request[$field]['full_path'][$key], PATHINFO_EXTENSION);
                $newfile_name = md5(uniqid(rand(), true)) . '.' . $ext;

                // Verifica o tipo de arquivo e realiza a operação adequada
                switch (true) {
                    // Tratamento para imagens
                    case preg_match('/(jpg|jpeg|png|gif)$/i', $ext):
                        $image = new ImageManager($request[$field]['tmp_name'][$key]);
                        $image->resize(500, 500); // Redimensiona imagens
                        $image->save($path . $newfile_name);
                        break;
                    
                    // Tratamento para arquivos PDF
                    case preg_match('/(pdf)$/i', $ext):
                        move_uploaded_file($request[$field]['tmp_name'][$key], $path . $newfile_name);
                        break;
                    
                    // Tratamento para arquivos de vídeo
                    case preg_match('/(mp4|avi|mov|wmv)$/i', $ext):
                        move_uploaded_file($request[$field]['tmp_name'][$key], $path . $newfile_name);
                        break;
                    
                    // Tratamento para arquivos de áudio
                    case preg_match('/(mp3|wav|ogg)$/i', $ext):
                        move_uploaded_file($request[$field]['tmp_name'][$key], $path . $newfile_name);
                        break;
                    
                    // Tratamento para documentos (Word, Excel, etc.)
                    case preg_match('/(doc|docx|xls|xlsx|txt)$/i', $ext):
                        move_uploaded_file($request[$field]['tmp_name'][$key], $path . $newfile_name);
                        break;

                    default:
                        // Tipo de arquivo desconhecido
                        throw new Exception('Tipo de arquivo não suportado: ' . $ext);
                }

                $response[] = $newfile_name;
            }
        } else {
            $ext = pathinfo($request[$field]['full_path'], PATHINFO_EXTENSION);
            $newfile_name = md5(uniqid(rand(), true)) . '.' . $ext;

            // Verifica o tipo de arquivo e realiza a operação adequada
            switch (true) {
                case preg_match('/(jpg|jpeg|png|gif)$/i', $ext):
                    $image = new ImageManager($request[$field]['tmp_name']);
                    $image->resize(500, 500);
                    $image->save($path . $newfile_name);
                    break;

                case preg_match('/(pdf)$/i', $ext):
                    move_uploaded_file($request[$field]['tmp_name'], $path . $newfile_name);
                    break;

                case preg_match('/(mp4|avi|mov|wmv)$/i', $ext):
                    move_uploaded_file($request[$field]['tmp_name'], $path . $newfile_name);
                    break;

                case preg_match('/(mp3|wav|ogg)$/i', $ext):
                    move_uploaded_file($request[$field]['tmp_name'], $path . $newfile_name);
                    break;

                case preg_match('/(doc|docx|xls|xlsx|txt)$/i', $ext):
                    move_uploaded_file($request[$field]['tmp_name'], $path . $newfile_name);
                    break;

                default:
                    throw new Exception('Tipo de arquivo não suportado: ' . $ext);
            }

            $response[] = $newfile_name;
        }

        return $response;
    }

	public function saveImage($request, $path, $field) {
        $response = [];
        if (isset($request[$field]) && is_array($request[$field]['full_path'])) {    
            foreach ($request[$field]['full_path'] as $key => $value) {
                $ext = pathinfo($request[$field]['full_path'][$key]);
                $newfile_name =  md5(uniqid(rand(), true)) . '.' . $ext['extension'];
                $image = new ImageManager($request[$field]['tmp_name'][$key]);
                $image->resize(500,500);
                $image->save($path . $newfile_name);
                $response[] = $newfile_name;
            }
        } else {
            $ext = pathinfo($request[$field]['full_path']);
            $newfile_name =  md5(uniqid(rand(), true)) . '.' . $ext['extension'];
            $image = new ImageManager($request[$field]['tmp_name']);
            $image->resize(500,500);
            $image->save($path . $newfile_name);
            $response[] = $newfile_name;
        }
        return $response;
    }

    public function deleteImages($item, $path, $field) {
        $file = new FileManager($path);
        $images = json_decode($item->$field);
        $response = false;
        foreach ($images as $image) {
            $response = $file->deleteFile($image);
        }
        return $response;
    }
}