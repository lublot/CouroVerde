<?php
require_once dirname(__FILE__).'/../../vendor/autoload.php';

use \PHPUnit\Framework\TestCase;
use \DAO\PesquisaDAO as PesquisaDAO;
use \controllers\pesquisaController as pesquisaController;
use \models\Pesquisa as Pesquisa;

class PesquisaControllerTest extends TestCase {

 private $instanciaPesquisa;

    public function setup(){
        $this->instanciaPesquisa = new pesquisaController();
    }

    public function testCriarPesquisaComSucesso(){

    }
}

?>