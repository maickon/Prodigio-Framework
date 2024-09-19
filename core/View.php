<?php

namespace core;

class View {

    private $data = array();
    private $render = FALSE;

    public function render($template, $data) {
        try {
            $file = $this->getTemplatePath($template);
            
            if (file_exists($file)) {
                foreach ($data as $key => $value) {
                    $this->assign($key, $value);
                }
            } else {
                throw new \Exception('Template ' . $template . ' not found!');
            }
            $this->render = $file;
        } catch (\Exception $e) {
            echo $e->getMessage();
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
        if (file_exists($this->render)) {
            include($this->render);
        } else {
            exit('<h1>Pagina nao encontrada</h1>');
        }
    }
}
