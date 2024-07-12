<?php

namespace core;

class ImageManager {

    protected $image;

    public function __construct($imagePath) {
        $this->image = imagecreatefromstring(file_get_contents($imagePath));
    }

    public function resize($newWidth, $newHeight) {
        $width = imagesx($this->image);
        $height = imagesy($this->image);

        $newImage = imagecreatetruecolor($newWidth, $newHeight);

        imagecopyresampled($newImage, $this->image, 0, 0, 0, 0, $newWidth, $newHeight, $width, $height);

        $this->image = $newImage;
    }

    public function save($outputPath, $quality = 90) {
        return imagejpeg($this->image, $outputPath, $quality);
    }

    public function output($quality = 90) {
        header('Content-Type: image/jpeg');
        imagejpeg($this->image, null, $quality);
    }

    public function destroy() {
        imagedestroy($this->image);
    }
}
