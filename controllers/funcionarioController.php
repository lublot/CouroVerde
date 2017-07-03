<?php
namespace controllers;

use \exceptions\NomeInvalidoException as NomeInvalidoException;
use \exceptions\SobrenomeInvalidoException as SobrenomeInvalidoException;
use \exceptions\SenhaInvalidaException as SenhaInvalidaException;
use \exceptions\EmailInvalidoException as EmailInvalidoException;
use \exceptions\EmailJaCadastradoException as EmailJaCadastradoException;
use \exceptions\DadosCorrompidosException as DadosCorrompidosException;
use \exceptions\NivelDeAcessoInsuficienteException as NivelDeAcessoInsuficienteException;
use \exceptions\MatriculaInvalidaException as MatriculaInvalidaException;
use DAO\FuncionarioDAO as FuncionarioDAO;
use \util\GerenciarSenha as GerenciarSenha;
use \util\ValidacaoDados as ValidacaoDados;
use \models\Funcionario as Funcionario;

class funcionarioController extends mainController {

    public function cadastrarFuncionario() {
        if($this->verificarFuncionario() == 'Administrador') {
            if (ValidacaoDados::validarForm($_POST, array("nome","sobrenome","email","senha", "matricula", "funcao"))) {
                $funcionarioDAO = new FuncionarioDAO();

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
                $podeCadastrarObra = 0;
                $podeGerenciarObra = 0;
                $podeRemoverObra = 0;
                $podeCadastrarNoticia = 0;
                $podeGerenciarNoticia = 0;
                $podeRemoverNoticia = 0;
                $podeRealizarBackup = 0;

                if(isset($_POST["cadastroObra"])) {
                    $podeCadastrarObra = 1;
                }
                if(isset($_POST["gerenciarObra"])) {
                    $podeGerenciarObra = 1;
                }
                if(isset($_POST["remocaoObra"])) {
                    $podeRemoverObra = 1;
                }
                if(isset($_POST["cadastroNoticia"])) {
                    $podeCadastrarNoticia = 1;
                }
                if(isset($_POST["gerenciarNoticia"])) {
                    $podeGerenciarNoticia = 1;
                }
                if(isset($_POST["remocaoNoticia"])) {
                    $podeRemoverNoticia = 1;
                }
                if(isset($_POST["backup"])) {
                    $podeRealizarBackup = 1;
                }

                $novoFuncionario = new Funcionario(null, $email, $nome, $sobrenome, $senha, 1, 'Funcionario',
                $matricula, $funcao, $podeCadastrarObra, $podeGerenciarObra, $podeRemoverObra, $podeCadastrarNoticia,
                $podeGerenciarNoticia, $podeRemoverNoticia, $podeRealizarBackup);

                $funcionarioDAO->inserir($novoFuncionario);
            }
            else {
                throw new DadosCorrompidosException();
            }
        }
        else {
            throw new NivelDeAcessoInsuficienteException();
        }
    }

    private function verificarFuncionario(){
        if(isset($_SESSION['tipoUsuario']) && !empty($_SESSION['tipoUsuario'])){
            return $_SESSION['tipoUsuario'];
        }
        else {
            return null;
        }
    }
}

?>