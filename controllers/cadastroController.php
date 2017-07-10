<?php
namespace controllers;

require_once dirname(__DIR__).'/vendor/autoload.php';
use \exceptions\NomeInvalidoException as NomeInvalidoException;
use \exceptions\SobrenomeInvalidoException as SobrenomeInvalidoException;
use \exceptions\SenhaInvalidaException as SenhaInvalidaException;
use \exceptions\EmailInvalidoException as EmailInvalidoException;
use \exceptions\EmailJaCadastradoException as EmailJaCadastradoException;
use \exceptions\DadosCorrompidosException as DadosCorrompidosException;
use \exceptions\EmailNaoEnviadoException as EmailNaoEnviadoException;
use \exceptions\UsuarioInexistenteException as UsuarioInexistenteException;
use \exceptions\ErroCadastroException as ErroCadastroException;
use \DAO\usuarioDAO as usuarioDAO;
use \util\GerenciarSenha as GerenciarSenha;
use \util\ValidacaoDados as ValidacaoDados;
use \models\Usuario as Usuario;

class cadastroController extends mainController
{

    /**
    * Configura a classe para realização de teste.
     * @param String $email email do usuário
     * @param String $nome nome do usuário
     * @param String $sobrenome sobrenome do usuário
     * @param String $senha senha do usuário
     */
    public function configuraAmbienteParaTeste($nome, $sobrenome, $email, $senha, $id) {
        $_POST = array("nome" => $nome,
        "sobrenome" => $sobrenome,
        "email" => $email,
        "senha" => $senha);

        $_GET = array("i" => $id, 
        "n" => md5($nome),
        "e" => md5($email),
        "s" => md5($sobrenome));

        if(!defined('ABSPATH')) {
            define("ABSPATH", dirname(dirname( __FILE__ )));
        }

        if(!defined('URI_BASE')) {
            define("URI_BASE","http://"."localhost"."/"."cadastro"."/index.php");
        }

        $ds = DIRECTORY_SEPARATOR;
	    $pasta = explode($ds,getcwd());
	    $pasta = end($pasta);

        if(!defined('ROOT_URL')) {
            define('ROOT_URL',"http://".$_SERVER['SERVER_NAME']."/".$pasta."/");
        }
        
    }

    protected $dados = array();
    /**
    * Cadastra novo usuário.
    */
    public function index() {   
        if(!isset($_SESSION['nome']) || empty($_SESSION['nome'])){  
            if (ValidacaoDados::validarForm($_POST, array("nome","sobrenome","email","senha"))) {
                try{
                    $usuarioDAO = new UsuarioDAO();
                    $email = addslashes($_POST["email"]);
                    $usuario = $usuarioDAO->buscar(array(), array("email"=>$email));

                    if(count($usuario) > 0) { //verifica se já existe usuário cadastrado
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
                    
                    $nome = addslashes($_POST["nome"]);
                    $sobrenome = addslashes($_POST["sobrenome"]);
                    $senha = GerenciarSenha::criptografarSenha($_POST["senha"]);
                    $email = addslashes($_POST["email"]);

                    $usuarioDAO->inserir(new Usuario(null, $email, $nome, $sobrenome, $senha, false,'USUARIO'));
                    $usuario = $usuarioDAO->buscar(array(), array("email"=>$email))[0]; //Busca o usuário récem cadastrado
                    
                    if($this->confirmar(array("nome" => $usuario->getNome(),"email" => $usuario->getEmail(),
                                    "id" => $usuario->getId()))){
                    echo "<script>window.location.replace('".ROOT_URL."cadastro/confirmar"."');</script>"; // Redireciona a página
                    }
                }catch(EmailJaCadastradoException $e){
                    $this->dados['exception'] = $e->getMessage();
                }catch(NomeInvalidoException $e){
                    $this->dados['exception'] = $e->getMessage();
                }catch(SobrenomeInvalidoException $e){
                    $this->dados['exception'] = $e->getMessage();
                }catch(SenhaInvalidaException $e){
                    $this->dados['exception'] = $e->getMessage();
                }catch(EmailInvalidoException $e){
                    $this->dados['exception'] = $e->getMessage();
                }catch(EmailNaoEnviadoException $e){
                    $this->dados['exception'] = $e->getMessage();
                }
                
            }
            $this->carregarConteudo('cadastro',$this->dados);
        }else{//Se o usuário já estiver logado
            $this->redirecionarPagina('home');
        }  
    }

    /**
    * Envia um email de confirmação para o usuário
    * @param unknown $dados - dados do usuário
    */
    public function confirmar($dados) {
        if (ValidacaoDados::validarForm($dados, array("email","id","nome"))) { 

            $id = addslashes($dados['id']);
            $nome = addslashes($dados['nome']);
            $email = addslashes($dados['email']);
            $linkConfirmacao = ROOT_URL."cadastro/verificar/?e=".md5($email)."&i=".$id;

            require_once(ABSPATH.'/plugins/PHPMailer/PHPMailerAutoload.php');
            
            $mail = new \PHPMailer();
            
            $mail->isSMTP();                                      // Set mailer to use SMTP
            $mail->Host = 'smtp.gmail.com';  // Specify main and backup SMTP servers
            $mail->SMTPAuth = true;                               // Enable SMTP authentication
            $mail->Username = 'websertour@gmail.com';                 // SMTP username
            $mail->Password = 'sertourweb';                           // SMTP password
            $mail->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
            $mail->Port = 587;                                    // TCP port to connect to
            $mail->CharSet = 'UTF-8';
            
            $mail->SMTPOptions = array(
                'ssl' => array(
                    'verify_peer' => false,
                    'verify_peer_name' => false,
                    'allow_self_signed' => true
                )
            );

            $mail->setFrom('websertour@websertour.com', 'Sertour');
            $mail->addAddress($email, $nome);     // Add a recipient
            $mail->addReplyTo('noreply@gmail.com', 'Não responda');
            
            $mail->isHTML(true);                                  // Set email format to HTML
            
            $mail->Subject = 'Sertour - Confirmação de cadastro';
            $mail->Body    = "Olá, ".$nome.". Seja bem-vindo(a) ao WebMuseu Casa do Sertão, ficamos felizes com a sua presença!<br/><br/>"
                    ."Seu cadastro está quase pronto, por favor,"
                            ." clique no link a seguir e a gente cuida do resto :)<br/><br/>".
                            "Link de Confirmação: ".$linkConfirmacao;
            
            if (!$mail->send()) {
                throw new EmailNaoEnviadoException();
            }else{
                return true;
            }
        }

        $this->carregarConteudo('confirmacaoEmail',$this->dados);
    }
    
    /**
    * Confirma e ativa a conta do usuário
    */
    public function verificar() {
        $id = $_GET['i'];
        $email = $_GET['e'];

        $usuarioDao = new UsuarioDAO();
        $usuario = $usuarioDao->buscar(null, array("idUsuario"=>$id));
        
        if (count($usuario)>0) {
            $usuario = array_shift($usuario);
            $id = $usuario->getId();
            $emailMd5 = md5($usuario->getEmail());
            
            if (strcmp($email, $emailMd5)==0) {
                $usuario->setCadastroConfirmado(true);
                $usuarioDao->alterar(array('cadastroConfirmado'=>1), array('idUsuario'=>$usuario->getId()));
            }
        } else {
            throw new UsuarioInexistenteException();
        }        
    }
	
    /**
    * Realiza o cadastro de um usuário que cadastra-se no sistema através do Google.
    * @param array $usuarioGoogle - array contendo os dados do usuário
    */
    public function cadastrarUsuarioGoogle($usuarioGoogle) {
        $usuarioDao = new UsuarioDAO();
        
        //Recebe os dados
        $idGoogle = $usuarioGoogle['id'];
        $nome = $usuarioGoogle['modelData']['name']['givenName'];
        $sobrenome = $usuarioGoogle['modelData']['name']['familyName'];
        $email = $usuarioGoogle['modelData']['emails'][0]['value'];
        
        //Cria um novo usuário
        $usuario = new Usuario(null,$email,$nome,$sobrenome,null,true,'USUARIO');
        $usuarioDao->inserir($usuario);

        $idSistema = $usuarioDao->buscar(array("idUsuario"),array("email"=>$email));//Recupera o usuário inserido

        if(count($idSistema)>0){
            $usuarioDao->inserirUsuarioContaExterna($idGoogle,$idSistema[0]->getId(),"google");
        }else{
            throw new ErroCadastroException();
        } 
        
    }

    /**
    * Realiza o cadastro de um usuário que cadastra-se no sistema através do facebook.
    * @param array $dados - array contendo os dados do usuário
    */
    public function cadastrarUsuarioFacebook(array $dados) {
        $usuarioDAO = new UsuarioDao();

        //criando um usuário e registrando
        $usuario = new Usuario(null, $dados['email'], $dados['nome'], $dados['sobrenome'], null, true,'USUARIO');
        $usuarioDAO->inserir($usuario);

        $usuarioCadastrado = $usuarioDAO->buscar(array('idUsuario'), array('email'=>$dados['email'])); //obtém o usuário cadastrado recentemente

        if(count($usuarioCadastrado) > 0) { //se o usuário for encontrado
            $usuarioCadastrado = $usuarioCadastrado[0];
            $usuarioDAO->inserirUsuarioContaExterna($dados['fb_id'],$usuarioCadastrado->getID(),"facebook");
        } else {
            throw new ErroCadastroException();
        }

    }

}
