<?php
require_once dirname(__FILE__).'/../../vendor/autoload.php';

use \PHPUnit\Framework\TestCase;
use \DAO\usuarioDAO as usuarioDAO;
use \DAO\funcionarioDAO as funcionarioDAO;
use \controllers\funcionarioController as funcionarioController;
use \exceptions\NivelDeAcessoInsuficienteException as NivelDeAcessoInsuficienteException;
use \models\Funcionario as Funcionario;

class funcionarioControllerTest extends TestCase {
    private $instanciaFuncionario;

    public function setup(){
        $this->instanciaFuncionario = new funcionarioController();
    }

    public function testCadastrarFuncionarioComSucesso(){
        $this->instanciaFuncionario->configuraAmbienteParaTeste("Diego", "Lourenço", "diegossl94@gmail.com", "12345678", "15111215", "Qualquer coisa", "1");
        $this->instanciaFuncionario->cadastrarFuncionario();

        $funcionarioDAO = new FuncionarioDAO();

        $funcionariosEncontrados = $funcionarioDAO->buscar(array(), array("matricula" => "15111215"));
        
        $this->assertEquals(1, count($funcionariosEncontrados));

        $this->assertEquals("Diego", $funcionariosEncontrados[0]->getNome());
        $this->assertEquals("Lourenço", $funcionariosEncontrados[0]->getSobrenome());
        $this->assertEquals("diegossl94@gmail.com", $funcionariosEncontrados[0]->getEmail());
        $this->assertEquals("25d55ad283aa400af464c76d713c07ad", $funcionariosEncontrados[0]->getSenha());
        $this->assertEquals("15111215", $funcionariosEncontrados[0]->getMatricula());
        $this->assertEquals("Qualquer coisa", $funcionariosEncontrados[0]->getFuncao());
        $this->assertEquals("1", $funcionariosEncontrados[0]->isPodeCadastrarObra());
        $this->assertEquals("0", $funcionariosEncontrados[0]->isPodeGerenciarObra());
        $this->assertEquals("0", $funcionariosEncontrados[0]->isPodeRemoverObra());
        $this->assertEquals("0", $funcionariosEncontrados[0]->isPodeCadastrarNoticia());
        $this->assertEquals("0", $funcionariosEncontrados[0]->isPodeGerenciarNoticia());
        $this->assertEquals("0", $funcionariosEncontrados[0]->isPodeRemoverNoticia());
        $this->assertEquals("0", $funcionariosEncontrados[0]->isPodeRealizarBackup());
    }


/**
    * Testa a edição de um funcionario com sucesso;
    * @runInSeparateProcess
    * @preserveGlobalState disabled    
    */
    public function testEditarFuncionarioSucesso (){
        $this->instanciaFuncionario->configuraAmbienteParaTeste('Aloisio', 'Junior', 'kleyner2@hotmail.com', '12345678', '14211151', 'Something', '1');
        $this->instanciaFuncionario->cadastrarFuncionario();

        $funcionarioDAO = new FuncionarioDAO();
        $usuarioDAO = new UsuarioDAO();

        $usuario = $usuarioDAO->buscar(array(), array("nome"=>"Aloisio"));
        $funcionario = $funcionarioDAO->buscar(array(), array("matricula"=>"14211151"));
        $this->assertEquals($usuario[0]->getNome(), $funcionario[0]->getNome());

        $novoNome = 'Iago';
        $this->instanciaFuncionario->configuraAmbienteParaTeste($novoNome, 'Junior', 'kleyner2@hotmail.com', '12345678', '14211151', 'Something', '1');
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
        $this->instanciaFuncionario->configuraAmbienteParaTeste('Aloisio', 'Junior', 'kleyner2@hotmail.com', '12345678', '14211151', 'Something', '1');
        $this->instanciaFuncionario->cadastrarFuncionario();

        $funcionarioDAO = new FuncionarioDAO();
        $usuarioDAO = new UsuarioDAO();

        $usuario = $usuarioDAO->buscar(array(), array("nome"=>"Aloisio"));
        $funcionario = $funcionarioDAO->buscar(array(), array("matricula"=>"14211151"));
        $this->assertEquals($usuario[0]->getNome(), $funcionario[0]->getNome());

        $novoSobrenome = 'Cajueiro';
        $this->instanciaFuncionario->configuraAmbienteParaTeste('Aloisio', $novoSobrenome, 'kleyner2@hotmail.com', '12345678', null, 'Something', '1');
        $this->instanciaFuncionario->gerenciarFuncionario();
        $this->expectException(NivelDeAcessoInsuficienteException::class); //Exception esperada

    }

    /**
    * Testa a remoção de um funcionario com sucesso;
    * @runInSeparateProcess
    * @preserveGlobalState disabled    
    */
    public function testRemoverFuncionarioSucesso (){
        $this->instanciaFuncionario->configuraAmbienteParaTeste('Aloisio', 'Junior', 'kleyner2@hotmail.com', '12345678', '14211151', 'Something', '1');
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
        $this->instanciaFuncionario->configuraAmbienteParaTeste('Aloisio', 'Junior', 'kleyner2@hotmail.com', '12345678', '14211151', 'Something', '1');
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

    /*public function testBuscarFuncionario(){
        $funcionarioDAO = new FuncionarioDAO();
        $encontrado = $funcionarioDAO->buscar(array(), array('idUsuario' => '10'));
        $this->assertEquals("Diego", $encontrado[0]->getNome());
        $this->assertEquals("15111215", $encontrado[0]->getMatricula());
    }*/
}
?>
