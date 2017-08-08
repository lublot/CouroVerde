<?php
require_once dirname(__FILE__).'/../../vendor/autoload.php';

use \PHPUnit\Framework\TestCase;
use \DAO\obraDAO as obraDAO;
use \controllers\obraController as obraController;
use \exceptions\CampoInvalidoException as CampoInvalidoException;
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

    /*
    *Testa o cadastro de uma coleção com sucesso;
    * @runInSeparateProcess
    * @preserveGlobalState disabled 
    
    public function testCadastrarColecaoSucesso() {
        //A FAZER
    } */

    /*
    *Testa o cadastro de uma classificação com sucesso;
    * @runInSeparateProcess
    * @preserveGlobalState disabled 
    
    public function testCadastrarClassificacaoSucesso() {
        //A FAZER
    }*/   
    
    /**
    *Testa o cadastro de uma obra com sucesso;
    * @runInSeparateProcess
    * @preserveGlobalState disabled 
    */
    public function testCadastrarObraSucesso(){
        $this->instancia->configurarAmbienteParaTeste(0, "Obra 1", "Couro 1", "Função", "Origem", "Procedência", "Descrição", 0, 0, 100.1, 100.1, 100.1, 100.1, 100.1, "Materiais", "Técnicas", "Autoria", "Marcas", "Histórico", "Modo de Aquisição", "2017-08-02", "Autor", "Observações", "Estado");
        $this->instancia->cadastrarObra();

        $obraDAO = new obraDAO();
        $obra = $obraDAO->buscar(array(),array("nome"=> "Obra 1"));
        $obra->getNome().strcmp('Obra 1');
        


        $numInventario = $obra[0]->getNumInventario();
        $this->assertEquals(1,count($obra));
    }

    /**
    *Testa o cadastro de uma obra com erro;
    * @runInSeparateProcess
    * @preserveGlobalState disabled 
    */
    public function testCadastrarObraErro() {
        $this->instancia->configurarAmbienteParaTeste(0, null, "Couro 1", "Função", "Origem", "Procedência", "Descrição", 0, 0, 100.1, 100.1, 100.1, 100.1, 100.1, "Materiais", "Técnicas", "Autoria", "Marcas", "Histórico", "Modo de Aquisição", "2017-08-02", "Autor", "Observações", "Estado");
        $this->expectException(CampoInvalidoException::class); //exceção esperada 
        $this->instancia->cadastrarObra();
    }

    /**
    *Testa o cadastro de uma obra com erro com dados corrompidos;
    * @runInSeparateProcess
    * @preserveGlobalState disabled 
    */
    public function testCadastrarObraDadosCorrompidos() {
        $this->instancia->configurarAmbienteParaTeste(0, "Obra 1", "Couro 1", "Função", "Origem", "Procedência", "Descrição", 0, 0, 100.1, 100.1, 100.1, 100.1, 100.1, "Materiais", "Técnicas", "Autoria", "Marcas", "Histórico", "Modo de Aquisição", "2017-08-02", "Autor", "Observações", "Estado");
        $_POST = null;
        $this->expectException(DadosCorrompidosException::class); //exceção esperada 
        $this->instancia->cadastrarObra();
    }

    /*
    *Testa o cadastro de uma coleção com erro;
    * @runInSeparateProcess
    * @preserveGlobalState disabled 
    
    public function testCadastrarColecaoErro() {
        // A FAZER
    }*/

    /**
    * Testa a edição do nome de uma obra com sucesso;
    * @runInSeparateProcess
    * @preserveGlobalState disabled    
    */
    public function testEditarNomeObraSucesso(){
        $this->instancia->configurarAmbienteParaTeste(0, "Obra 1", "Couro 1", "Função", "Origem", "Procedência", "Descrição", 0, 0, 100.1, 100.1, 100.1, 100.1, 100.1, "Materiais", "Técnicas", "Autoria", "Marcas", "Histórico", "Modo de Aquisição", "2017-08-02", "Autor", "Observações", "Estado");
        $this->instancia->cadastrarObra();

        $obraDAO = new obraDAO();
        $obra = $obraDAO->buscar(array(),array("nome"=> "Obra 1"));
        $numInventario = $obra[0]->getNumInventario();
        $this->assertEquals(1,count($obra));

        $novoNome = 'Mil Novecentos e Oitenta e Couro';
        $this->instancia->configurarAmbienteParaTeste($numInventario ,$novoNome, "Couro 1", "Função", "Origem", "Procedência", "Descrição", 0, 0, 100.1, 100.1, 100.1, 100.1, 100.1, "Materiais", "Técnicas", "Autoria", "Marcas", "Histórico", "Modo de Aquisição", "2017-08-02", "Autor", "Observações", "Estado");
        $this->instancia->gerenciarObra();
        $obra = $obraDAO->buscar(array(),array("nome"=>$novoNome));
        $this->assertEquals(1,count($obra));
    }

     /**
    * Testa a edição do id da coleção de uma obra com sucesso;
    * @runInSeparateProcess
    * @preserveGlobalState disabled    
    */
    public function testEditarIdColecaoOraSucesso(){
        $this->instancia->configurarAmbienteParaTeste(0, "Obra 1", "Couro 1", "Função", "Origem", "Procedência", "Descrição", 0, 0, 100.1, 100.1, 100.1, 100.1, 100.1, "Materiais", "Técnicas", "Autoria", "Marcas", "Histórico", "Modo de Aquisição", "2017-08-02", "Autor", "Observações", "Estado");
        $this->instancia->cadastrarObra();

        $obraDAO = new obraDAO();
        $obra = $obraDAO->buscar(array(),array("nome"=> "Obra 1"));
        $numInventario = $obra[0]->getNumInventario();
        $this->assertEquals(1,count($obra));

        $novaColecao = 5;
        $this->instancia->configurarAmbienteParaTeste($numInventario ,$novoNome, "Couro 1", "Função", "Origem", "Procedência", "Descrição", $novaColecao, 0, 100.1, 100.1, 100.1, 100.1, 100.1, "Materiais", "Técnicas", "Autoria", "Marcas", "Histórico", "Modo de Aquisição", "2017-08-02", "Autor", "Observações", "Estado");
        $this->instancia->gerenciarObra();
        $obra = $obraDAO->buscar(array(),array("idColecao"=>$novaColecao));
        $this->assertEquals(1,count($obra));
    }

    /**
    * Testa a remoção de uma obra com sucesso
    * @runInSeparateProcess
    * @preserveGlobalState disabled    
    */
    public function testRemocaoComSucesso(){
        $this->instancia->configurarAmbienteParaTeste(0, "Obra 1", "Couro 1", "Função", "Origem", "Procedência", "Descrição", 0, 0, 100.1, 100.1, 100.1, 100.1, 100.1, "Materiais", "Técnicas", "Autoria", "Marcas", "Histórico", "Modo de Aquisição", "2017-08-02", "Autor", "Observações", "Estado");
        $this->instancia->cadastrarObra();

        $obraDAO = new obraDAO();
        $obra = $obraDAO->buscar(array(),array("nome"=> "Obra 1"));
        $numInventario = $obra[0]->getNumInventario();
        $this->assertEquals(1,count($obra));

        $novoNome = 'Obra Nova';
        $this->instancia->configurarAmbienteParaTeste($numInventario ,$novoNome,'Couro 1', 'Função', 'Origem', 'Procedência', 'Descrição', 0, 0, 'Altura', 'Largura', 'Diâmetro', '10 quilos', '1 metro', 'Materiais', 'Técnicas', 'Autoria', 'Marcas', 'Histórico', 'Modo de Aquisição', 'Data de Aquisição', 'Autor', 'Observações', 'Estado');
        $this->instancia->removerObra();

        $obra = $obraDAO->buscar(array(),array("nome"=> "Obra Nova"));
        $this->assertEquals(0,count($obra));
    }

    public function testUploadImagemErro() {

    }

}