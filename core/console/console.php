<?php


class Console_Core{

	function __construct(){
		$this->run();
	}

	function run(){
		readline_completion_function(function(){
			$comandos = [
				'help',
				'new model::',
				'new controller::',
				'new view::',
				'del model::',
				'del controller::',
				'del view::',
				'new scaffold::',
				'new migrate::',
				'new formview::',
				'varchar',
				'integer',
				'decimal',
				'crud',
				'function',
				'text',
				'timestamp'
			];
			return $comandos;
		});
		do{
			$op = readline('[ProdigioFramework]>> ');
			if ($op != 'exit') {
				$this->menu($op);
			}
		} while($op != 'exit');
	}

	function menu($option){
		$actions = [
		'help' 					=> 'help',	
		'new model'				=> 'new_model',
		'new controller'		=> 'new_controller',
		'new view'				=> 'new_view',

		'del model'				=> 'del_model',
		'del controller'		=> 'del_controller',
		'del view'				=> 'del_view',
		
		'new scaffold' 			=> 'scaffold',
		'new migrate' 			=> 'migrate',

		'new formview' 			=> 'new_form_view',
		];

		$comand = explode('::', $option);
		if (!isset($actions[$comand[0]])) {
		} else {
			if ($option == 'help') {
				$this->help();
			} else {
				$method = $actions[$comand[0]];
				$this->$method($comand[1]);
			}
		}
	}

	function migrate($params){
		$data_model = explode(" ", $params);
		$model_name = $data_model[0];
		unset($data_model[0]);
		$fields = $data_model;
		$table = new StdClass;
		$table->table_name = strtolower($model_name);

		foreach ($fields as $key => $value) {
			$field = explode(':', $value);
			$field_name = $field[0];  
			$field_type = $field[1];
			$table->$field_name = $field_type; 
		}

		$db 	= new Dbcreate_Core;
		
		if ($db->__createTable($table)) {
			echo("[OK!]Tabela {$table->table_name} criada com sucesso!");
		} else {
			echo("[FALHA!]Tabela {$table->table_name} não foi criada!");
		}
		
		// if ($build->build_schema($table)) {
		// 	echo("\n[OK!]Arquivo {$table->table_name}.xml atualizado com sucesso!");
		// } else {
		// 	echo("\n[FALHA!]Arquivo {$table->table_name}.xml não atualizado!");
		// }
		system("PAUSE");
	}
	
	function new_model($params){
		$data_model = explode(" ", $params);
		$model_name = $data_model[0];
		unset($data_model[0]);
		$fields = $data_model;
		$table = new StdClass;
		$table->table_name = strtolower($model_name);

		foreach ($fields as $key => $value) {
			$field = explode(':', $value);
			$field_name = $field[0];  
			$field_type = $field[1];
			$table->$field_name = $field_type; 
		}

		$build 	= new Build_Core;

		if ($build->build_model($table)) {
			echo("\n[OK!]Arquivo {$table->table_name}.php atualizado com sucesso!");
		} else {
			echo("\n[FALHA!]Arquivo {$table->table_name}.php não atualizado!");
		}
		system("PAUSE");
	}

	// Ex: new controller::Livros function:calcular_frete()

	function new_controller($params){
		$data_controller = explode(" ", $params);
		$controller_name = $data_controller[0];
		unset($data_controller[0]);
		$methods = $data_controller;

		$controller = new StdClass;
		$controller->class_name = lcfirst($controller_name);

		foreach ($methods as $key => $value) {
			if ($value == 'crud:ok') {
				$controller->index 	= 'index()';
				$controller->create = 'create()';
				$controller->update = 'update()';
				$controller->delete = 'delete()';
			} else {
				$method = explode(':', $value);
				if (count($method) == 1) {
					echo("\n[FALHA!]Declaração de função errada. Use : após function.");
					break;
				} else {
					$method_name 						= $method[1];
					if (strpos($method_name, '()')) {
						$method_atribute_name			= substr($method_name, 0, -2);		
					} else {
						$method_atribute_name			= $method_name;
						$method_name = "{$method_name}()";
					}	
					
					$controller->$method_atribute_name 	= $method_name;
					echo $method_atribute_name.' - '.$method_name; 
				}
			}
		}

		$build = new Build_Core;
		if($build->build_controller($controller)){
			echo("\n[OK!]Arquivo {$controller->class_name}.php atualizado com sucesso!");
		} else {
			echo("\n[FALHA!]Arquivo {$controller->class_name}.php não atualizado!");
		}
		system("PAUSE\n");
	}

	function new_view($params){
		$data_view = explode("::", $params);
		$methods = get_class_methods("{$data_view[0]}_Controller");

		if (empty($methods)) {
			echo("\n[FALHA!]Controller não existe! Não é possível criar a view.");
		} else {
			$controller_methods = [
			'check_session','set_css','set_base_css','set_base_js','set_js','render','content','load_labels','redirect','error',
			'__construct'];
			$view_methods = [];
			foreach ($methods as $key => $value) {
				if (!in_array($value, $controller_methods)) {
					$view_methods[] = $value;
				}
			}
		
			$build = new Build_Core;
			$data_view[0] = strtolower($data_view[0]);
			if($build->build_view($view_methods, $data_view[0])){
				echo("\n[OK!]Todos os arquivos da view foram atualizado com sucesso!");
			} else {
				echo("\n[FALHA!]Arquivo de view não atualizado!");
			}
		}
		system("PAUSE");
	}

	function new_form_view($params){
		$data_view = explode(" ", $params);
		$view_name = $data_view[0];
		unset($data_view[0]);
		$file_name = $data_view[1];
		unset($data_view[1]);
		$fields = $data_view;
		$form = new StdClass;
		$form->form_name = strtolower($view_name);
		$form->file_name = strtolower($file_name);

		foreach ($fields as $key => $value) {
			$field = explode(':', $value);
			$field_name = $field[0];  
			$field_type = $field[1];
			$form->$field_name = $field_type; 
		}

		$build 	= new Build_Core;

		if ($build->build_form($form)) {
			echo("\n[OK!]Formulario adicionado a {$form->form_name}.phtml com sucesso!");
		} else {
			echo("\n[FALHA!]Formulario não adicionado a {$form->form_name}.phtml!");
		}
		system("PAUSE");
	}

	function del_model($params){
		$data_model = explode("::", $params);		
		$data_model = explode(' ', $data_model[0]);
		if (count($data_model) > 1) {
			foreach ($data_model as $key => $value) {
				$value = strtolower($value);
				if (file_exists(PATH_BASE."app/models/{$value}.php")) {
					if(unlink(PATH_BASE."app/models/{$value}.php")) {
						echo("\n[OK!]Arquivo {$value}.php apagado com sucesso!");
					} else {
						echo("\n[FALHA!]Arquivo {$value}.php não apagado!");
					}
				} else {
					echo("\n[FALHA!]Arquivo {$value}.php não existe!");
				}
			}
		} else {
			$file = strtolower($data_model[0]);
			if (file_exists(PATH_BASE."app/models/{$file}.php")) {
				if(unlink(PATH_BASE."app/models/{$file}.php")){
					echo("\n[OK!]Arquivo {$file}.php apagado com sucesso!");
				} else {
					echo("\n[FALHA!]Arquivo {$file}.php não foi apagado!");
				}
			} else {
				echo("\n[FALHA!]Arquivo {$file}.php não existe!");
			}

		}
		system("PAUSE");
	}

	function del_controller($params){
		$data_controller = explode("::", $params);		
		$data_controller = explode(' ', $data_controller[0]);
		if (count($data_controller) > 1) {
			foreach ($data_controller as $key => $value) {
				$value = strtolower($value);
				if (file_exists(PATH_BASE."app/controllers/{$value}.php")) {
					if(unlink(PATH_BASE."app/controllers/{$value}.php")) {
						echo("\n[OK!]Arquivo {$value}.php apagado com sucesso!");
					} else {
						echo("\n[FALHA!]Arquivo {$value}.php não apagado!");
					}
				} else {
					echo("\n[FALHA!]Arquivo {$value}.php não existe!");
				}
			}
		} else {
			$file = strtolower($data_controller[0]);
			if (file_exists(PATH_BASE."app/controllers/{$file}.php")) {
				if(unlink(PATH_BASE."app/controllers/{$file}.php")){
					echo("\n[OK!]Arquivo {$file}.php apagado com sucesso!");
				} else {
					echo("\n[FALHA!]Arquivo {$file}.php não foi apagado!");
				}
			} else {
				echo("\n[FALHA!]Arquivo {$file}.php não existe!");
			}

		}
		system("PAUSE");
	}

	function del_view($params){
		$data_model = explode("::", $params);		
		$data_model = explode(' ', $data_model[0]);
		if (count($data_model) > 1) {
			$view = $data_model[0]; 
			unset($data_model[0]);
			$flag = false;
			foreach ($data_model as $key => $value) {
				$value = strtolower($value);
				if (file_exists(PATH_BASE."app/views/{$view}/{$value}.phtml")) {
					if(unlink(PATH_BASE."app/views/{$view}/{$value}.phtml")){
						$flag = true;
					} else {
						echo("\n[FALHA!]Arquivo {$value} nao apagado!");
					}
				} else {
					echo("\n[FALHA!]Arquivo {$value} nao existe!");
				}
			}
			
			if($flag){
				echo("\n[OK!]Arquivos apagados com sucesso!");
			}
		} else {
			$file = strtolower($data_model[0]);
			if (file_exists(PATH_BASE."app/views/{$file}/")) {
				if($this->obliterate_directory(PATH_BASE."app/views/{$file}/")){
					echo("\n[OK!]Pasta {$file}/ apagado com sucesso!");
				} else {
					echo("\n[FALHA!]Pasta {$file}/ nao foi apagado!");
				}
			} else {
				echo("\n[FALHA!]Pasta {$file}/ nao existe!");
			}

		}
		system("PAUSE");
	}

	function help(){
		echo file_get_contents(PATH_BASE."core/console/arquivos/help.txt");
		system("PAUSE");
	}

	function obliterate_directory($dir) {
		$iter = new RecursiveDirectoryIterator($dir);
		foreach (new RecursiveIteratorIterator($iter,
			RecursiveIteratorIterator::CHILD_FIRST) as $f) {
			if ($f->isDir()) {
				@rmdir($f->getPathname());
			} else {
				unlink($f->getPathname());
			}
		}
		if (rmdir($dir)) {
			return true;
		} else {
			return false;
		}
	}
}