<?php
namespace controllers;

require_once dirname(__DIR__).'/vendor/autoload.php';
use \exceptions\NomeInvalidoException as NomeInvalidoException;
use \exceptions\SobrenomeInvalidoException as SobrenomeInvalidoException;
use \exceptions\SenhaInvalidaException as SenhaInvalidaException;
use \exceptions\EmailInvalidoException as EmailInvalidoException;
use \exceptions\EmailJaCadastradoException as EmailJaCadastradoException;
use \exceptions\DadosCorrompidosException as DadosCorrompidosException;
use \exceptions\NivelDeAcessoInsuficienteException as NivelDeAcessoInsuficienteException;
use \exceptions\MatriculaInvalidaException as MatriculaInvalidaException;
use DAO\funcionarioDAO as funcionarioDAO;
use DAO\usuarioDAO as usuarioDAO;
use \util\GerenciarSenha as GerenciarSenha;
use \util\ValidacaoDados as ValidacaoDados;
use \models\Funcionario as Funcionario;

class funcionarioController extends mainController {

    /**
    * Configura a classe para realização de testes.
    * @param String $email email do usuário
    * @param String $nome nome do usuário
    * @param String $sobrenome sobrenome do usuário
    * @param String $senha senha do usuário
    * @param int $matricula matricula do funcionário
    * @param String $funcao Função do usuário no sistema
    */
    public function configuraAmbienteParaTeste($nome, $sobrenome, $email, $senha, $matricula, $funcao, $podeCadastrarObra) {
        $_POST["nome"] = $nome;
        $_POST["sobrenome"] = $sobrenome;
        $_POST["email"] = $email;
        $_POST["senha"] = $senha;

        $_POST["matricula"] = $matricula;
        $_POST["funcao"] = $funcao;
        $_POST["cadastroObra"] = $podeCadastrarObra;

        $_SESSION['tipoUsuario'] = 'Administrador';
     }

    /**
    * Realiza o cadastro de um funcionário.
    */
    public function cadastrarFuncionario() {
        if($this->verificarFuncionario() == 'Administrador') {
            if (ValidacaoDados::validarForm($_POST, array("nome","sobrenome","email","senha", "matricula", "funcao"))) {
                $funcionarioDAO = new FuncionarioDAO();
                $usuarioDAO = new UsuarioDAO();

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

                $novoFuncionario = new Funcionario(null, $email, $nome, $sobrenome, $senha, 1, "Funcionario",
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

    /**
    * Retorna o tipo de funcionário que está logado no sistema.
    * @return String $tipo - Tipo de usuário
    */
    private function verificarFuncionario(){
        $tipo = $_SESSION['tipoUsuario'];
        if(isset($tipo) && !empty($tipo)){
            return $tipo;
        }
        else {
            return null;
        }
    }

    public function gerenciarFuncionario(){
        if($this->verificarFuncionario() == 'Administrador') {
            if(ValidacaoDados::validarForm($this->POST,array('matricula','funcao'))){
                $matricula = $this->POST['matricula'];
                $funcao = $this->POST['funcao'];
                $podeCadastrarObra = false; $podeEditarObra = false;
                $podeRemoverObra = false; $podeCadastrarNoticia = false;
                $podeRemoverNoticia = false; $podeEditarNoticia = false;
                $podeRealizarBackup = false;

                if(isset($this->POST['cadastrar-obra'])){
                    $podeCadastrarObra = true;
                }
                if(isset($this->POST['editar-obra'])){
                    $podeEditarObra = true;
                }
                if(isset($this->POST['remover-obra'])){
                    $podeRemoverObra = true;
                }
                if(isset($this->POST['cadastrar-noticia'])){
                    $podeCadastrarNoticia = true;
                }
                if(isset($this->POST['editar-noticia'])){
                    $podeEditarNoticia = true;
                }
                if(isset($this->POST['remover-noticia'])){
                    $podeRemoverNoticia = true;
                }
                if(isset($this->POST['realizar-backup'])){
                    $podeRealizarBackup = true;
                }
                    
                $campos = array(
                    'funcao'=>$funcao,
                    'cadastraObra'=> $podeCadastrarObra ? 1:0,
                    'gerenciaObra'=> $podeEditarObra ? 1:0,
                    'remocaoObra'=>$podeRemoverObra ? 1:0,
                    'cadastraNoticia'=>$podeCadastrarNoticia ? 1:0,
                    'gerenciaNoticia'=>$podeEditarNoticia ? 1:0,
                    'remocaoNoticia'=>$podeRemoverNoticia ? 1:0,
                    'backup'=>$podeRealizarBackup ? 1:0
                );

                $funcionarioDAO = new FuncionarioDAO();
                $funcionarioDAO->alterar($campos,array('matricula'=>$matricula)); 
            }
            else{
                throw new NivelDeAcessoInsuficienteException();
            }
        }
    }

    protected function removerFuncionario(){
        if($this->verificarFuncionario() == 'Administrador') {
            if(ValidacaoDados::validarForm($this->POST,array('senhaAdmin','matriculaFuncionario'))){  
                $matricula = $this->POST['matriculaFuncionario'];
                $senha = md5($this->POST['senhaAdmin']);

                $adminDAO = new UsuarioDAO();
                $adminDAO = $adminDAO->buscar(array('senha',array("tipoUsuario"=>"ADMINISTRADOR")));
                $senhaArmazenada = $adminDAO[0]->getSenhaAdmin();

                if(strcmp($senhaArmazenada,$senha)==0){// Se a senha do administrador estiver correta, IMPLEMENTAR....
                    $funcionarioDao = new FuncionarioDAO();
                    $funcionarioDao->remover(array('matricula'=>$matricula));
                }else{
                    throw new SenhaIncorretaException();
                }
            }
        }
        else{
            throw new NivelDeAcessoInsuficienteException();
        }
    }


}

?>