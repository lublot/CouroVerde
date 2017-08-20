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
use \util\VerificarPermissao as VerificarPermissao;
use \util\GerenciarSenha as GerenciarSenha;
use \util\ValidacaoDados as ValidacaoDados;
use \models\Funcionario as Funcionario;

if(!isset($_SESSION)){session_start();}
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

    protected $dados = array();

    public function index(){
        if(VerificarPermissao::isAdministrador()){
            $this->carregarConteudo('homeFuncionario',array());
        }else{
            $this->carregarConteudo('permissaoNegada',array());
        }
    }
    /**
    * Realiza o cadastro de um funcionário.
    */
    public function cadastrar() {
        
            if(VerificarPermissao::isAdministrador()){
                
                try{
                    if(isset($_POST) && !empty($_POST)){
                        if (ValidacaoDados::validarForm($_POST, array("nome","sobrenome","email","senha", "matricula", "funcao"))) {
                            $funcionarioDAO = new FuncionarioDAO();
                            $usuarioDAO = new UsuarioDAO();

                            $email = addslashes($_POST["email"]);
                            $funcionario = $funcionarioDAO->buscar(array(), array("email"=>$email));

                            /*if(count($funcionario) > 0) { //verifica se já existe usuário cadastrado
                                throw new EmailJaCadastradoException();
                            }*/

                            if (!ValidacaoDados::validarNome($_POST["nome"])) {
                                throw new NomeInvalidoException("O nome não pode conter números ou ser vazio.");
                            }

                            if (!ValidacaoDados::validarNome($_POST["sobrenome"])) {
                                throw new SobrenomeInvalidoException("O sobrenome não pode conter números ou ser vazio.");
                            }
                                
                            if (!ValidacaoDados::validarSenha($_POST["senha"])) {
                                throw new SenhaInvalidaException("A senha deve conter entre 8 e 32 caracteres.Não são permitidos espaços.");
                            }
                                
                            if (!ValidacaoDados::validarEmail($_POST["email"])) {
                                throw new EmailInvalidoException("Insira um email válido.");
                            }

                            if (!ValidacaoDados::validarMatricula($_POST["matricula"])) {
                                throw new MatriculaInvalidaException("Insira uma matrícula válida.");
                            }

                            if (!ValidacaoDados::validarNome($_POST["funcao"])) {
                                throw new NomeInvalidoException("O campo função não pode conter números ou ser vazio");
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
                            
                            $novoFuncionario = new Funcionario(null, $email, $nome, $sobrenome, $senha, 1, "FUNCIONARIO",
                            $matricula, $funcao, $podeCadastrarObra, $podeGerenciarObra, $podeRemoverObra, $podeCadastrarNoticia,
                            $podeGerenciarNoticia, $podeRemoverNoticia, $podeRealizarBackup);

                            $funcionarioDAO->inserir($novoFuncionario);

                            //Registra a ação que o funcionario acabou de fazer
                            $idUsuario = $funcionarioDAO->getUltimoIdInserido();
                            $logController = new LogController();
                            $logController->registrarEvento($idUsuario, "FUNCIONARIO", "Um funcionário foi cadastrado");

                            $this->redirecionarPagina('funcionario');
                        }else {
                            throw new DadosCorrompidosException();
                        }
                    }
                }
                catch(NomeInvalidoException $e){
                    $this->dados['exception'] = $e->getMessage();
                }
                catch(SobrenomeInvalidoException $e){
                    $this->dados['exception'] = $e->getMessage();
                }
                catch(EmailInvalidoException $e){
                    $this->dados['exception'] = $e->getMessage();
                }
                catch(MatriculaInvalidaException $e){
                    $this->dados['exception'] = $e->getMessage();
                }
                catch(Exception $e){
                    $this->dados['exception'] = $e->getMessage();
                }
                    
                $this->carregarConteudo('cadastroFuncionario',$this->dados);
            }else {
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

    public function gerenciar($parametros){
        if(VerificarPermissao::isAdministrador()){
            $matricula = array_shift($parametros);

            $funcionarioDAO = new FuncionarioDAO();
            $funcionarioDAO = $funcionarioDAO->buscar(array(),array("matricula"=>$matricula));
            
            if(count($funcionarioDAO)>0){
                $this->dados['matricula'] = $matricula;
                $this->dados['nome'] = $funcionarioDAO[0]->getNome();
                $this->dados['sobrenome'] = $funcionarioDAO[0]->getSobrenome();
                $this->dados['funcao'] = $funcionarioDAO[0]->getFuncao();
                $this->dados['email'] = $funcionarioDAO[0]->getEmail();
                $this->dados['podeCadastrarObra'] = $funcionarioDAO[0]->isPodeCadastrarObra();
                $this->dados['podeGerenciarObra'] = $funcionarioDAO[0]->isPodeGerenciarObra();
                $this->dados['podeRemoverObra'] = $funcionarioDAO[0]->isPodeRemoverObra();
                $this->dados['podeCadastrarNoticia'] = $funcionarioDAO[0]->isPodeCadastrarNoticia();
                $this->dados['podeGerenciarNoticia'] = $funcionarioDAO[0]->isPodeGerenciarNoticia();
                $this->dados['podeRemoverNoticia'] = $funcionarioDAO[0]->isPodeRemoverNoticia();
                $this->dados['podeRealizarBackup'] = $funcionarioDAO[0]->isPodeRealizarBackup();
            }else{
                $this->dados['alerta'] = "Funcionário não encontrado";
            }
            
            $this->carregarConteudo('gerenciarFuncionario',$this->dados);
        }else{
            $this->permissaoNegada();
        }
    }

    public function gerenciarFuncionario(){
        if(VerificarPermissao::isAdministrador()) {
            if(ValidacaoDados::validarForm($_POST,array('matricula','funcao','nome','sobrenome','email'))){
                $matricula = $_POST['matricula'];
                $nome = $_POST['nome'];
                $sobrenome = $_POST['sobrenome'];
                $email = $_POST['email'];
                $funcao = $_POST['funcao'];
                $podeCadastrarObra = false; $podeEditarObra = false;
                $podeRemoverObra = false; $podeCadastrarNoticia = false;
                $podeRemoverNoticia = false; $podeEditarNoticia = false;
                $podeRealizarBackup = false;

                
                if(isset($_POST['cadastrarObra']) && strcmp($_POST['cadastrarObra'],'on')==0){
                    $podeCadastrarObra = true;
                }
                if(isset($_POST['editarObra']) && strcmp($_POST['editarObra'],'on')==0){
                    $podeEditarObra = true;
                }
                if(isset($_POST['removerObra']) && strcmp($_POST['removerObra'],'on')==0){
                    $podeRemoverObra = true;
                }
                if(isset($_POST['cadastrarNoticia']) && strcmp($_POST['cadastrarNoticia'],'on')==0){
                    $podeCadastrarNoticia = true;
                }
                if(isset($_POST['editarNoticia']) && strcmp($_POST['editarNoticia'],'on')==0){
                    $podeEditarNoticia = true;
                }
                if(isset($_POST['removerNoticia']) && strcmp($_POST['removerNoticia'],'on')==0){
                    $podeRemoverNoticia = true;
                }
                if(isset($_POST['realizarBackup']) && strcmp($_POST['realizarBackup'],'on')==0){
                    $podeRealizarBackup = true;
                }
                    
                $campos = array(
                    'funcao'=>$funcao,
                    'cadastroObra'=> $podeCadastrarObra ? 1:0,
                    'gerenciaObra'=> $podeEditarObra ? 1:0,
                    'remocaoObra'=>$podeRemoverObra ? 1:0,
                    'cadastroNoticia'=>$podeCadastrarNoticia ? 1:0,
                    'gerenciaNoticia'=>$podeEditarNoticia ? 1:0,
                    'remocaoNoticia'=>$podeRemoverNoticia ? 1:0,
                    'backup'=>$podeRealizarBackup ? 1:0
                );
               
                $camposUsuario = array(
                    'nome'=>$nome,
                    'sobrenome'=>$sobrenome,
                    'email'=>$email
                );

                $funcionarioDAO = new FuncionarioDAO();
                $idUsuario = $funcionarioDAO->buscar(array('idUsuario'),array('matricula'=>$matricula));
                $funcionarioDAO->alterar($campos,array('matricula'=>$matricula));

                $usuarioDAO = new UsuarioDAO();
                $usuarioDAO->alterar($camposUsuario,array('idUsuario'=>$idUsuario[0]->getId()));

                //Registra a ação que o funcionario acabou de fazer
                $logController = new LogController();
                $logController->registrarEvento($idUsuario[0]->getId(), "FUNCIONARIO", "Um funcionário foi alterado");

                echo json_encode(array('success'=>true));
            }
            else{
                $this->permissaoNegada();
            }
        }
    }

    public function remover(){
        if(VerificarPermissao::isAdministrador()) {
            if(ValidacaoDados::validarForm($_POST,array('senhaAdmin','matriculaFuncionario'))){  
                $matricula = $_POST['matriculaFuncionario'];
                $senha = md5($_POST['senhaAdmin']);

                $adminDAO = new UsuarioDAO();
                $adminDAO = $adminDAO->buscar(array('senha'),array("tipoUsuario"=>"ADMINISTRADOR"));
                $senhaArmazenada = $adminDAO[0]->getSenha();

                if(strcmp($senhaArmazenada,$senha)==0){// Se a senha do administrador estiver correta, IMPLEMENTAR....
                    $funcionarioDao = new FuncionarioDAO();
                    $funcionario = $funcionarioDao->buscar(array(),array("matricula"=>$matricula));
                    $userDAO = new UsuarioDAO();
                    $userDAO->alterar(array("tipoUsuario"=>"USUARIO"),array("idUsuario"=>$funcionario[0]->getId()));

                    $funcionarioDao->remover(array('matricula'=>$matricula));

                    //Registra a ação que o funcionario acabou de fazer
                    $logController = new LogController();
                    $logController->registrarEvento($funcionario[0]->getId(), "FUNCIONARIO", "Um funcionário foi removido");
                    
                    echo json_encode(array("success"=>true));
                }else{
                    echo json_encode(array("success"=>false,"erro"=>"Senha Incorreta"));
                }
            }
        }
        else{
            $this->permissaoNegada();
        }
    }

    /**
    * Busca todos os funcionarios sem filtro
    */
    public function buscarTodosFuncionarios(){
        $funcionarioDAO = new funcionarioDAO();
        $resultados = $funcionarioDAO->buscarFuncionarioPorCampo(array(), array());

        return $resultados;
    }

    /**
    * Busca funcionarios pelo nome
    */
    public function buscarFuncionarioPorNome(){
        if(isset($_POST['nome'])){
            $funcionarioDAO = new funcionarioDAO();
            $resultados = $funcionarioDAO->buscarFuncionarioPorCampo('nome', $_POST['nome']);

            return $resultados;
        }
    }

    /**
    * Buscar funcionarios pelo sobrenome
    */
    public function buscarFuncionarioPorSobrenome(){
        if(isset($_POST['sobrenome'])){
            $funcionarioDAO = new funcionarioDAO();
            $resultados = $funcionarioDAO->buscarFuncionarioPorCampo('sobrenome', $_POST['sobrenome']);

            return $resultados;
        }
    }

    /**
    * Busca funcionarios pelo email
    */
    public function buscarFuncionarioPorEmail(){
        if(isset($_POST['email'])){
            $funcionarioDAO = new funcionarioDAO();
            $resultados = $funcionarioDAO->buscarFuncionarioPorCampo('email', $_POST['email']);

            return $resultados;
        }
    }

    /**
    * Busca funcionarios pela matricula
    */
    public function buscarFuncionarioPorMatricula(){
        if(isset($_POST['matricula'])){
            $funcionarioDAO = new funcionarioDAO();
            $resultados = $funcionarioDAO->buscarFuncionarioPorCampo('matricula', $_POST['matricula']);

            return $resultados;
        }
    }

    public function listarTodosFuncionarios(){
        if(VerificarPermissao::isAdministrador()){
            $funcionarioDAO = new FuncionarioDAO();
            if(isset($_POST['titulo']) && !empty($_POST['titulo'])){
                $funcionarioDAO = $funcionarioDAO->buscarLikeNome($_POST['titulo']);
            }else{
                $funcionarioDAO = new FuncionarioDAO();
                $funcionarioDAO = $funcionarioDAO->buscar(array(),array());  
            }
            echo json_encode($funcionarioDAO);
        }else{
            $this->permissaoNegada();
        }   
    }

}

?>