<?php

namespace App\Controllers;

use core\Controller;
use core\DatabaseSchema;
use core\Connection;
use App\Models\FakeDatabase;

class DatabaseConfig extends Controller {

	private $conn;
	private $tables = [];

	public function __construct() {
		parent::__construct();
		$this->conn = new Connection();
		$this->clearDatabase();
	}

	public function clearDatabase() {
		$this->clearFolder(__DIR__ . '/../../'. PUBLIC_FOLDER_NAME .'/uploads/', ['image.jpg', 'image.png']);
	}

	private function clearFolder($folderPath, $excludeFiles) {
		if (is_dir($folderPath)) {
			$files = scandir($folderPath);
			foreach ($files as $file) {
				if ($file != "." && $file != ".." && !in_array($file, $excludeFiles)) {
					unlink($folderPath . '/' . $file);
				}
			}
		} else {
			echo "O diretório $folderPath não existe.<br>";
		}
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

		$clients = array(
			'clients' => array(
				'id' => 'INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY',
				'name' => 'VARCHAR(255) NOT NULL',
				'cpf_cnpj' => 'VARCHAR(20) NOT NULL',
				'birth_date' => 'DATE NOT NULL',
				'gender' => 'VARCHAR(255) NOT NULL',
				'whatsapp' => 'VARCHAR(30)',
				'phone' => 'VARCHAR(30)',
				'email' => 'VARCHAR(255) NOT NULL UNIQUE',
		        'password' => 'VARCHAR(255) NOT NULL',
				'address' => 'VARCHAR(255)',
				'complement' => 'VARCHAR(255)',
				'neighborhood' => 'VARCHAR(100)',
				'city' => 'VARCHAR(100)',
				'state' => 'VARCHAR(100)',
				'zip_code' => 'VARCHAR(15)',
				'status' => 'VARCHAR(30)',
				'created_at' => 'TIMESTAMP DEFAULT CURRENT_TIMESTAMP'
			)
		);

		$names = array(
			'names' => array(
				'id' => 'INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY',
				'name' => 'VARCHAR(255) NOT NULL',
				'created_at' => 'TIMESTAMP DEFAULT CURRENT_TIMESTAMP'
			)
		);

		$categories = array(
			'categories' => array(
				'id' => 'INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY',
				'name' => 'VARCHAR(255) NOT NULL',
				'created_at' => 'TIMESTAMP DEFAULT CURRENT_TIMESTAMP'
			)
		);

		$colors = array(
			'colors' => array(
				'id' => 'INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY',
				'name' => 'VARCHAR(255) NOT NULL',
				'created_at' => 'TIMESTAMP DEFAULT CURRENT_TIMESTAMP'
			)
		);

		$sizes = array(
			'sizes' => array(
				'id' => 'INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY',
				'category_id' => 'INT(11) UNSIGNED',
				'name' => 'VARCHAR(80) NOT NULL',
				'created_at' => 'TIMESTAMP DEFAULT CURRENT_TIMESTAMP',
				'FOREIGN KEY' => ' (category_id) REFERENCES categories(id) ON DELETE CASCADE'
			)
		);

		$fees = array(
			'fees' => array(
				'id' => 'INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY',
				'name' => 'VARCHAR(255) NOT NULL',
				'cnpj_fee' => 'DECIMAL(10, 2) NOT NULL',
				'icms_fee' => 'DECIMAL(10, 2) NOT NULL',
				'advisory_fee' => 'DECIMAL(10, 2) NOT NULL',
				'created_at' => 'TIMESTAMP DEFAULT CURRENT_TIMESTAMP'
			)
		);

		$brands = array(
			'brands' => array(
				'id' => 'INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY',
				'fee_id' => 'INT(11) UNSIGNED',
				'name' => 'VARCHAR(255) NOT NULL',
				'created_at' => 'TIMESTAMP DEFAULT CURRENT_TIMESTAMP',
				'FOREIGN KEY' => ' (fee_id) REFERENCES fees(id) ON DELETE CASCADE'
			)
		);

		$orders = array(
			'orders' => array(
				'id' => 'INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY',
				'client_id' => 'INT(11) UNSIGNED',
				'name_id' => 'INT(11) UNSIGNED',
				'brand_id' => 'INT(11) UNSIGNED',
				'size_id' => 'INT(11) UNSIGNED',
				'color_id' => 'INT(11) UNSIGNED',
				'status' => 'VARCHAR(255)',
				'shipping_type' => 'VARCHAR(255)',
				'shipping_cost' => 'DECIMAL(10, 2)',
				'product_code' => 'VARCHAR(50)',
				'quantity' => 'INT(11)',
				'price' => 'DECIMAL(10, 2)',
				'photo' => 'VARCHAR(255)',
				'created_at' => 'TIMESTAMP DEFAULT CURRENT_TIMESTAMP',
				// Adicionando chaves estrangeiras
				'FOREIGN KEY' => ' (client_id) REFERENCES clients(id) ON DELETE CASCADE',
				'FOREIGN KEY' => ' (name_id) REFERENCES names(id) ON DELETE CASCADE',
				'FOREIGN KEY' => ' (brand_id) REFERENCES brands(id) ON DELETE CASCADE',
				'FOREIGN KEY' => ' (size_id) REFERENCES sizes(id) ON DELETE CASCADE',
				'FOREIGN KEY' => ' (color_id) REFERENCES colors(id) ON DELETE CASCADE'
			)
		);

		$this->tables = [
			$administrators,
			$clients,
			$names,
			$categories,
			$colors,
			$sizes,
			$fees,
			$brands,
			$orders
		];

		$responses = [];

		foreach ($this->tables as $key => $table) {
			$db_schema_user = new DatabaseSchema($table, $this->conn);
			$responses[] = $db_schema_user->createTables();
		}

		$this->view('database', [
			'responses' => $responses,
			'fakeData' => $this->insertData()
		]);
	}

	private function insertData() {
		$fakeDatabase = new FakeDatabase();
		$responses = [];
		foreach ($fakeDatabase->data as $datatabales) {
			foreach ($datatabales as $tableRegister) {
				$dbSchema = new DatabaseSchema($this->tables, $this->conn);
				$response = $dbSchema->insertData($tableRegister['table'], $tableRegister['data']);
				if ($response) {
					$responses[] = "Dados fake da tabela {$tableRegister['table']} inserido com sucesso!";
				} else {
					$responses[] = "Houve um problema ao inserir dados da tabela {$tableRegister['table']}.";
				}
			}
		}
		return $responses;
	}
}