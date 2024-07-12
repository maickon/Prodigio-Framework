<?php

namespace core;

class FileManager {

    protected $uploadDirectory;

    public function __construct($uploadDirectory) {
        $this->uploadDirectory = $uploadDirectory;
    }

    public function uploadFile($tmp_name, $newFileName = null) {
        $destination = $this->uploadDirectory . '/' . $newFileName;
    
        if (move_uploaded_file($tmp_name, $destination)) {
            return $destination;
        } else {
            echo "Arquivo nao existe! \n" . $destination . "\n" . $tmp_name;

        }

        return false;
    }

    public function getFileInfo($fileName) {
        $filePath = $this->uploadDirectory . '/' . $fileName;

        if (file_exists($filePath)) {
            return [
                'name' => $fileName,
                'size' => filesize($filePath),
                'path' => $filePath,
                'url'  => '/uploads/' . $fileName, // Modify as needed for your project
            ];
        }

        return null;
    }

    public function moveFile($currentFilePath, $destinationDirectory, $newFileName = null) {
        $fileName = $newFileName ? $newFileName : basename($currentFilePath);
        $destination = $destinationDirectory . '/' . $fileName;

        if (rename($currentFilePath, $destination)) {
            return $destination;
        }

        return false;
    }

    public function deleteFile($fileName) {
        $filePath = $this->uploadDirectory . '/' . $fileName;

        if (file_exists($filePath)) {
            unlink($filePath); // Exclui o arquivo do disco

            return true;
        }

        return false;
    }

    public function fileExists($fileName) {
        $filePath = $this->uploadDirectory . '/' . $fileName;
        return file_exists($filePath);
    }
}
