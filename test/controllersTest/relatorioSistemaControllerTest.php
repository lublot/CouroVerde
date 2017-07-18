<?php

require_once dirname(__FILE__).'/../../vendor/autoload.php';

use \PHPUnit\Framework\TestCase;
use \controllers\relatorioSistemaController as relatorioSistemaController;
use \models\RelatorioSistema as RelatorioSistema;
use \models\Pesquisa as Pesquisa;
use \DAO\PesquisaDAO as PesquisaDAO;
use \DAO\RelatorioSistemaDAO as RelatorioSistemaDAO;

if(!isset($_SESSION)){
    session_start();
}
class relatorioSistemaControllerTest extends TestCase {

    private $instancia;

    public function setup(){
        $this->instancia = new RelatorioSistemaController();
    }

    public function testListarTodosRelatoriosComSucesso(){
        //$this->instancia->configurarAmbienteParaTeste();
    
        $_SESSION['matricula'] = "1";
        $idAutor = $_SESSION['matricula'];

        $pesquisa = new Pesquisa(null, "Couro Vermelho", "1");
        $pesquisaDAO = new PesquisaDAO();
        $pesquisaDAO->inserir($pesquisa);
        $pesquisaEncontrada = $pesquisaDAO->buscar(array("idPesquisa"), array("titulo" => "Couro Vermelho"));
        $idAlvo = $pesquisaEncontrada[0]->getIdPesquisa();

        $relatorioSistema = new RelatorioSistema($idAutor, "Cadastrar pesquisa", $idAlvo, "OBRA");
        $relatorioSistemaDAO = new RelatorioSistemaDAO();
        $relatorioSistemaDAO->inserir($relatorioSistema);
        $relatorios = $this->instancia->listarTodosRelatorios();

        $this->assertEquals(1, count($relatorios));
    }
}

?>