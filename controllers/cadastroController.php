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

class cadastroController 
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

        
    }

    /**
    * Cadastra novo usuário.
    */
    public function index() {        
        if (ValidacaoDados::validarForm($_POST, "cadastro")) {
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

            $usuarioDAO->inserir(new Usuario(null, $email, $nome, $sobrenome, $senha, false));
            $usuario = $usuarioDAO->buscar(array(), array("email"=>$email))[0]; //Busca o usuário récem cadastrado
            $this->confirmar(array("nome" => $usuario->getNome(),
                               "sobrenome" => $usuario->getSobrenome(),
                               "senha" => $usuario->getSenha(),
                               "email" => $usuario->getEmail(),
                               "id" => $usuario->getId()));
                echo "<script>window.location.replace('".URI_BASE."/cadastro/confirmar"."');</script>"; // Redireciona a página
        } else {
            throw new DadosCorrompidosException();
        }
    }

    /**
    * Envia um email de confirmação para o usuário
    * @param unknown $dados - dados do usuário
    */
    public function confirmar($dados) {
        if (ValidacaoDados::validarForm($dados, "cadastro")) { //essa validação já foi feita anteriormente, precisa fazer de novo?
            //Acho que as validações abaixo são desnecessárias pq já foram feitas no método anterior.
            //Se os campos abaixo forem inválidos retornam exceções
            if (!ValidacaoDados::validarNome($dados['nome'])) {
                throw new NomeInvalidoException();
            }

            if (!ValidacaoDados::validarNome($dados['sobrenome'])) {
                throw new SobrenomeInvalidoException();
            }

            if (!ValidacaoDados::validarSenha($dados['senha'])) {
                throw new SenhaInvalidaException();
            }

            if (!ValidacaoDados::validarEmail($dados['email'])) {
                throw new EmailInvalidoException();
            }

            if (!ValidacaoDados::validarCampo($dados['id'])) {
                throw new DadosCorrompidosException();
            }
            
            $id = addslashes($dados['id']);
            $nome = addslashes($dados['nome']);
            $sobrenome = addslashes($dados['sobrenome']);
            $email = addslashes($dados['email']);
            
            $linkConfirmacao = URI_BASE."/cadastro/verificar/?n=".md5($nome)."&e=".md5($email)."&i=".$id."&s=".md5($sobrenome);

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
            }
        } else {
            throw new DadosCorrompidosException();
        }
    }
    
    /**
    * Confirma e ativa a conta do usuário
    */
    public function verificar() {
        $id = $_GET['i'];
        $nome = $_GET['n'];
        $email = $_GET['e'];
        $sobrenome = $_GET['s'];
        
        $usuarioDao = new UsuarioDAO();
        $usuario = $usuarioDao->buscar(null, array("idUsuario"=>$id));
        
        if (count($usuario)>0) {
            $usuario = array_shift($usuario);
            $id = $usuario->getId();
            $nomeMd5 = md5($usuario->getNome());
            $emailMd5 = md5($usuario->getEmail());
            $sobrenomeMd5 = md5($usuario->getSobrenome());
            
            if (strcmp($nome, $nomeMd5)==0 && strcmp($email, $emailMd5)==0 && strcmp($sobrenome, $sobrenomeMd5)==0) {
                $usuario->setCadastroConfirmado(true);
                $usuarioDao->alterar(array('cadastroConfirmado'=>$usuario->confirmouCadastro()), array('idUsuario'=>$usuario->getId()));
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
        $usuario = new Usuario(null,$email,$nome,$sobrenome,null,true);
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
        $usuario = new Usuario(null, $dados['email'], $dados['nome'], $dados['sobrenome'], null, true);
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
