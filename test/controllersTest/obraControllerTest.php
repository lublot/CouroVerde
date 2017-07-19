<?php
require_once dirname(__FILE__).'/../../vendor/autoload.php';

use \PHPUnit\Framework\TestCase;
use \DAO\obraDAO as obraDAO;
use \controllers\obraController as obraController;
use \exceptions\CampoNoticiaInvalidoException as CampoNoticiaInvalidoException;
use \exceptions\DadosCorrompidosException as DadosCorrompidosException;
use \models\Obra as Obra;

class obraControllerTest extends TestCase {
    private $instancia;


    public function setUp(){
        $this->instancia = new obraController(); //obtém instancia do controller
    
        //remove todas as obras anteriormente cadastradas antes de realizar o teste
        $obraDAO = new obraDAO();
        $obraDAO->remover(array("1"=>"1"));
    }   

    /**
    * Testa a edição do nome de uma obra com sucesso;
    * @runInSeparateProcess
    * @preserveGlobalState disabled    
    */
    public function testEditarNomeObraSucesso(){
        $this->instancia->configurarAmbienteParaTeste(0, 'Obra 1','Couro 1', 'Função', 'Origem', 'Procedência', 'Descrição', 0, 0, 'Altura', 'Largura', 'Diâmetro', '10 quilos', '1 metro', 'Materiais', 'Técnicas', 'Autoria', 'Marcas', 'Histórico', 'Modo de Aquisição', 'Data de Aquisição', 'Autor', 'Observações', 'Estado');
        $this->instancia->cadastrarObra();

        $obraDAO = new obraDAO();
        $obra = $obraDAO->buscar(array(),array("nome"=> "Obra 1"));
        $numInventario = $obra[0]->getNumInventario();
        $this->assertEquals(1,count($obra));

        $novoNome = 'Mil Novecentos e Oitenta e Couro';
        $this->instancia->configurarAmbienteParaTeste($numInventario ,$novoNome,'Couro 1', 'Função', 'Origem', 'Procedência', 'Descrição', 0, 0, 'Altura', 'Largura', 'Diâmetro', '10 quilos', '1 metro', 'Materiais', 'Técnicas', 'Autoria', 'Marcas', 'Histórico', 'Modo de Aquisição', 'Data de Aquisição', 'Autor', 'Observações', 'Estado');
        $this->instancia->gerenciarObra();
        $obra = $obraDAO->buscar(array(),array("nome"=>$novoNome));
        $this->assertEquals(1,count($obra));
    }

    /**
    *Testa o cadastro de uma obra com sucesso
    * @runInSeparateProcess
    * @preserveGlobalState disabled 
    */
    public function testCadastrarObraSucesso(){
        $this->instancia->configurarAmbienteParaTeste(0, 'Obra 1','Couro 1', 'Função', 'Origem', 'Procedência', 'Descrição', 0, 0, 'Altura', 'Largura', 'Diâmetro', '10 quilos', '1 metro', 'Materiais', 'Técnicas', 'Autoria', 'Marcas', 'Histórico', 'Modo de Aquisição', 'Data de Aquisição', 'Autor', 'Observações', 'Estado');
        $this->instancia->cadastrarObra();

        $obraDAO = new obraDAO();
        $obra = $obraDAO->buscar(array(),array("nome"=> "Obra 1"));
        $obra->getNome().strcmp('Obra 1');
        


        $numInventario = $obra[0]->getNumInventario();
        $this->assertEquals(1,count($obra));
    }

}