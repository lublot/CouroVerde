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
                "idUsuario" => "64",
                "nome" => "Diego",
                "sobrenome" => "Lourenço",
                "email" => "diegossl94@gmail.com",
                "senha" => "25d55ad283aa400af464c76d713c07ad",
                "cadastroConfirmado" => "1",
                "tipoUsuario" => "Funcionario"
            )
        );
        $resultado2 = $funcionarioDAO->buscar(
            array(), 
            array(
                "matricula" => "15111215",
                "idUsuario" => "64",
                "funcao" => "Qualquer coisa",
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


/**
    * Testa a edição de um funcionario com sucesso;
    * @runInSeparateProcess
    * @preserveGlobalState disabled    
    */
    public function testEditarFuncionarioSucesso (){
        $this->instanciaFuncionario->configurarAmbienteParaTeste('Aloisio', 'Junior', 'kleyner2@hotmail.com', '12345678', '14211151', 'Something', '1');
        $this->instanciaFuncionario->cadastrarFuncionario();

        $funcionarioDAO = new FuncionarioDAO();
        $usuarioDAO = new UsuarioDAO();

        $usuario = $usuarioDAO->buscar(array(), array("nome"=>"Aloisio"));
        $funcionario = $funcionarioDAO->buscar(array(), array("matricula"=>"14211151"));
        $this->assertEquals($usuario[0]->getNome(), $funcionario[0]->getNome());

        $novoNome = 'Iago';
        $this->instanciaFuncionario->configurarAmbienteParaTeste($novoNome, 'Junior', 'kleyner2@hotmail.com', '12345678', '14211151', 'Something', '1');
        $this->instanciaFuncionario->gerenciarFuncionario();
        $funcionario = $funcionarioDAO->buscar(array(), array("nome"=>$novoNome));
        $this->assertEquals(1,count($funcionario));

    }

    /**
    * Testa a edição de um funcionario com falha;
    * @runInSeparateProcess
    * @preserveGlobalState disabled    
    */
    public function testEditarFuncionarioFalha (){
        $this->instanciaFuncionario->configurarAmbienteParaTeste('Aloisio', 'Junior', 'kleyner2@hotmail.com', '12345678', '14211151', 'Something', '1');
        $this->instanciaFuncionario->cadastrarFuncionario();

        $funcionarioDAO = new FuncionarioDAO();
        $usuarioDAO = new UsuarioDAO();

        $usuario = $usuarioDAO->buscar(array(), array("nome"=>"Aloisio"));
        $funcionario = $funcionarioDAO->buscar(array(), array("matricula"=>"14211151"));
        $this->assertEquals($usuario[0]->getNome(), $funcionario[0]->getNome());

        $novoSobrenome = 'Cajueiro';
        $this->instanciaFuncionario->configurarAmbienteParaTeste('Aloisio', $novoSobrenome, 'kleyner2@hotmail.com', '12345678', null, 'Something', '1');
        $this->instanciaFuncionario->gerenciarFuncionario();
        $this->expectException(NivelDeAcessoInsuficienteException::class); //Exception esperada

    }

    /**
    * Testa a remoção de um funcionario com sucesso;
    * @runInSeparateProcess
    * @preserveGlobalState disabled    
    */
    public function testRemoverFuncionarioSucesso (){
        $this->instanciaFuncionario->configurarAmbienteParaTeste('Aloisio', 'Junior', 'kleyner2@hotmail.com', '12345678', '14211151', 'Something', '1');
        $this->instanciaFuncionario->cadastrarFuncionario();

        $funcionarioDAO = new FuncionarioDAO();
        $usuarioDAO = new UsuarioDAO();

        $usuario = $usuarioDAO->buscar(array(), array("nome"=>"Aloisio"));
        $funcionario = $funcionarioDAO->buscar(array(), array("matricula"=>"14211151"));
        $this->assertEquals($usuario[0]->getNome(), $funcionario[0]->getNome());

        $this->instanciaFuncionario->removerNoticia();
        $funcionario = $funcionarioDAO->buscar(array(), array("matricula"=>"14211151"));
        $this->assertEquals(0,count($funcionario));
    }

    public function testRemoverFuncionarioFalha (){
        $this->instanciaFuncionario->configurarAmbienteParaTeste('Aloisio', 'Junior', 'kleyner2@hotmail.com', '12345678', '14211151', 'Something', '1');
        $this->instanciaFuncionario->cadastrarFuncionario();

        $funcionarioDAO = new FuncionarioDAO();
        $usuarioDAO = new UsuarioDAO();

        $usuario = $usuarioDAO->buscar(array(), array("nome"=>"Aloisio"));
        $funcionario = $funcionarioDAO->buscar(array(), array("matricula"=>"14211151"));
        $this->assertEquals($usuario[0]->getNome(), $funcionario[0]->getNome());
        $_SESSION['tipoUsuario'] = 'Anyway';
        $this->instanciaFuncionario->removerNoticia();
        $this->expectException(NivelDeAcessoInsuficienteException::class); //Exception esperada
    }

}
?>
