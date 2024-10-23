<?php

namespace core;
use App\Views\ViewConfig;
use core\Router;

class View {

    private static $globalData = array();
    private $data = array();
    private $renderFile = FALSE;

    public function __construct() {
        $config = new ViewConfig();
        foreach($config->getViews() as $name => $view) {
            self::setGlobal($name, $view);
        }
    }

    public static function setGlobal($key, $value) {
        self::$globalData[$key] = $value;
    }

    public function render($template, $data) {
        $data = array_merge(self::$globalData, $data);
        try {
            $file = $this->getTemplatePath($template);
            
            if (file_exists($file)) {
                foreach ($data as $key => $value) {
                    $this->assign($key, $value);
                }
            } else {
                throw new \Exception('Template ' . $template . ' not found!');
            }
            $this->renderFile = $file;
        } catch (\Exception $e) {
            $this->renderFile = $e->getMessage();
        }
    }

    private function getTemplatePath($template) {
        $template = str_replace('\\', '/', strtolower($template));
        $parts = explode('/', $template);
        
        if (count($parts) > 1) {
            $file = implode(DIRECTORY_SEPARATOR, $parts) . '.php';
        } else {
            $file = $template . DIRECTORY_SEPARATOR . 'index.php';
        }
        
        return dirname(__DIR__) . DIRECTORY_SEPARATOR . PUBLIC_FOLDER_NAME . DIRECTORY_SEPARATOR . 'views' . DIRECTORY_SEPARATOR . $file;
    }

    public function assign($variable, $value) {
        $this->data[$variable] = $value;
    }

    public function __destruct() {

        $this->data['errors'] = SessionManager::getFlash('errors');
        $this->data['success'] = SessionManager::getFlash('success');
        $this->data['formdata'] = SessionManager::getFlash('formdata');
        
        if(!empty($this->data)) {
            extract($this->data);
        }
        if (file_exists($this->renderFile)) {
            include($this->renderFile);
        } else {
            Router::route(__DIR__ . '/../' . PUBLIC_FOLDER_NAME . '/views/error.php', [
                'error' => '404',
                'title' => 'Página não encontrada!',
                'message' => 'Desculpe, a página que você está procurando não existe ou foi movida.'
            ]);
            exit;
        }
    }
}
