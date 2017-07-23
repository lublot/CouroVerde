<?php
require_once dirname(__FILE__).'/../../vendor/autoload.php';

use \PHPUnit\Framework\TestCase;
use \DAO\PesquisaDAO as PesquisaDAO;
use \DAO\PerguntaDAO as PerguntaDAO;
use \DAO\perguntaOpcaoDAO as PerguntaOpcaoDAO;
use \DAO\perguntaPesquisaDAO as PerguntaPesquisaDAO;
use \DAO\opcaoDAO as OpcaoDAO;
use \controllers\pesquisaController as pesquisaController;
use \models\Pesquisa as Pesquisa;

class PesquisaControllerTest extends TestCase {

 private $instancia;

    public function setup(){
        $this->instancia = new pesquisaController();

        //remove todas as pesquisas anteriormente cadastradas antes de realizar o teste
        $pesquisaDAO = new PesquisaDAO();
        $pesquisaDAO->remover(array()); 

        $perguntaDAO = new PerguntaDAO();
        $perguntaDAO->remover(array()); 

        $opcaoDAO = new OpcaoDAO();
        $opcaoDAO->remover(array());        

    }

    public function testCriarPesquisa() {
        $json = '{"tituloPesquisa":"Nova Pesqusa 23","descricaoPesquisa":"Descrição Nova","Pergunta0":[{"tituloPergunta":"Questão Única Escolha","tipoPergunta":"UNICA ESCOLHA","obrigatorio":"false","opcoes":["Sim","Não"]}],"Pergunta1":[{"tituloPergunta":"Questão Múltipla Escolha","tipoPergunta":"MULTIPLA ESCOLHA","obrigatorio":"true","opcoes":["Alternativa 1","Alternativa 2"]}],"Pergunta2":[{"tituloPergunta":"Questão Aberta","tipoPergunta":"ABERTA","obrigatorio":"false"}]}';

        $this->instancia->configurarAmbienteParaTeste($json);
        $this->instancia->criar();

        $pesquisaDAO = new PesquisaDAO();
        $perguntaOpcaoDAO = new PerguntaOpcaoDAO();
        $perguntaPesquisaDAO = new PerguntaPesquisaDAO();        
        $opcaoDAO = new OpcaoDAO();

        $pesquisasBD = $pesquisaDAO->buscar(array(), array());

        $this->assertEquals(1, count($pesquisasBD)); //verifica se existe apenas uma pesquisa armazenada
        
        $pesquisa = $pesquisasBD[0];
        $this->assertEquals("Nova Pesqusa 23", $pesquisa->getTitulo()); //verifica se o título da pesquisa é o esperado
        $this->assertEquals("Descrição Nova", $pesquisa->getDescricao()); //verifica se a descrição da pesquisa é a esperada

        $perguntasBD = $perguntaPesquisaDAO->buscarPergunta(array(), array("idPesquisa" => $pesquisa->getIdPesquisa()));
        $this->assertEquals(3, count($perguntasBD)); //verifica se a quantidade de perguntas é a esperada

        //obtém a primeira pergunta e verifica se os campos estão corretos
        $pergunta1 = $perguntasBD[0];

        $this->assertEquals("Questão Única Escolha", $pergunta1->getTitulo());
        $this->assertEquals("ABERTA", $pergunta1->getTipo());
        $this->assertEquals(true, $pergunta1->getIsOpcional());   

         //obtém a segunda pergunta e verifica se os campos estão corretos
        $pergunta2 = $perguntasBD[1];

        $this->assertEquals("Questão Múltipla Escolha", $pergunta2->getTitulo());
        $this->assertEquals("ABERTA", $pergunta2->getTipo());
         $this->assertEquals(false, $pergunta2->getIsOpcional()); 
 
        //obtém a terceira pergunta e verifica se os campos estão corretos
        $pergunta3 = $perguntasBD[2];

        $this->assertEquals("Questão Aberta", $pergunta3->getTitulo());
        $this->assertEquals("ABERTA", $pergunta3->getTipo());
        $this->assertEquals(true, $pergunta3->getIsOpcional());                     
   

        //obtém as opções de cada pergunta
        $opcoes1BD = $perguntaOpcaoDAO->buscarOpcao(array(), array("idPergunta" => $pergunta1->getIdPergunta()));
        $opcoes2BD = $perguntaOpcaoDAO->buscarOpcao(array(), array("idPergunta" => $pergunta2->getIdPergunta()));
        $opcoes3BD = $perguntaOpcaoDAO->buscarOpcao(array(), array("idPergunta" => $pergunta3->getIdPergunta()));
        
        //confere se as opções da primeira pergunta estão conforme esperado
        $this->assertEquals(2, count($opcoes1BD));
        $this->assertEquals("Sim", $opcoes1BD[0]->getDescricao());
        $this->assertEquals("Não", $opcoes1BD[1]->getDescricao());        

        //confere se as opções da segunda pergunta estão conforme esperado
        $this->assertEquals(2, count($opcoes2BD));
        $this->assertEquals("Alternativa 1", $opcoes2BD[0]->getDescricao());
        $this->assertEquals("Alternativa 2", $opcoes2BD[1]->getDescricao());     
                
        //confere se as opções da terceira pergunta estão conforme esperado                
        $this->assertEquals(0, count($opcoes3BD));
    }

}

?>