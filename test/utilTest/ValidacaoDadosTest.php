<?php
require_once dirname(__FILE__).'/../../vendor/autoload.php';

use \PHPUnit\Framework\TestCase;
use \util\ValidacaoDados as ValidacaoDados;

class ValidacaoDadosTest extends TestCase {


    /**
    * Testa o método validarCampo() do CadastroController
    * @comment Setar método ValidarCampo() como public na hora de executar o teste. Default: private;
    */
    public function testValidarCampo(){
        
        //Testa um valor nulo, espera false como resposta;
        $dado = null;
        $resposta = ValidacaoDados::validarCampo($dado);
        $this->assertEquals(false,$resposta);

        //Testa uma string com contéudo, espera true como resposta
        $dado = 'Ola mundo!'; 
        $resposta = ValidacaoDados::validarCampo($dado);
        $this->assertEquals(true,$resposta);
        
        //Testa uma string vazia, espera 'false' como resposta
        $dado = '';
        $resposta = ValidacaoDados::validarCampo($dado);
        $this->assertEquals(false,$resposta);

    }


    /**
    * Testa o método validarNome() do CadastroController
    * @comment Setar método validarNome() como public na hora de executar o teste. Default: private;
    */
    public function testValidarNome(){

        //Testa um valor nulo, espera false como resposta.
        $dado = null;
        $resposta = ValidacaoDados::validarNome($dado);
        $this->assertEquals(false,$resposta);

        //Testa uma string válida, espera false como resposta;
        $dado = 'Ariano Suassuna';
        $resposta = ValidacaoDados::validarNome($dado);
        $this->assertEquals(true,$resposta);

        //Testa uma string válida, espera false como resposta;
        $dado = "Joana D'Arc";
        $resposta = ValidacaoDados::validarNome($dado);
        $this->assertEquals(true,$resposta);

        
        //Testa uma string somente com espaços, espera false como resposta;
        $dado = '      ';
        $resposta = ValidacaoDados::validarNome($dado);
        $this->assertEquals(false,$resposta);

        //Testa uma string com um caractere considerado inválido, espera false como resposta.
        $dado = 'Ola mundo!'; 
        $resposta = ValidacaoDados::validarNome($dado);
        $this->assertEquals(false,$resposta);
        
        //Testa uma string vazia, espera 'false' como resposta.
        $dado = '';
        $resposta = ValidacaoDados::validarNome($dado);
        $this->assertEquals(false,$resposta);
    }

    /**
    * Testa o método validarEmail() do CadastroController
    * @comment Setar método validarEmail() como public na hora de executar o teste. Default: private;
    */
    public function testValidarEmail(){
        
        //Testa um valor nulo, espera false como resposta;
        $dado = null;
        $resposta = ValidacaoDados::validarEmail($dado);
        $this->assertEquals(false,$resposta);

        //Testa uma string com contéudo, espera true como resposta
        $dado = 'teste@teste.com'; 
        $resposta = ValidacaoDados::validarEmail($dado);
        $this->assertEquals(true,$resposta);
        
        //Testa uma string vazia, espera 'false' como resposta
        $dado = '';
        $resposta = ValidacaoDados::validarEmail($dado);
        $this->assertEquals(false,$resposta);

        //Testa um email inválido, espera 'false' como resposta
        $dado = '   @gmail.com';
        $resposta = ValidacaoDados::validarEmail($dado);
        $this->assertEquals(false,$resposta);

        //Testa um email inválido, espera 'false' como resposta
        $dado = '   @   .com';
        $resposta = ValidacaoDados::validarEmail($dado);
        $this->assertEquals(false,$resposta);

        //Testa um email inválido, espera 'false' como resposta
        $dado = '      .com';
        $resposta = ValidacaoDados::validarEmail($dado);
        $this->assertEquals(false,$resposta);


        //Testa um email inválido, espera 'false' como resposta
        $dado = '   @   ';
        $resposta = ValidacaoDados::validarEmail($dado);
        $this->assertEquals(false,$resposta);

        //Testa um email inválido, espera 'false' como resposta
        $dado = 'abc@';
        $resposta = ValidacaoDados::validarEmail($dado);
        $this->assertEquals(false,$resposta);
    
    }

    /**
    * Testa o método validarSenha() do CadastroController
    * @comment Setar método validarSenha() como public na hora de executar o teste. Default: private;
    */
    public function testValidarSenha(){
        
        //Testa um valor nulo, espera false como resposta;
        $dado = null;
        $resposta = ValidacaoDados::validarSenha($dado);
        $this->assertEquals(false,$resposta);

        //Testa uma string com contéudo, espera true como resposta
        $dado = '12345678'; 
        $resposta = ValidacaoDados::validarSenha($dado);
        $this->assertEquals(true,$resposta);
        
        //Testa uma string vazia, espera 'false' como resposta
        $dado = '';
        $resposta = ValidacaoDados::validarSenha($dado);
        $this->assertEquals(false,$resposta);

        //Testa uma string maior do que o tamanho aceitável, espera 'false' como resposta
        $dado = '12345678123456781234567812345678123456781234567812345678';
        $resposta = ValidacaoDados::validarSenha($dado);
        $this->assertEquals(false,$resposta);

    }

    /**
    * Testa o método validarForm() do CadastroController
    * @comment Setar método validarForm() como public na hora de executar o teste. Default: private;
    */
    public function testValidarForm(){
        
        //Testa um valor nulo, espera false como resposta;
        $dado = null;
        $resposta = ValidacaoDados::validarForm($dado, "cadastro");
        $this->assertEquals(false,$resposta);

        //Testa um array com conteúdo válido, espera true como resposta
        $dado = array("nome"=>"Joaquim","sobrenome"=>"Nabuco","senha"=>"12345678","email"=>"teste@gmail.com"); 
        $resposta = ValidacaoDados::validarForm($dado, "cadastro");
        $this->assertEquals(true,$resposta);
        
        //Testa um array faltando campos, espera 'false' como resposta
        $dado = array("nome"=>"Joaquim","senha"=>"12345678","email"=>"teste@gmail.com");
        $resposta = ValidacaoDados::validarForm($dado, "cadastro");
        $this->assertEquals(false,$resposta);

        //Testa um array onde o nome da chave foi editado, espera 'false' como resposta
        $dado = array("PRIMEIROnome"=>"Joaquim","sobrenome"=>"Nabuco","senha"=>"12345678","email"=>"teste@gmail.com");
        $resposta = ValidacaoDados::validarForm($dado, "cadastro");
        $this->assertEquals(false,$resposta);

    }    
}