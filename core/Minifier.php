<?php

namespace core;

use config\Minify;

class Minifier {

    private $sourcePath;
    private $targetPath;

    public function __construct($filetype) {
        
        $config = new Minify;

        switch ($filetype) {
            case 'css':
                $this->sourcePath = rtrim($config->originCssPath, '/') . '/';
                $this->targetPath = rtrim($config->targetCssPath, '/') . '/';
                break;
            
            case 'js':
                $this->sourcePath = rtrim($config->originJsPath, '/') . '/';
                $this->targetPath = rtrim($config->targetJsPath, '/') . '/';
                break;
        }

        $this->minify($filetype);
    }

    public function minify($fileType) {
        $files = glob($this->sourcePath . '*.' . $fileType);
        foreach ($files as $file) {
            $fileName = basename($file);
            $targetFile = $this->targetPath . $fileName;

            if ($this->needsMinification($file, $targetFile)) {
                $minifiedContent = $this->minifyContent(file_get_contents($file), $fileType);
                file_put_contents($targetFile, $minifiedContent);
            }
        }
    }

    private function needsMinification($sourceFile, $targetFile) {
        if (!file_exists($targetFile)) {
            return true;
        }

        $sourceContent = file_get_contents($sourceFile);
        $targetContent = file_get_contents($targetFile);

        $minifiedSourceContent = $this->minifyContent($sourceContent, pathinfo($sourceFile, PATHINFO_EXTENSION));

        return $minifiedSourceContent !== $targetContent;
    }

    private function minifyContent($content, $fileType) {
        if ($fileType === 'css') {
            return $this->minifyCSS($content);
        } elseif ($fileType === 'js') {
            return $this->minifyJS($content);
        }
        return $content;
    }

    private function minifyCSS($content) {
        $content = preg_replace('!/\*.*?\*/!s', '', $content);
        $content = preg_replace('/\n\s*\n/', "\n", $content);
        $content = preg_replace('/[\n\r \t]/', ' ', $content);
        $content = preg_replace('/ +/', ' ', $content);
        $content = preg_replace('/ ?([,:;{}]) ?/', '$1', $content);
        $content = preg_replace('/;}/', '}', $content);
        return trim($content);
    }

    private function minifyJS($content) {
        $content = preg_replace('!/\*[^*]*\*+([^/][^*]*\*+)*/!', '', $content);
        $content = preg_replace('/\/\/[^\n\r]*[\n\r]/', '', $content);
        $content = preg_replace('/[^\S\n]+/', ' ', $content);
        $content = preg_replace('/\s*([\+\-])\s*/', '$1', $content);
        $content = preg_replace('/^\s+|\s+$/m', '', $content);
        $content = preg_replace('/;}/', '}', $content);       
        $content = preg_replace('/^\n*/m', '', $content);
        return $content;
    }
}