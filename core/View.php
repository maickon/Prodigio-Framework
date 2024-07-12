<?php

namespace core;

class View {

    private $data = array();
    private $render = FALSE;

    public function render($template, $data)
    {
        try {
            $file = __DIR__ . '/../public/views/' . strtolower($template) . '/index.php';
            $parts = explode('/', strtolower($template));
            if(count($parts) > 1) {
                list($folder, $file) = $parts;
                $file = __DIR__ . '/../public/views/' . strtolower($folder) . '/' .$file . '.php';
            }
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

    public function assign($variable, $value)
    {
        $this->data[$variable] = $value;
    }

    public function __destruct()
    {
        if(!empty($this->data)) {
            extract($this->data);
        }
        include($this->render);
    }
}
