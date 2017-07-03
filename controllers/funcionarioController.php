<?php
namespace controllers;

use \exceptions\NomeInvalidoException as NomeInvalidoException;
use \exceptions\SobrenomeInvalidoException as SobrenomeInvalidoException;
use \exceptions\SenhaInvalidaException as SenhaInvalidaException;
use \exceptions\EmailInvalidoException as EmailInvalidoException;
use \exceptions\EmailJaCadastradoException as EmailJaCadastradoException;
use \exceptions\DadosCorrompidosException as DadosCorrompidosException;
use DAO\FuncionarioDAO as FuncionarioDAO;
use \util\GerenciarSenha as GerenciarSenha;
use \util\ValidacaoDados as ValidacaoDados;
use \models\Funcionario as Funcionario;

class funcionarioController {

    public function cadastrarFuncionario(){
        if (ValidacaoDados::validarForm($_POST, array("nome","sobrenome","email","senha", "matricula", "funcao"))) {
            $funcionarioDAO = new funcionarioDAO();

            $email = addslashes($_POST["email"]);
            $funcionario = $funcionarioDAO->buscar(array(), array("email"=>$email));

            if(count($funcionario) > 0) { //verifica se já existe usuário cadastrado
                throw new EmailJaCadastradoException();
            }

            if (!ValidacaoDados::validarNome($_POST["nome"])) {
                throw new NomeInvalidoException();
            }

            if (!ValidacaoDados::validarNome($_POST["sobrenome"])) {
                throw new SobrenomeInvalidoException();
            }
                
            if (!ValidacaoDados::validarSenha($_POST["senha"])) {
                throw new SenhaInvalidaException();
            }
                
            if (!ValidacaoDados::validarEmail($_POST["email"])) {
                throw new EmailInvalidoException();
            }

            if (!ValidacaoDados::validarMatricula($_POST["matricula"])) {
                throw new MatriculaInvalidaException();
            }

            if (!ValidacaoDados::validarNome($_POST["funcao"])) {
                throw new NomeInvalidoException();
            }

            $nome = addslashes($_POST["nome"]);
            $sobrenome = addslashes($_POST["sobrenome"]);
            $senha = GerenciarSenha::criptografarSenha($_POST["senha"]);
            $email = addslashes($_POST["email"]);
            $funcao = addslashes($_POST["funcao"]);
            $matricula = $_POST["matricula"];
            $podeCadastrarObra = $_POST["cadastroObra"];
            $podeGerenciarObra = $_POST["gerenciarObra"];
            $podeRemoverObra = $_POST["remocaoObra"];
            $podeCadastrarNoticia = $_POST["cadastroNoticia"];
            $podeGerenciarNoticia = $_POST["gerenciarNoticia"];
            $podeRemoverNoticia = $_POST["remocaoNoticia"];
            $podeRealizarBackup = $_POST["backup"];

            $novoFuncionario = new Funcionario(null, $email, $nome, $sobrenome, $senha, false,
            $matricula, $funcao, $podeCadastrarObra, $podeGerenciarObra, $podeRemoverObra, $podeCadastrarNoticia,
            $podeGerenciarNoticia, $podeRemoverNoticia, $podeRealizarBackup);

            $funcionarioDAO->inserir($novoFuncionario);
        }
        else{
            throw new DadosCorrompidosException();
        }
    }
}

?>