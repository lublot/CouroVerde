<?php


	/*

	Este arquivo contém o código responsável por importar(ler sobre spl_autoload) as classes necessárias durante a execução do sistema

	*/

	//Importar e instanciar a "main" do sistema
	//Iniciar execução do sistema

	if (! defined('ABSPATH')) {// Se o caminho do arquivo não estiver definido
		exit;
	}

	if(defined('DEBUG') || DEBUG === true){//True se estiver em ambiente de desenvolvimento/teste, False em ambiente de execução
		error_reporting(E_ALL);
		ini_set("display_errors",1);
	}

	spl_autoload_register(function($class){//Importa as classes automaticamente
			if(strpos($class,"Controller") > -1){
				if(file_exists(ABSPATH .'/controllers/'.$class.'.php')){
					require_once(ABSPATH .'/controllers/'.$class.'.php');
				}
			}
			else if(strpos($class,"DAO") > -1){
				if(file_exists(ABSPATH .'/DAO/'.$class.'.php')){
					require_once(ABSPATH .'/DAO/'.$class.'.php');
				}
			}
			else if(file_exists(ABSPATH .'/models/'.$class.'.php')){
				require_once(ABSPATH.'/models/'.$class.'.php');
			}
			else{
				require_once(ABSPATH.'/autoloader.php');
				require_once ABSPATH.'/Core.php';
			}
	});  

	//require_once ABSPATH . '/functions/global-functions.php';

	$controller = new Core();
	$controller->run();
?>