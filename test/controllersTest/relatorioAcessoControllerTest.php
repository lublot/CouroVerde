<?php

require_once dirname(__FILE__).'/../../vendor/autoload.php';
use \PHPUnit\Framework\TestCase;
use \models\RegistroVisitasObra as registroVisitasObra;
use \DAO\usuarioAcessoDAO as usuarioAcessoDAO;
use \models\Obra as Obra;
use \DAO\obraDAO as obraDAO;
use \controllers\relatorioAcessoController as relatorioAcessoController;


class relatorioAcessoControllerTest extends TestCase {

    private $instancia;

    public function setup(){
        $this->instancia = new relatorioAcessoController();
    }

    public function testGerarRelatorio() {
        $this->instancia->gerarRelatorioAcesso();
    }


}

?>