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
    public function testLogin() {
        //considerando que existe o seguinte cadastro no Banco de Dados: Nome: Fulano, Sobrenome: De Tal, Email: vvalmeida96@gmail.com, Senha: 11111111) 
        $this->instancia->configuraAmbienteParaTeste('vvalmeida96@gmail.com', '11111111', null, null);
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
        $this->instancia->configuraAmbienteParaTeste('vvalmeida96', '11111111', null, null);
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
        $this->instancia->configuraAmbienteParaTeste('vvalmeida96@gmail.com', '1', null, null);
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
        $this->instancia->configuraAmbienteParaTeste('vvalmeida96@gmail.com', '11111111', null, null);
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
     public function testRedefinir() {
        $usuarioDao = new UsuarioDAO();
        $usuario = $usuarioDao->buscar(null, array("email"=>'vvalmeida96@gmail.com')); //obtém o usuário

        $this->assertEquals(1, count($usuario)); //verifica se foi obtido apenas um usuário
        $usuario = $usuario[0];

        //considerando que existe o seguinte cadastro no Banco de Dados: Nome: Fulano, Sobrenome: De Tal, Email: vvalmeida96@gmail.com, Senha: 11111111) 
        $this->instancia->configuraAmbienteParaTeste('vvalmeida96@gmail.com', '11111111', '22222222', $usuario->getId()); //redefine o ambiente com a nova senha
        $this->instancia->redefinir(); //chama o método de redefinir

        $usuario = $usuarioDao->buscar(null, array("email"=>'vvalmeida96@gmail.com')); //busca o usuário pelo email

        $this->assertEquals(1, count($usuario)); //verifica se foi obtido apenas um usuário
        $usuario = $usuario[0];

        $this->assertEquals(md5('22222222'), $usuario->getSenha()); //verifica se a senha foi alterada

        //AS LINHAS ABAIXO VÃO ALTERAR NOVAMENTE A SENHA PARA A ORIGINAL, POIS OS DADOS SERÃO UTILIZADOS EM OUTROS TESTES
        //considerando que existe o seguinte cadastro no Banco de Dados: Nome: Fulano, Sobrenome: De Tal, Email: vvalmeida96@gmail.com, Senha: 11111111) 
        $this->instancia->configuraAmbienteParaTeste('vvalmeida96@gmail.com', '11111111', '11111111', $usuario->getId());
        $this->instancia->redefinir();

        $usuario = $usuarioDao->buscar(null, array("email"=>'vvalmeida96@gmail.com'));

        $this->assertEquals(1, count($usuario));
        $usuario = $usuario[0];

        $this->assertEquals(md5('11111111'), $usuario->getSenha());            
     }

    /**
     * @runInSeparateProcess
     * @preserveGlobalState disabled
     */
     public function testRedefinirDadosCorrompidos() {
        //considerando que existe o seguinte cadastro no Banco de Dados: Nome: Fulano, Sobrenome: De Tal, Email: vvalmeida96@gmail.com, Senha: 11111111) 
        $this->instancia->configuraAmbienteParaTeste(null, null, null, null); //redefine o ambiente com a nova senha
        try {
            $this->instancia->redefinir(); //chama o método de redefinir
        } catch (DadosCorrompidosException $e) {
            $this->assertTrue(true);
        }
           
     }
}