<?php
require_once dirname(__FILE__).'/../../vendor/autoload.php';

use \PHPUnit\Framework\TestCase;
use \DAO\usuarioDAO as usuarioDAO;
use \DAO\funcionarioDAO as funcionarioDAO;
use \controllers\funcionarioController as funcionarioController;
use \exceptions\CampoNoticiaInvalidoException as CampoNoticiaInvalidoException;
use \exceptions\DadosCorrompidosException as DadosCorrompidosException;
use \exceptions\NoticiaNaoEncontradaException as NoticiaNaoEncontradaException;
use \models\Funcionario as Funcionario;

class fncionarioControllerTest extends TestCase {
    private $instanciaFuncionario;

    public function setup(){
        $this->instanciaFuncionario = new funcionarioController();
    }

    public function testCadastrarFuncionario(){
        $this->instanciaFuncionario->configuraAmbienteParaTeste("Diego", "Lourenço", "diegossl94@gmail.com", "12345678", "15111215", "Qualquer coisa", "1");
        $this->instanciaFuncionario->cadastrarFuncionario();

        $funcionarioDAO = new FuncionarioDAO();

        $usuarioDAO = new UsuarioDAO();

        $resultado1 = $usuarioDAO->buscar(
            array(),
            array(
                "idUsuario" => "1",
                "nome" => "Diego",
                "sobrenome" => "Lourenço",
                "email" => "diegossl94@gmail.com",
                "senha" => "25d55ad283aa400af464c76d713c07ad"
            )
        );
        $resultado2 = $funcionarioDAO->buscar(
            array(), 
            array(
                "matricula" => "15111215",
                "idUsuario" => "1",
                "funcao" => "Qualquer coisa",
                "matricula" => "0",
                "funcao" => "0",
                "cadastroObra" => "1",
                "gerenciaObra" => "0",
                "remocaoObra" => "0",
                "cadastroNoticia" => "0",
                "gerenciaNoticia" => "0",
                "remocaoNoticia" => "0",
                "backup" => "0"
            )
        );
        $this->assertEquals(1, count($resultado1));

        $this->assertEquals(1, count($resultado2));
    }
}

?>