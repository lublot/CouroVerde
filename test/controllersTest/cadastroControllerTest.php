<?php
require_once '../../vendor/autoload.php';

define(ABSPATH,dirname(__DIR__).'\..');
use \controllers\cadastroController as cadastroController;
use Util\GerenciarSenha as GerenciarSenha;
use PHPUnit\Framework\TestCase;
use \DAO\usuarioDAO as usuarioDAO;


class cadastroControllerTest extends TestCase
{
    private $instancia;
    
    public function setUp(){
        $this->instancia = new cadastroController();
        $this->instancia->configuraPOSTDefault();
    }

    // public static function setUpBeforeClass() {
    //     $instancia = new cadastroController();  
    //     $instancia->configuraPOSTDefault();
    // }

    public function testConfirmar()
    {
        
        $this->instancia->index();
        $usuarioDAO = new UsuarioDAO();
        $usuario = $usuarioDAO->buscar(array(), array("email"=>$email)); //Busca o usuário récem cadastrado
        $this->assertEquals(1, count($usuario)); //certifica-se que apenas um usuário foi cadastrado
        $usuario = $usuario[0];
        $this->assertEquals('ebssoueu@gmail.com', $usuario->getEmail()); //certifica-se que o email é igual ao esperado
    }

    /**
    * Testa o método validarCampo() do CadastroController
    * @comment Setar método ValidarCampo() como public na hora de executar o teste. Default: private;
    */
    public function testValidarCampo(){
        
        //Testa um valor nulo, espera false como resposta;
        $dado = null;
        $resposta = $this->instancia->validarCampo($dado);
        $this->assertEquals(false,$resposta);

        //Testa uma string com contéudo, espera true como resposta
        $dado = 'Ola mundo!'; 
        $resposta = $this->instancia->validarCampo($dado);
        $this->assertEquals(true,$resposta);
        
        //Testa uma string vazia, espera 'false' como resposta
        $dado = '';
        $resposta = $this->instancia->validarCampo($dado);
        $this->assertEquals(false,$resposta);

    }

    /**
    * Testa o método validarNome() do CadastroController
    * @comment Setar método validarNome() como public na hora de executar o teste. Default: private;
    */
    public function testValidarNome(){

        //Testa um valor nulo, espera false como resposta.
        $dado = null;
        $resposta = $this->instancia->validarNome($dado);
        $this->assertEquals(false,$resposta);

        //Testa uma string válida, espera false como resposta;
        $dado = 'Ariano Suassuna';
        $resposta = $this->instancia->validarNome($dado);
        $this->assertEquals(true,$resposta);

        //Testa uma string válida, espera false como resposta;
        $dado = "Joana D'Arc";
        $resposta = $this->instancia->validarNome($dado);
        $this->assertEquals(true,$resposta);

        
        //Testa uma string somente com espaços, espera false como resposta;
        $dado = '      ';
        $resposta = $this->instancia->validarNome($dado);
        $this->assertEquals(false,$resposta);

        //Testa uma string com um caractere considerado inválido, espera false como resposta.
        $dado = 'Ola mundo!'; 
        $resposta = $this->instancia->validarNome($dado);
        $this->assertEquals(false,$resposta);
        
        //Testa uma string vazia, espera 'false' como resposta.
        $dado = '';
        $resposta = $this->instancia->validarNome($dado);
        $this->assertEquals(false,$resposta);
    }

    /**
    * Testa o método validarEmail() do CadastroController
    * @comment Setar método validarEmail() como public na hora de executar o teste. Default: private;
    */
    public function testValidarEmail(){
        
        //Testa um valor nulo, espera false como resposta;
        $dado = null;
        $resposta = $this->instancia->validarEmail($dado);
        $this->assertEquals(false,$resposta);

        //Testa uma string com contéudo, espera true como resposta
        $dado = 'teste@teste.com'; 
        $resposta = $this->instancia->validarEmail($dado);
        $this->assertEquals(true,$resposta);
        
        //Testa uma string vazia, espera 'false' como resposta
        $dado = '';
        $resposta = $this->instancia->validarEmail($dado);
        $this->assertEquals(false,$resposta);

        //Testa um email inválido, espera 'false' como resposta
        $dado = '   @gmail.com';
        $resposta = $this->instancia->validarEmail($dado);
        $this->assertEquals(false,$resposta);

        //Testa um email inválido, espera 'false' como resposta
        $dado = '   @   .com';
        $resposta = $this->instancia->validarEmail($dado);
        $this->assertEquals(false,$resposta);

        //Testa um email inválido, espera 'false' como resposta
        $dado = '      .com';
        $resposta = $this->instancia->validarEmail($dado);
        $this->assertEquals(false,$resposta);


        //Testa um email inválido, espera 'false' como resposta
        $dado = '   @   ';
        $resposta = $this->instancia->validarEmail($dado);
        $this->assertEquals(false,$resposta);

        //Testa um email inválido, espera 'false' como resposta
        $dado = 'abc@';
        $resposta = $this->instancia->validarEmail($dado);
        $this->assertEquals(false,$resposta);
    
    }

    /**
    * Testa o método validarSenha() do CadastroController
    * @comment Setar método validarSenha() como public na hora de executar o teste. Default: private;
    */
    public function testValidarSenha(){
        
        //Testa um valor nulo, espera false como resposta;
        $dado = null;
        $resposta = $this->instancia->validarSenha($dado);
        $this->assertEquals(false,$resposta);

        //Testa uma string com contéudo, espera true como resposta
        $dado = '12345678'; 
        $resposta = $this->instancia->validarSenha($dado);
        $this->assertEquals(true,$resposta);
        
        //Testa uma string vazia, espera 'false' como resposta
        $dado = '';
        $resposta = $this->instancia->validarSenha($dado);
        $this->assertEquals(false,$resposta);

        //Testa uma string maior do que o tamanho aceitável, espera 'false' como resposta
        $dado = '12345678123456781234567812345678123456781234567812345678';
        $resposta = $this->instancia->validarSenha($dado);
        $this->assertEquals(false,$resposta);

    }

    /**
    * Testa o método validarForm() do CadastroController
    * @comment Setar método validarForm() como public na hora de executar o teste. Default: private;
    */
    public function testValidarForm(){
        
        //Testa um valor nulo, espera false como resposta;
        $dado = null;
        $resposta = $this->instancia->validarForm($dado);
        $this->assertEquals(false,$resposta);

        //Testa um array com conteúdo válido, espera true como resposta
        $dado = array("nome"=>"Joaquim","sobrenome"=>"Nabuco","senha"=>"12345678","email"=>"teste@gmail.com"); 
        $resposta = $this->instancia->validarForm($dado);
        $this->assertEquals(true,$resposta);
        
        //Testa um array faltando campos, espera 'false' como resposta
        $dado = array("nome"=>"Joaquim","senha"=>"12345678","email"=>"teste@gmail.com");
        $resposta = $this->instancia->validarForm($dado);
        $this->assertEquals(false,$resposta);

        //Testa um array onde o nome da chave foi editado, espera 'false' como resposta
        $dado = array("PRIMEIROnome"=>"Joaquim","sobrenome"=>"Nabuco","senha"=>"12345678","email"=>"teste@gmail.com");
        $resposta = $this->instancia->validarForm($dado);
        $this->assertEquals(false,$resposta);

    }



}
