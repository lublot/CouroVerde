<?php
require_once __DIR__.'/vendor/autoload.php';

use \controllers\homeController;
use \controllers\cadastroController;
use \controllers\loginController;


class Core{

    private $controller;
    private $metodo;
    private $parametros;


    public function run() {
        $path = explode("index.php",$_SERVER['PHP_SELF']);// Divide a string da url
        $path = end($path);//Pega o final do array
        
        if(!empty($path)){//Verifica se contém algo
            $path = explode('/',$path);//Divide a string onde tem '/'
            array_shift($path);//Retira o primeiro elemento do array
            
            $this->controller = 'controllers\\'.$path[0].'Controller';//Concatena a palavra com "Controller" e seta o controller atual
            array_shift($path);//Retira o primeiro elemento do array
            
            if(isset($path[0]) && !empty($path[0])){ // Verifica se o array contém algo
                $this->metodo = $path[0];//Seta o método a ser executado pelo controller atual
                array_shift($path);//Retira o primeiro elemento do array
            }

            //Tratamento para parametros GET
            while(isset($path[0]) && !empty($path[0])){//Enquanto houverem elementos no array da url, são definidos como parametros
                $this->parametros[] = $path[0];
                array_shift($path);
            }


            //Tratamento para parametros POST 
            if(isset($_POST) && !empty($_POST)){//Verifica se a variável global foi setada e se tem conteúdo
                $this->parametros[] = $_POST;
            }
        } else {//Define o controller principal caso nenhum outro tenha sido escolhido
            $this->controller = "controllers\homeController";
            $this->metodo = "index";
            
        }
        
        if(isset($this->controller) && !empty($this->controller)){//Verifica se tudo foi definido corretamente
            if(isset($this->metodo) && !empty($this->metodo)){
                $metodo = $this->metodo;
            }else{
                $metodo = "index";
            }

            if(!isset($this->parametros) || empty($this->parametros)){
                $this->parametros = array();
            }

            $c = new $this->controller();//Instancia o controller desejado
            $c->$metodo($this->parametros);//Chama o metodo desejado
        }
       // call_user_func_array(array($c, $this->metodo), $this->parametros);
        
        
    }
}

?>