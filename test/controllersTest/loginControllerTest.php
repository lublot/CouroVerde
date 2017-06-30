<?php
require_once dirname(__FILE__).'/../../vendor/autoload.php';

use \PHPUnit\Framework\TestCase;
use \DAO\usuarioDAO as usuarioDAO;
use \controllers\loginController as loginController;
use exceptions\UsuarioInexistenteException as UsuarioInexistenteException;
use exceptions\SenhaInvalidaException as SenhaInvalidaException;
use exceptions\EmailInvalidoException as EmailInvalidoException;


class loginControllerTest extends TestCase {
    private $instancia;

    /**
    * Obtém uma instância do controller.
    */
    public function setUp(){
        $this->instancia = new loginController();
    }

    /**
     * @runInSeparateProcess
     * @preserveGlobalState disabled
     */
    public function testLoginComCasosCorretosEErros() {
        //considerando que existe o seguinte cadastro no Banco de Dados: Nome: Fulano, Sobrenome: De Tal, Email: vvalmeida96@gmail.com, Senha: 11111111) 
        $this->instancia->configuraAmbienteParaTeste('vvalmeida96@gmail.com', '11111111', null);
        $this->instancia->index();

        //verifica se os dados da sessão são os esperados
        $this->assertEquals('Fulano', $_SESSION['nome']);
        $this->assertEquals('vvalmeida96@gmail.com', $_SESSION['email']);
        $this->assertEquals('De Tal', $_SESSION['sobrenome']);                 
    }

    /**
     * @runInSeparateProcess
     * @preserveGlobalState disabled
     */
    public function testLoginEmailinvalido() {
        $this->instancia->configuraAmbienteParaTeste('vvalmeida96', '11111111', null);
        $this->instancia->index();

        //verifica se os dados não foram setados
        $this->assertFalse(array_key_exists("nome", $_SESSION));        
        $this->assertFalse(array_key_exists("sobrenome", $_SESSION));
        $this->assertFalse(array_key_exists("email", $_SESSION));

        $this->assertTrue($this->instancia->getDados() != null);
        $this->assertEquals("Email inválido", $this->instancia->getDados()['exception']);        
    }

    /**
     * @runInSeparateProcess
     * @preserveGlobalState disabled
     */
    public function testLoginSenhaInvalida() {
        $this->instancia->configuraAmbienteParaTeste('vvalmeida96@gmail.com', '1', null);
        $this->instancia->index();

        //verifica se os dados não foram setados
        $this->assertFalse(array_key_exists("nome", $_SESSION));        
        $this->assertFalse(array_key_exists("sobrenome", $_SESSION));
        $this->assertFalse(array_key_exists("email", $_SESSION));

        $this->assertTrue($this->instancia->getDados() != null);
        $this->assertEquals("A senha deve conter entre 8 e 32 caracteres", $this->instancia->getDados()['exception']);   
    }

    /**
     * @runInSeparateProcess
     * @preserveGlobalState disabled
     */
     public function testLogout() {
        //considerando que existe o seguinte cadastro no Banco de Dados: Nome: Fulano, Sobrenome: De Tal, Email: vvalmeida96@gmail.com, Senha: 11111111) 
        $this->instancia->configuraAmbienteParaTeste('vvalmeida96@gmail.com', '11111111', null);
        $this->instancia->index();
        $this->instancia->logout();

        $this->assertFalse(array_key_exists("nome", $_SESSION));        
        $this->assertFalse(array_key_exists("sobrenome", $_SESSION));
        $this->assertFalse(array_key_exists("email", $_SESSION));

     }

    /**
     * @runInSeparateProcess
     * @preserveGlobalState disabled
     */
     public function testEmailRedefinicao() {
        //considerando que existe o seguinte cadastro no Banco de Dados: Nome: Fulano, Sobrenome: De Tal, Email: vvalmeida96@gmail.com, Senha: 11111111) 
        $this->instancia->configuraAmbienteParaTeste('vvalmeida96@gmail.com', '11111111', null);
        $this->instancia->EmailRedefinicao();


     }




}