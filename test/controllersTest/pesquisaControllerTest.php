<?php
require_once dirname(__FILE__).'/../../vendor/autoload.php';

use \PHPUnit\Framework\TestCase;
use \DAO\PesquisaDAO as PesquisaDAO;
use \DAO\PerguntaDAO as PerguntaDAO;
use \controllers\pesquisaController as pesquisaController;
use \models\Pesquisa as Pesquisa;

class PesquisaControllerTest extends TestCase {

 private $instanciaPesquisa;

    public function setup(){
        $this->instanciaPesquisa = new pesquisaController();

        //remove todas as pesquisas anteriormente cadastradas antes de realizar o teste
        $pesquisaDAO = new PesquisaDAO();
        $pesquisaDAO->remover(array());        
    }

    public function testCriarPesquisaComSucesso(){
        $this->instanciaPesquisa->configuraAmbienteParaTeste("Qualidade das obras", "1", "Qual nivel de qualidade?", "0", "ABERTA");
       
        $this->instanciaPesquisa->criarPesquisa();
        $this->instanciaPesquisa->criarPergunta();
        //$this->instanciaPesquisa->criarOpcao();

        $pesquisaDAO = new PesquisaDAO();
        $pesquisas = $pesquisaDAO->buscar(
            array(),
            array("titulo" => "Qualidade das obras", "estaAtiva" => "1")
        );
        
        $perguntaDAO = new PerguntaDAO();
        $perguntas = $perguntaDAO->buscar(
            array(),
            array("titulo" => "Qual nivel de qualidade?", "opcional" => "0", "ABERTA")
        );

        $this->assertEquals(1, count($pesquisas));
        $this->assertEquals(1, count($perguntas));
    }
}

?>