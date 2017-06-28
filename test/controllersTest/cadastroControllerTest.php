<?php
require_once dirname(__FILE__).'/../../vendor/autoload.php';

use \exceptions\NomeInvalidoException as NomeInvalidoException;
use \exceptions\SobrenomeInvalidoException as SobrenomeInvalidoException;
use \exceptions\SenhaInvalidaException as SenhaInvalidaException;
use \exceptions\EmailInvalidoException as EmailInvalidoException;
use \exceptions\DadosCorrompidosException as DadosCorrompidosException;
use \exceptions\EmailNaoEnviadoException as EmailNaoEnviadoException;
use \exceptions\UsuarioInexistenteException as UsuarioInexistenteException;
use \exceptions\ErroCadastroException as ErroCadastroException;
use \controllers\cadastroController as cadastroController;
use \util\GerenciarSenha as GerenciarSenha;
use \PHPUnit\Framework\TestCase;
use \DAO\usuarioDAO as usuarioDAO;


class cadastroControllerTest extends TestCase
{
    private $instancia;

    public function setUp(){
        $this->instancia = new cadastroController();
    }

    /**
    * Testa o cadastro de usuário e a confirmação para o caso em que o processo ocorre normalmente.
    */
    public function testCadastroEConfirmacao() {
        $this->instancia->configuraAmbienteParaTeste("Fulano", "De Tal", "vvalmeida96@gmail.com", "11111111", null);
        $this->instancia->index();

        $usuarioDAO = new UsuarioDAO();
        $usuario = $usuarioDAO->buscar(array(), array("email"=>"vvalmeida96@gmail.com")); //Busca o usuário récem cadastrado
        $this->assertEquals(1, count($usuario)); //certifica-se que apenas um usuário foi cadastrado
        $usuario = $usuario[0];
        $this->assertEquals('vvalmeida96@gmail.com', $usuario->getEmail()); //certifica-se que o email é igual ao esperado
    }

    /**
    * Testa o cadastro de usuário e a confirmação para o caso em que o nome informado é inválido.
    */
    public function testCadastroEConfirmacaoNomeIncorreto() {
        $this->instancia->configuraAmbienteParaTeste("", "De Tal", "a@gmail.com", "11111111", null);
        try {
            $this->instancia->index();
        } catch (NomeInvalidoException $e) {
            $this->assertTrue(true);
        } 

        $usuarioDAO = new UsuarioDAO();
        $usuario = $usuarioDAO->buscar(array(), array("email"=>"a@gmail.com")); //Busca o usuário récem cadastrado
        $this->assertEquals(0, count($usuario)); //certifica-se que apenas um usuário foi cadastrado
    }

    /**
    * Testa o cadastro de usuário e a confirmação para o caso em que o sobrenome informado é inválido.
    */
    public function testCadastroEConfirmacaoSobrenomeIncorreto() {
        $this->instancia->configuraAmbienteParaTeste("Fulano", "", "b@gmail.com", "11111111", null);
        try {
            $this->instancia->index();
        } catch (SobrenomeInvalidoException $e) {
            $this->assertTrue(true);
        }

        $usuarioDAO = new UsuarioDAO();
        $usuario = $usuarioDAO->buscar(array(), array("email"=>"b@gmail.com", null)); //Busca o usuário récem cadastrado
        $this->assertEquals(0, count($usuario)); //certifica-se que apenas um usuário foi cadastrado
    }

    /**
    * Testa o cadastro de usuário e a confirmação para o caso em que o email informado é inválido.
    */
    public function testCadastroEConfirmacaoEmailIncorreto() {
        $this->instancia->configuraAmbienteParaTeste("Fulano", "De Tal", "", "11111111", null);
        try {
            $this->instancia->index();
        } catch (EmailInvalidoException $e) {
            $this->assertTrue(true);
        }

        $this->instancia->configuraAmbienteParaTeste("Fulano", "De Tal", "courooooooo", "11111111", null);
        try {
            $this->instancia->index();
        } catch (EmailInvalidoException $e) {
            $this->assertTrue(true);
        }

    }

    /**
    * Testa o cadastro de usuário e a confirmação para o caso em que o sobrenome informado é inválido.
    */
    public function testCadastroEConfirmacaoSenhaIncorreta() {
        $this->instancia->configuraAmbienteParaTeste("Fulano", "De Tal", "k@gmail.com", null, null);
        try {
            $this->instancia->index();
        } catch (SenhaInvalidaException $e) {
            $this->assertTrue(true);
        }

        $usuarioDAO = new UsuarioDAO();
        $usuario = $usuarioDAO->buscar(array(), array("email"=>"k@gmail.com")); //Busca o usuário récem cadastrado
        $this->assertEquals(0, count($usuario)); //certifica-se que apenas um usuário foi cadastrado
    }

    /**
    * Testa o cadastro de usuário via Facebook.
    */
    public function testCadastrarUsuarioFacebook() {
        $this->instancia->cadastrarUsuarioFacebook(array(
            'email' => "v@gmail.com",
            'nome' => 'Fulano Face',
            'sobrenome' => 'De Face',
            'fb_id' => '8181818181'
        ));

        $usuarioDAO = new UsuarioDAO();
        $usuario = $usuarioDAO->buscar(array(), array("email"=>"v@gmail.com")); //Busca o usuário récem cadastrado
        $this->assertEquals(1, count($usuario)); //certifica-se que apenas um usuário foi cadastrado
        $usuario = $usuario[0];
        $this->assertEquals('v@gmail.com', $usuario->getEmail()); //certifica-se que o email é igual ao esperado     
    }
    
    /**
    * Testa o cadastro de usuário via Google.
    */
    public function testCadastrarUsuarioGoogle() {
        $usuarioGoogle;
        $usuarioGoogle['id'] = '88238328';
        $usuarioGoogle['modelData']['name']['givenName'] = 'Fulano Google';
        $usuarioGoogle['modelData']['name']['familyName'] = 'De Google';
        $usuarioGoogle['modelData']['emails'][0]['value'] = 'g@gmail.com';

        $this->instancia->cadastrarUsuarioGoogle($usuarioGoogle);

        $usuarioDAO = new UsuarioDAO();
        $usuario = $usuarioDAO->buscar(array(), array("email"=>"g@gmail.com")); //Busca o usuário récem cadastrado
        $this->assertEquals(1, count($usuario)); //certifica-se que apenas um usuário foi cadastrado
        $usuario = $usuario[0];
        $this->assertEquals('g@gmail.com', $usuario->getEmail()); //certifica-se que o email é igual ao esperado     
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
