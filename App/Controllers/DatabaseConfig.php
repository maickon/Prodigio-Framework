<?php

namespace App\Controllers;

use core\Controller;
use core\DatabaseSchema;
use core\Connection;

class DatabaseConfig extends Controller {

	private $conn;
	
	public function __construct() {
		$this->conn = new Connection();
	}

	public function index() {
		$administrators = array(
		    'administrators' => array(
		        'id' => 'INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY',
		        'fullname' => 'VARCHAR(255) NOT NULL',
		        'email' => 'VARCHAR(255) NOT NULL UNIQUE',
		        'password' => 'VARCHAR(255) NOT NULL',
		        'created_at' => 'TIMESTAMP DEFAULT CURRENT_TIMESTAMP'
		    )
		);

		$tables = [
			$administrators
		];

		$responses = [];

		foreach ($tables as $key => $table) {
			$db_schema_user = new DatabaseSchema($table, $this->conn);
			$responses[] = $db_schema_user->createTables();
		}

		$this->view('database', [
			'responses' => $responses
		]);
	}	
}