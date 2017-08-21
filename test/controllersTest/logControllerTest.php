<?php
require_once dirname(__FILE__).'/../../vendor/autoload.php';

use \PHPUnit\Framework\TestCase;
use DAO\RelatorioSistemaDAO as RelatorioSistemaDAO;
use \controllers\LogController as LogController;
use \DAO\funcionarioDAO as funcionarioDAO;

class LogControllerTest extends TestCase {

    private $instancia;    

    public function setup(){
        $this->instancia = new LogController();
    }

    public function testRegistrarEventoSucesso(){
        $this->instancia->configuraAmbienteParaTeste("diegossl94@gmail.com");
        $this->instancia->registrarEvento("10", "FUNCIONARIO", "Um funcionário foi cadastrado");

        $relatorioSistemaDAO = new RelatorioSistemaDAO();
        $achou = $relatorioSistemaDAO->buscar(array(), array("matriculaFuncionario" => "15111215"));
        
        $this->assertEquals("10", $achou[0]->getIdAlvo());
        $this->assertEquals("FUNCIONARIO", $achou[0]->getTipoAlvo());
        $this->assertEquals("15111215", $achou[0]->getAutor());    
        $this->assertEquals("Um funcionário foi cadastrado", $achou[0]->getAcao());                
    }
}

?>