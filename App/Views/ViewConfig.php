<?php

namespace App\Views;

use core\TemplateTags;
use core\SessionManager;

class ViewConfig {
    
    private $public = [];

    public function __construct() {
        $this->public = [
            'html' => new TemplateTags(),
            'session' => SessionManager::all()
        ];
    }

    public function getViews() {
        return $this->public;
    }
}