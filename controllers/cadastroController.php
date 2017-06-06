<?php

class cadastroController{

    private $array_teste = array("campo1" => "valor1");//Como a gnt não tem view ainda, vamos testando as informações nesse array


    public function index(){
        echo "Ola ".$this->array_teste['campo1'];
    }
}
?>