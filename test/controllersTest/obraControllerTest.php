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

    /**
    *Testa o cadastro de uma coleção com sucesso;
    * @runInSeparateProcess
    * @preserveGlobalState disabled 
    */
    
    public function testCadastrarColecaoSucesso() {
        $this->instancia->testeColecaoClassificacao('Couro');
        $this->instancia->cadastrarColecao();

        $obraDAO = new obraDAO();
        $colecao = $this->instancia->obterColecao(1);
        $this->assertEquals('Couro', $colecao[0]->getNome());
    }

    /**
    *Testa o cadastro de uma classificação com sucesso;
    * @runInSeparateProcess
    * @preserveGlobalState disabled 
    */
    
    public function testCadastrarClassificacaoSucesso() {
        $this->instancia->testeColecaoClassificacao('Classificação');
        $this->instancia->cadastrarClassificacao();

        $obraDAO = new obraDAO();
        $classificacao = $this->instancia->obterClassificacao(1);
        $this->assertEquals('Classificação', $classificacao->getNome());
    }
    
    /**
    *Testa o cadastro de uma obra com sucesso;
    * @runInSeparateProcess
    * @preserveGlobalState disabled 
    */
    public function testCadastrarObraSucesso(){
        $this->instancia->configurarAmbienteParaTeste(9128, "Obra 1", "Couro 1", "Função", "Origem", "Procedência", "Descrição", 1, 1, 100.1, 100.1, 100.1, 100.1, 100.1, "Materiais", "Técnicas", "Autoria", "Marcas", "Histórico", "Modo de Aquisição", "2017-08-02", "Autor", "Observações", "Estado", "Tags");
        $this->instancia->cadastrarObra();

        $obraDAO = new obraDAO();
        $obra = $obraDAO->buscar(array(),array('numeroInventario' => 9128));
        $this->assertEquals(1,count($obra));
        $obra = $obra[0];
        $this->assertEquals(9128, $obra->getNumInventario());
    }

    /**
    *Testa o cadastro de uma obra com erro;
    * @runInSeparateProcess
    * @preserveGlobalState disabled 
    */
    public function testCadastrarObraErro() {
        $this->instancia->configurarAmbienteParaTeste(9128, null, "Couro 1", "Função", "Origem", "Procedência", "Descrição", 1, 1, 100.1, 100.1, 100.1, 100.1, 100.1, "Materiais", "Técnicas", "Autoria", "Marcas", "Histórico", "Modo de Aquisição", "2017-08-02", "Autor", "Observações", "Estado", "Tags");
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

    /*
    * Testa a edição do nome de uma obra com sucesso;
    * @runInSeparateProcess
    * @preserveGlobalState disabled    
    
    public function testEditarNomeObraSucesso(){
        $this->instancia->configurarAmbienteParaTeste(9128, "Nome Antigo", "Couro 1", "Função", "Origem", "Procedência", "Descrição", 1, 1, 100.1, 100.1, 100.1, 100.1, 100.1, "Materiais", "Técnicas", "Autoria", "Marcas", "Histórico", "Modo de Aquisição", "2017-08-02", "Autor", "Observações", "Estado", "Tags");
        $this->instancia->cadastrarObra();
        echo("EIA");
        $obraDAO = new obraDAO();
        $obra = $obraDAO->buscar(array(),array('numeroInventario' => 9128));
        $numInventario = $obra[0]->getNumInventario();
        $this->assertEquals(1,count($obra));
        

        $novoNome = 'Mil Novecentos e Oitenta e Couro';
        $this->instancia->configurarAmbienteParaTesteGerenciamento($numInventario, $novoNome, "Couro 1", "Função", "Origem", "Procedência", "Descrição", 1, 1, 100.1, 100.1, 100.1, 100.1, 100.1, "Materiais", "Técnicas", "Autoria", "Marcas", "Histórico", "Modo de Aquisição", "2017-08-02", "Autor", "Observações", "Estado", "Tags");
        $this->instancia->gerenciarObra();
        $obra = $obraDAO->buscar(array(),array('numeroInventario' => 9128));
        $this->assertEquals('Mil Novecentos e Oitenta e Couro', $obra[0]->getNome());
    }*/

     /**
    * Testa a edição do id da coleção de uma obra com sucesso;
    * @runInSeparateProcess
    * @preserveGlobalState disabled    
    */
    public function testEditarIdColecaoOraSucesso(){
        $this->instancia->configurarAmbienteParaTeste(9128, "Nome", "Couro 1", "Função", "Origem", "Procedência", "Descrição", 1, 1, 100.1, 100.1, 100.1, 100.1, 100.1, "Materiais", "Técnicas", "Autoria", "Marcas", "Histórico", "Modo de Aquisição", "2017-08-02", "Autor", "Observações", "Estado", "Tags");
        $this->instancia->cadastrarObra();

        $obraDAO = new obraDAO();
        $obra = $obraDAO->buscar(array(),array("nome"=> "Obra 1"));
        $numInventario = $obra[0]->getNumInventario();
        $this->assertEquals(1,count($obra));

        $novaColecao = 5;
        $this->instancia->configurarAmbienteParaTeste($numInventario ,$novoNome, "Couro 1", "Função", "Origem", "Procedência", "Descrição", $novaColecao, 1, 100.1, 100.1, 100.1, 100.1, 100.1, "Materiais", "Técnicas", "Autoria", "Marcas", "Histórico", "Modo de Aquisição", "2017-08-02", "Autor", "Observações", "Estado");
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
        $this->instancia->configurarAmbienteParaTeste(9128, "Nome", "Título", "Função", "Origem", "Procedência", "Descrição", 1, 1, 100.1, 100.1, 100.1, 100.1, 100.1, "Materiais", "Técnicas", "Autoria", "Marcas", "Histórico", "Modo de Aquisição", "2017-08-02", "Autor", "Observações", "Estado", "Tags");
        $this->instancia->cadastrarObra();

        $obraDAO = new obraDAO();
        $obra = $obraDAO->buscar(array(),array('numeroInventario'=> 9128));
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