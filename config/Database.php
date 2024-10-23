<?php

namespace config;

class Database {

	private $rootURL = 'localhost';

	public $host = 'localhost';
    public $db_name = 'pedidos';
    public $username = 'root';
    public $password = 'root';

    public function __construct() {
    	if ($_SERVER['HTTP_HOST'] === $this->rootURL) {
		    $this->db_name = 'pedidos';
		    $this->username = 'root';
		    $this->password = 'root';
		}
    }
}