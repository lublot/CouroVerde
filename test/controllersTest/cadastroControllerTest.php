<?php
require_once '../vendor/autoload.php';

use \controllers\cadastroController as cadastroController;
use \DAO\usuarioDAO as usuarioDAO;

class cadastroControllerTest extends PHPUnit_Framework_TestCase
{
    private $instancia;

    public static function setUpBeforeClass() {
        $instancia = new cadastroController();
        $instancia->configuraPOSTDefault();
    }

    public function testConfirmar()
    {
        $instancia->index();
        $usuarioDAO = new UsuarioDAO();
        $usuario = $usuarioDAO->buscar(array(), array("email"=>$email)); //Busca o usuário récem cadastrado
        $this->assertEquals(1, count($usuario)); //certifica-se que apenas um usuário foi cadastrado
        $usuario = $usuario[0];
        $this->assertEquals('ebssoueu@gmail.com', $usuario->getEmail()); //certifica-se que o email é igual ao esperado
    }
}
