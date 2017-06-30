<?php
require_once dirname(__FILE__).'/../../vendor/autoload.php';

use \PHPUnit\Framework\TestCase;
use \DAO\usuarioDAO as usuarioDAO;
use \controllers\loginController as loginController;


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
     */
    public function testLogin() {
        //considerando que existe o seguinte cadastro no Banco de Dados: Nome: Fulano, Sobrenome: De Tal, Email: vvalmeida96@gmail.com, Senha: 11111111) 
        $this->instancia->configuraAmbienteParaTeste('vvalmeida96@gmail.com', '11111111');
        $this->instancia->index();

        //verifica se os dados da sessão são os esperados
        $this->assertEquals('Fulano', $_SESSION['nome']);
        $this->assertEquals('vvalmeida96@gmail.com', $_SESSION['email']);
        $this->assertEquals('De Tal', $_SESSION['sobrenome']);
    }


}