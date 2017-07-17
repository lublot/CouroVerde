<?php

require_once dirname(__FILE__).'/../../vendor/autoload.php';

use \PHPUnit\Framework\TestCase;
use \controllers\relatorioSistemaController as relatorioSistemaController;

class relatorioSistemaControllerTest extends TestCase {

      public function setup(){
        $this->instanciaPesquisa = new pesquisaController();
    }

    public function listarTodosRelatoriosComSucesso(){
        
    }
}

?>