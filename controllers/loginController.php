<?php

class loginController {

    private $usuarioDAO;
    private $POST = array(
        "email" => "diegosantos94@live.com",
        "senha" => "12345678");

    public function __construct(){
        $this->usuarioDAO = new UsuarioDAO();
    }
    
    //Login do usuário
    public function index(){
        require_once(ABSPATH.'/util/GerenciarSenha.php');
        if ($this->validarForm($_POST)) {
            $email = addslashes($_POST["email"]);
            $senha = GerenciarSenha::criptografarSenha($_POST["senha"]);

            if (!$this->validarSenha($senha)) {
                throw new SenhaInvalidaException();
            } 
            if (!$this->validarEmail($email)) {
                throw new EmailInvalidoException();
            }
            if($this->verificarSeUsuarioExiste($email)) {
				throw new EmailJaCadastradoException();
			}

            $usuario = $this->usuarioDAO->login($email, $senha);
            if($usuario){//verifica a existencia do usuário que tentou logar
                header("Location: home.php"); //caso exista, é redirecinado para a página principal do sistema
            }
            else{
                header("Location: index.php");//caso não existe usuario com esse login, ele continua na pagina
            }
        }
  
    }

    private function validarSenha($senha) {
        if (!$this->validarCampo($senha)) {
            return false;
        }

        $tamanho = strlen($senha); //obtém tamanho da senha
        if ($tamanho < 8 || $tamanho > 32) { //verifica se o tamanho da senha é adequado
            return true;
        }

        return false;
    }

    private function validarEmail($email) {
        if (!$this->validarCampo($email)) {
            return false;
        }
        
        $dividido = explode("@", $email); //tenta dividir o email a partir da @
        
        if (count($dividido) == 2) { //verifica se o email informado possui @
            $segundaparte = explode(".com", $dividido[1]); //tenta encontrar .com na segunda parte do email
            
            if (count($segundaparte) == 2) { //verifica se tem apenas um .com no email
                return true;
            }
        }

        return false;
    }

    private function validarForm($dados) {
        if (array_key_exists("email", $dados) && array_key_exists("senha", $dados)) {
            return true;
        }
        return false;
    }

    public function logout(){
        if($this->usuarioDAO->isLogged == true){
            $this->usuarioDAO->logout();
        }
    }

    /**
    * Obtém um usuário cadastrado através do seu email.
    *@param unknown $email - email do usuário
	*@return <code>true</code>, caso exista um usuário com o email informado; <code>NULL</code>, caso contrário.
    */
	private function verificarSeUsuarioExiste($email) {
		$usuarioDAO = new UsuarioDAO();
		$usuario = $usuarioDAO->buscar(array(), array("email"=>$email))[0]; //tenta obter usuário
		
		if(count($usuario) == 0) {
			return false;
		}
		return true;
	}
}

?>