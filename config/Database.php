<?php

namespace config;

class Database {

	private $rootURL = 'localhost';

	public $host = 'localhost';
    public $db_name = 'pdgfw';
    public $username = 'root';
    public $password = 'root';

    public function __construct() {
    	if ($_SERVER['HTTP_HOST'] === $this->rootURL) {
		    $this->db_name = 'dbname';
		    $this->username = 'username';
		    $this->password = 'password';
		}
    }
}