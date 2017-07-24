<?php
require_once dirname(__FILE__).'/../../vendor/autoload.php';

use \PHPUnit\Framework\TestCase;
use \DAO\PesquisaDAO as PesquisaDAO;
use \DAO\PerguntaDAO as PerguntaDAO;
use \DAO\perguntaOpcaoDAO as PerguntaOpcaoDAO;
use \DAO\perguntaPesquisaDAO as PerguntaPesquisaDAO;
use \DAO\opcaoDAO as OpcaoDAO;
use \DAO\usuarioDAO as UsuarioDAO;
use \models\Usuario as Usuario;
use \controllers\pesquisaController as pesquisaController;
use \models\Pesquisa as Pesquisa;

class PesquisaControllerTest extends TestCase {

 private $instancia;

    public function setup(){
        $this->instancia = new pesquisaController();

        //remove todas as pesquisas anteriormente cadastradas antes de realizar o teste
        $pesquisaDAO = new PesquisaDAO();
        $pesquisaDAO->remover(array());                       
    }

    /**
    * Testa a criação de uma pesquisa sem erros.
    */
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
        $this->assertEquals("UNICA ESCOLHA", $pergunta1->getTipo());
        $this->assertEquals(true, $pergunta1->getIsOpcional());   

         //obtém a segunda pergunta e verifica se os campos estão corretos
        $pergunta2 = $perguntasBD[1];

        $this->assertEquals("Questão Múltipla Escolha", $pergunta2->getTitulo());
        $this->assertEquals("MULTIPLA ESCOLHA", $pergunta2->getTipo());
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

        $opcaoDAO->remover(array());
        $perguntaDAO = new PerguntaDAO();
        $perguntaDAO->remover(array());            
    } 

    /**
    * Testa a criação de uma pesquisa com pergunta inconsistente.
    */
     public function testCriarPesquisaPerguntaInconsistente() {
        $json = '{"tituloPesquisa":"Nova Pesqusa 23","descricaoPesquisa":"Descrição Nova","Pergunta0":[{"tituloPergunta":"","tipoPergunta":"UNICA ESCOLHA","obrigatorio":"false","opcoes":["Sim","Não"]}],"Pergunta1":[{"tituloPergunta":"Questão Múltipla Escolha","tipoPergunta":"MULTIPLA ESCOLHA","obrigatorio":"true","opcoes":["Alternativa 1","Alternativa 2"]}],"Pergunta2":[{"tituloPergunta":"Questão Aberta","tipoPergunta":"ABERTA","obrigatorio":"false"}]}';

        $this->instancia->configurarAmbienteParaTeste($json);
        $this->instancia->criar();

        $pesquisaDAO = new PesquisaDAO();
        $perguntaOpcaoDAO = new PerguntaOpcaoDAO();
        $perguntaPesquisaDAO = new PerguntaPesquisaDAO();        
        $opcaoDAO = new OpcaoDAO();

        $pesquisasBD = $pesquisaDAO->buscar(array(), array());

        $this->assertEquals(0, count($pesquisasBD)); //verifica se não existem perguntas armazenadas  
    }     

    /**
    * Testa a criação de uma pesquisa já existente.
    */
     public function testCriarPesquisaTituloJaExistente() {
        $json = '{"tituloPesquisa":"Nova Pesqusa 23","descricaoPesquisa":"Descrição Nova","Pergunta0":[{"tituloPergunta":"Questão Única Escolha","tipoPergunta":"UNICA ESCOLHA","obrigatorio":"false","opcoes":["Sim","Não"]}],"Pergunta1":[{"tituloPergunta":"Questão Múltipla Escolha","tipoPergunta":"MULTIPLA ESCOLHA","obrigatorio":"true","opcoes":["Alternativa 1","Alternativa 2"]}],"Pergunta2":[{"tituloPergunta":"Questão Aberta","tipoPergunta":"ABERTA","obrigatorio":"false"}]}';

        $this->instancia->configurarAmbienteParaTeste($json);
        $this->instancia->criar();

        $json = '{"tituloPesquisa":"Nova Pesqusa 23","descricaoPesquisa":"Descrição Repetida","Pergunta0":[{"tituloPergunta":"Questão Única Escolha 2","tipoPergunta":"UNICA ESCOLHA","obrigatorio":"false","opcoes":["Sim 2","Não 2"]}],"Pergunta1":[{"tituloPergunta":"Questão Múltipla Escolha","tipoPergunta":"MULTIPLA ESCOLHA","obrigatorio":"true","opcoes":["Alternativa 1","Alternativa 2"]}],"Pergunta2":[{"tituloPergunta":"Questão Aberta","tipoPergunta":"ABERTA","obrigatorio":"false"}]}';

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
        $this->assertEquals("Descrição Nova", $pesquisa->getDescricao()); //verifica se a descrição da pesquisa corresponde à descrição do primeiro cadastro de pesquisa

        $perguntasBD = $perguntaPesquisaDAO->buscarPergunta(array(), array("idPesquisa" => $pesquisa->getIdPesquisa()));
        $this->assertEquals(3, count($perguntasBD)); //verifica se a quantidade de perguntas é a esperada

        //obtém a primeira pergunta e verifica se os campos estão corretos
        $pergunta1 = $perguntasBD[0];

        $this->assertEquals("Questão Única Escolha", $pergunta1->getTitulo());
        $this->assertEquals("UNICA ESCOLHA", $pergunta1->getTipo());
        $this->assertEquals(true, $pergunta1->getIsOpcional());   

         //obtém a segunda pergunta e verifica se os campos estão corretos
        $pergunta2 = $perguntasBD[1];

        $this->assertEquals("Questão Múltipla Escolha", $pergunta2->getTitulo());
        $this->assertEquals("MULTIPLA ESCOLHA", $pergunta2->getTipo());
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

        $opcaoDAO->remover(array());
        $perguntaDAO = new PerguntaDAO();
        $perguntaDAO->remover(array());            
    }     

    /**
    * Testa a criação de uma pesquisa sem título.
    */
     public function testCriarPesquisaSemTitulo() {
        $json = '{"tituloPesquisa":"  ","descricaoPesquisa":"Descrição Nova","Pergunta0":[{"tituloPergunta":"Questão Única Escolha","tipoPergunta":"UNICA ESCOLHA","obrigatorio":"false","opcoes":["Sim","Não"]}],"Pergunta1":[{"tituloPergunta":"Questão Múltipla Escolha","tipoPergunta":"MULTIPLA ESCOLHA","obrigatorio":"true","opcoes":["Alternativa 1","Alternativa 2"]}],"Pergunta2":[{"tituloPergunta":"Questão Aberta","tipoPergunta":"ABERTA","obrigatorio":"false"}]}';

        $this->instancia->configurarAmbienteParaTeste($json);
        $this->instancia->criar();

        $pesquisaDAO = new PesquisaDAO();
        $perguntaOpcaoDAO = new PerguntaOpcaoDAO();
        $perguntaPesquisaDAO = new PerguntaPesquisaDAO();        
        $opcaoDAO = new OpcaoDAO();

        $pesquisasBD = $pesquisaDAO->buscar(array(), array());

        $this->assertEquals(1, count($pesquisasBD)); //verifica se existe apenas uma pesquisa armazenada
        
        $pesquisa = $pesquisasBD[0];
        $this->assertEquals("Sem título", $pesquisa->getTitulo()); //verifica se o título da pesquisa é o esperado
        $this->assertEquals("Descrição Nova", $pesquisa->getDescricao()); //verifica se a descrição da pesquisa é a esperada

        $perguntasBD = $perguntaPesquisaDAO->buscarPergunta(array(), array("idPesquisa" => $pesquisa->getIdPesquisa()));
        $this->assertEquals(3, count($perguntasBD)); //verifica se a quantidade de perguntas é a esperada

        //obtém a primeira pergunta e verifica se os campos estão corretos
        $pergunta1 = $perguntasBD[0];

        $this->assertEquals("Questão Única Escolha", $pergunta1->getTitulo());
        $this->assertEquals("UNICA ESCOLHA", $pergunta1->getTipo());
        $this->assertEquals(true, $pergunta1->getIsOpcional());   

         //obtém a segunda pergunta e verifica se os campos estão corretos
        $pergunta2 = $perguntasBD[1];

        $this->assertEquals("Questão Múltipla Escolha", $pergunta2->getTitulo());
        $this->assertEquals("MULTIPLA ESCOLHA", $pergunta2->getTipo());
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

        $opcaoDAO->remover(array());
        $perguntaDAO = new PerguntaDAO();
        $perguntaDAO->remover(array());            
    }    

    /**
    * Testa a remoção de uma pesquisa sem erros.
    */
    public function testRemoverPesquisa() {
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

        //cadastra um usuario administrador
        $usuarioDAO = new UsuarioDAO();
        $usuarioDAO->remover(array());
        $usuarioDAO->inserir(new Usuario(null, "email@email.com", "Nome", "Sobrenome", md5("Senha"), true, "administrador"));

        $usuarioBD = $usuarioDAO->buscar(array(), array("nome" => "Nome", 
        "sobrenome" => "Sobrenome", 
        "tipoUsuario" => "ADMINISTRADOR",
        "email" => "email@email.com"));

        $this->assertEquals(1, count($usuarioBD)); //verifica se existe apenas um usuário no BD
        $usuario = $usuarioBD[0];

        //realizando a remoção
        $this->instancia->configurarAmbienteParaTeste(null, "Senha", $pesquisa->getIdPesquisa()); //configura o ambiente para testes
        $this->instancia->remover();

        $pesquisasBD = $pesquisaDAO->buscar(array(), array("idPesquisa" => $pesquisa->getIdPesquisa()));
        $this->assertEquals(0, count($pesquisasBD)); //verifica se a pesquisa não foi encontrada       

        $perguntasBD = $perguntaPesquisaDAO->buscarPergunta(array(), array("idPesquisa" => $pesquisa->getIdPesquisa()));
        $this->assertEquals(0, count($perguntasBD)); //verifica se a quantidade de perguntas é a esperada
    }

    /**
    * Testa a remoção de uma pesquisa com senha incorreta.
    */
    public function testRemoverPesquisaSenhaIncorreta() {
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

        //cadastra um usuario administrador
        $usuarioDAO = new UsuarioDAO();
        $usuarioDAO->remover(array());
        $usuarioDAO->inserir(new Usuario(null, "email@email.com", "Nome", "Sobrenome", md5("Senha"), true, "administrador"));

        $usuarioBD = $usuarioDAO->buscar(array(), array("nome" => "Nome", 
        "sobrenome" => "Sobrenome", 
        "tipoUsuario" => "ADMINISTRADOR",
        "email" => "email@email.com"));

        $this->assertEquals(1, count($usuarioBD)); //verifica se existe apenas um usuário no BD
        $usuario = $usuarioBD[0];

        //realizando a remoção
        $this->instancia->configurarAmbienteParaTeste(null, "ATA", $pesquisa->getIdPesquisa()); //configura o ambiente para testes
        $this->instancia->remover();

        $pesquisasBD = $pesquisaDAO->buscar(array(), array("idPesquisa" => $pesquisa->getIdPesquisa()));
        $this->assertEquals(1, count($pesquisasBD)); //verifica se a pesquisa não foi removida   

        //tenta realizar remoção com a senha correta
        $this->instancia->configurarAmbienteParaTeste(null, "Senha", $pesquisa->getIdPesquisa()); //configura o ambiente para testes
        $this->instancia->remover();
    }    

    /**
    * Testa a remoção de uma pesquisa com dados corrompidos.
    */
    public function testRemoverPesquisaDadosCorrompidos() {
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

        //cadastra um usuario administrador
        $usuarioDAO = new UsuarioDAO();
        $usuarioDAO->remover(array());
        $usuarioDAO->inserir(new Usuario(null, "email@email.com", "Nome", "Sobrenome", md5("Senha"), true, "administrador"));

        $usuarioBD = $usuarioDAO->buscar(array(), array("nome" => "Nome", 
        "sobrenome" => "Sobrenome", 
        "tipoUsuario" => "ADMINISTRADOR",
        "email" => "email@email.com"));

        $this->assertEquals(1, count($usuarioBD)); //verifica se existe apenas um usuário no BD
        $usuario = $usuarioBD[0];

        //realizando a remoção
        $this->instancia->configurarAmbienteParaTeste(); //configura o ambiente para testes
        $this->instancia->remover();

        $pesquisasBD = $pesquisaDAO->buscar(array(), array("idPesquisa" => $pesquisa->getIdPesquisa()));
        $this->assertEquals(1, count($pesquisasBD)); //verifica se a pesquisa não foi removida   

        //realiza a remoção com dados recebidos
        $this->instancia->configurarAmbienteParaTeste(null, "Senha", $pesquisa->getIdPesquisa()); //configura o ambiente para testes
        $this->instancia->remover();
    }    

    /**
    * Testa o gerenciamento de uma pesquisa sem erros.
    */
    public function testGerenciar() {
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

        $perguntasBD = $perguntaPesquisaDAO->buscarPergunta(array(), array("idPesquisa" => $pesquisa->getIdPesquisa()));

        //obtém a primeira pergunta e verifica se os campos estão corretos
        $pergunta1 = $perguntasBD[0];

         //obtém a segunda pergunta e verifica se os campos estão corretos
        $pergunta2 = $perguntasBD[1];
 
        //obtém a terceira pergunta e verifica se os campos estão corretos
        $pergunta3 = $perguntasBD[2];

        //obtém as opções de cada pergunta
        $opcoes1BD = $perguntaOpcaoDAO->buscarOpcao(array(), array("idPergunta" => $pergunta1->getIdPergunta()));
        $opcoes2BD = $perguntaOpcaoDAO->buscarOpcao(array(), array("idPergunta" => $pergunta2->getIdPergunta()));
        $opcoes3BD = $perguntaOpcaoDAO->buscarOpcao(array(), array("idPergunta" => $pergunta3->getIdPergunta()));

        $json = '{"tituloPesquisa":"Nova Pesqusa 23","descricaoPesquisa":"Com opçõesNOVA","Pergunta0":[{"idPergunta":"'.$pergunta1->getIdPergunta().'","tituloPergunta":"Questão 1NOVA","tipoPergunta":"ABERTA","obrigatorio":"false","opcoes":[{"idOpcao":"nulo","titulo":"SimNOVA"},{"idOpcao":"nulo","titulo":"NãoNOVA"}]}],"Pergunta1":[{"idPergunta":"nulo","tituloPergunta":"Questão 2NOVA","tipoPergunta":"Aberta","obrigatorio":"false"}],"Pergunta2":[{"idPergunta":"nulo","tituloPergunta":"Questão 3","tipoPergunta":"Multipla Escolha","obrigatorio":"false","opcoes":[{"idOpcao":"nulo","titulo":"Sim"},{"idOpcao":"nulo","titulo":"Não"}]}],"Pergunta3":[{"idPergunta":"nulo","tituloPergunta":"Questão 4","tipoPergunta":"Unica Escolha","obrigatorio":"false","opcoes":[{"idOpcao":"nulo","titulo":"Sim"},{"idOpcao":"nulo","titulo":"Não"}]}]}';         
        //confere se as opções da terceira pergunta estão conforme esperado                
        $this->assertEquals(0, count($opcoes3BD));
        $this->instancia->configurarAmbienteParaTeste($json, null, $pesquisa->getIdPesquisa());
        $this->instancia->alterar();

        $perguntaOpcaoDAO = new PerguntaOpcaoDAO();
        $perguntaPesquisaDAO = new PerguntaPesquisaDAO();        

        $pesquisasBD = $pesquisaDAO->buscar(array(), array());

        $this->assertEquals(1, count($pesquisasBD)); //verifica se existe apenas uma pesquisa armazenada
        
        $pesquisa = $pesquisasBD[0];
        $this->assertEquals("Nova Pesqusa 23", $pesquisa->getTitulo()); //verifica se o título da pesquisa é o esperado
        $this->assertEquals("Com opçõesNOVA", $pesquisa->getDescricao()); //verifica se a descrição da pesquisa corresponde à descrição do primeiro cadastro de pesquisa

        $perguntasBD = $perguntaPesquisaDAO->buscarPergunta(array(), array("idPesquisa" => $pesquisa->getIdPesquisa()));
        $this->assertEquals(4, count($perguntasBD)); //verifica se a quantidade de perguntas é a esperada

        //obtém a primeira pergunta e verifica se os campos estão corretos
        $pergunta1 = $perguntasBD[0];

        $this->assertEquals("Questão 1NOVA", $pergunta1->getTitulo());
        $this->assertEquals("UNICA ESCOLHA", $pergunta1->getTipo());
        $this->assertEquals(true, $pergunta1->getIsOpcional());   

         //obtém a segunda pergunta e verifica se os campos estão corretos
        $pergunta2 = $perguntasBD[1];

        $this->assertEquals("Questão 2NOVA", $pergunta2->getTitulo());
        $this->assertEquals("ABERTA", $pergunta2->getTipo());
        $this->assertEquals(true, $pergunta2->getIsOpcional()); 
 
        //obtém a terceira pergunta e verifica se os campos estão corretos
        $pergunta3 = $perguntasBD[2];

        $this->assertEquals("Questão 3", $pergunta3->getTitulo());
        $this->assertEquals("MULTIPLA ESCOLHA", $pergunta3->getTipo());
        $this->assertEquals(true, $pergunta3->getIsOpcional());     

        //obtém a terceira pergunta e verifica se os campos estão corretos
        $pergunta4 = $perguntasBD[3];

        $this->assertEquals("Questão 4", $pergunta4->getTitulo());
        $this->assertEquals("UNICA ESCOLHA", $pergunta4->getTipo());
        $this->assertEquals(true, $pergunta4->getIsOpcional());                              
   
        //obtém as opções de cada pergunta
        $opcoes1BD = $perguntaOpcaoDAO->buscarOpcao(array(), array("idPergunta" => $pergunta1->getIdPergunta()));
        $opcoes2BD = $perguntaOpcaoDAO->buscarOpcao(array(), array("idPergunta" => $pergunta2->getIdPergunta()));
        $opcoes3BD = $perguntaOpcaoDAO->buscarOpcao(array(), array("idPergunta" => $pergunta3->getIdPergunta()));
        $opcoes4BD = $perguntaOpcaoDAO->buscarOpcao(array(), array("idPergunta" => $pergunta4->getIdPergunta()));
        
        //confere se as opções da primeira pergunta estão conforme esperado
        $this->assertEquals(2, count($opcoes1BD));
        $this->assertEquals("Sim", $opcoes1BD[0]->getDescricao());
        $this->assertEquals("Não", $opcoes1BD[1]->getDescricao());        

        //confere se as opções da segunda pergunta estão conforme esperado
        $this->assertEquals(0, count($opcoes2BD));
                
        //confere se as opções da terceira pergunta estão conforme esperado                
        $this->assertEquals(2, count($opcoes3BD)); 
        $this->assertEquals("Sim", $opcoes3BD[0]->getDescricao());
        $this->assertEquals("Não", $opcoes3BD[1]->getDescricao());   

        //confere se as opções da quarta pergunta estão conforme esperado                
        $this->assertEquals(2, count($opcoes4BD)); 
        $this->assertEquals("Sim", $opcoes4BD[0]->getDescricao());
        $this->assertEquals("Não", $opcoes4BD[1]->getDescricao());

        $pesquisaDAO = new PesquisaDAO();
        $pesquisaDAO->remover(array());   

        $perguntaDAO = new PerguntaDAO();
        $perguntaDAO->remover(array());   
        
        $opcaoDAO = new OpcaoDAO();
        $opcaoDAO->remover(array());         
    }

    /**
    * Testa o gerenciamento de uma pesquisa com id diferente do informado.
    */
    public function testGerenciarPesquisaExistente() {
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

        $perguntasBD = $perguntaPesquisaDAO->buscarPergunta(array(), array("idPesquisa" => $pesquisa->getIdPesquisa()));

        //obtém a primeira pergunta e verifica se os campos estão corretos
        $pergunta1 = $perguntasBD[0];

         //obtém a segunda pergunta e verifica se os campos estão corretos
        $pergunta2 = $perguntasBD[1];
 
        //obtém a terceira pergunta e verifica se os campos estão corretos
        $pergunta3 = $perguntasBD[2];

        //obtém as opções de cada pergunta
        $opcoes1BD = $perguntaOpcaoDAO->buscarOpcao(array(), array("idPergunta" => $pergunta1->getIdPergunta()));
        $opcoes2BD = $perguntaOpcaoDAO->buscarOpcao(array(), array("idPergunta" => $pergunta2->getIdPergunta()));
        $opcoes3BD = $perguntaOpcaoDAO->buscarOpcao(array(), array("idPergunta" => $pergunta3->getIdPergunta()));

        $json = '{"tituloPesquisa":"Nova Pesqusa 23","descricaoPesquisa":"Com opçõesNOVA","Pergunta0":[{"idPergunta":"'.$pergunta1->getIdPergunta().'","tituloPergunta":"Questão 1NOVA","tipoPergunta":"ABERTA","obrigatorio":"false","opcoes":[{"idOpcao":"nulo","titulo":"SimNOVA"},{"idOpcao":"nulo","titulo":"NãoNOVA"}]}],"Pergunta1":[{"idPergunta":"nulo","tituloPergunta":"Questão 2NOVA","tipoPergunta":"Aberta","obrigatorio":"false"}],"Pergunta2":[{"idPergunta":"nulo","tituloPergunta":"Questão 3","tipoPergunta":"Multipla Escolha","obrigatorio":"false","opcoes":[{"idOpcao":"nulo","titulo":"Sim"},{"idOpcao":"nulo","titulo":"Não"}]}],"Pergunta3":[{"idPergunta":"nulo","tituloPergunta":"Questão 4","tipoPergunta":"Unica Escolha","obrigatorio":"false","opcoes":[{"idOpcao":"nulo","titulo":"Sim"},{"idOpcao":"nulo","titulo":"Não"}]}]}';         
        //confere se as opções da terceira pergunta estão conforme esperado                
        $this->assertEquals(0, count($opcoes3BD));
        $this->instancia->configurarAmbienteParaTeste($json, null, -1);
        $this->instancia->alterar();

        $perguntaOpcaoDAO = new PerguntaOpcaoDAO();
        $perguntaPesquisaDAO = new PerguntaPesquisaDAO();        

        $pesquisasBD = $pesquisaDAO->buscar(array(), array());

        $this->assertEquals(1, count($pesquisasBD)); //verifica se existe apenas uma pesquisa armazenada
        
        $pesquisa = $pesquisasBD[0];
        $this->assertEquals("Nova Pesqusa 23", $pesquisa->getTitulo()); //verifica se o título da pesquisa é o esperado
        $this->assertEquals("Descrição Nova", $pesquisa->getDescricao()); //verifica se a descrição da pesquisa corresponde à descrição do primeiro cadastro de pesquisa

        $pesquisaDAO = new PesquisaDAO();
        $pesquisaDAO->remover(array());   

        $perguntaDAO = new PerguntaDAO();
        $perguntaDAO->remover(array());   
        
        $opcaoDAO = new OpcaoDAO();
        $opcaoDAO->remover(array());   
    }    

    /**
    * Testa o gerenciamento de uma pesquisa com dados corrompidos.
    */
    public function testGerenciarDadosCorrompidos() {
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

        $perguntasBD = $perguntaPesquisaDAO->buscarPergunta(array(), array("idPesquisa" => $pesquisa->getIdPesquisa()));

        //obtém a primeira pergunta e verifica se os campos estão corretos
        $pergunta1 = $perguntasBD[0];

         //obtém a segunda pergunta e verifica se os campos estão corretos
        $pergunta2 = $perguntasBD[1];
 
        //obtém a terceira pergunta e verifica se os campos estão corretos
        $pergunta3 = $perguntasBD[2];

        //obtém as opções de cada pergunta
        $opcoes1BD = $perguntaOpcaoDAO->buscarOpcao(array(), array("idPergunta" => $pergunta1->getIdPergunta()));
        $opcoes2BD = $perguntaOpcaoDAO->buscarOpcao(array(), array("idPergunta" => $pergunta2->getIdPergunta()));
        $opcoes3BD = $perguntaOpcaoDAO->buscarOpcao(array(), array("idPergunta" => $pergunta3->getIdPergunta()));

        $json = '{"tituloPesquisa":"Nova Pesqusa 23","descricaoPesquisa":"Com opçõesNOVA","Pergunta0":[{"idPergunta":"'.$pergunta1->getIdPergunta().'","tituloPergunta":"Questão 1NOVA","tipoPergunta":"ABERTA","obrigatorio":"false","opcoes":[{"idOpcao":"nulo","titulo":"SimNOVA"},{"idOpcao":"nulo","titulo":"NãoNOVA"}]}],"Pergunta1":[{"idPergunta":"nulo","tituloPergunta":"Questão 2NOVA","tipoPergunta":"Aberta","obrigatorio":"false"}],"Pergunta2":[{"idPergunta":"nulo","tituloPergunta":"Questão 3","tipoPergunta":"Multipla Escolha","obrigatorio":"false","opcoes":[{"idOpcao":"nulo","titulo":"Sim"},{"idOpcao":"nulo","titulo":"Não"}]}],"Pergunta3":[{"idPergunta":"nulo","tituloPergunta":"Questão 4","tipoPergunta":"Unica Escolha","obrigatorio":"false","opcoes":[{"idOpcao":"nulo","titulo":"Sim"},{"idOpcao":"nulo","titulo":"Não"}]}]}';         
        //confere se as opções da terceira pergunta estão conforme esperado                
        $this->assertEquals(0, count($opcoes3BD));
        $this->instancia->configurarAmbienteParaTeste($json, null, null);
        $this->instancia->alterar();

        $perguntaOpcaoDAO = new PerguntaOpcaoDAO();
        $perguntaPesquisaDAO = new PerguntaPesquisaDAO();        

        $pesquisasBD = $pesquisaDAO->buscar(array(), array());

        $this->assertEquals(1, count($pesquisasBD)); //verifica se existe apenas uma pesquisa armazenada
        
        $pesquisa = $pesquisasBD[0];
        $this->assertEquals("Nova Pesqusa 23", $pesquisa->getTitulo()); //verifica se o título da pesquisa é o esperado
        $this->assertEquals("Descrição Nova", $pesquisa->getDescricao()); //verifica se a descrição da pesquisa corresponde à descrição do primeiro cadastro de pesquisa

        $pesquisaDAO = new PesquisaDAO();
        $pesquisaDAO->remover(array());   

        $perguntaDAO = new PerguntaDAO();
        $perguntaDAO->remover(array());   
        
        $opcaoDAO = new OpcaoDAO();
        $opcaoDAO->remover(array());     
    }    


}

?>