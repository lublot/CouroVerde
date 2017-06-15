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

        if ($this->validarForm($this->POST)) {
            $email = addslashes($this->POST["email"]);
            //$senha = GerenciarSenha::criptografarSenha($this->POST["senha"]);
            $senha = $this->POST["senha"];

            /*if (!$this->validarSenha($senha)) {
                throw new SenhaInvalidaException();
            } 
            if (!$this->validarEmail($email)) {
                throw new EmailInvalidoException();
            }*/

            $usuario = $this->login($email, $senha);
            if($usuario){//verifica a existencia do usuário que tentou logar
                header("Location: home.php"); //caso exista, é redirecinado para a página principal do sistema
            }
            else{
               header("Location: index.php");//caso não existe usuario com esse login, ele continua na pagina
            }
        }
  
    }

    private function login($email, $senha){
        $campos = array("email", "senha");
        $filtro = array(
            "email" => $email;
            "senha" => $senha;
        );

        $usuarios = $this->usuarioDAO->buscar($campos, $filtro);
        if(count($usuarios) > 1){
            session_start();
            $_SESSION['email'] = $usuario[0]->email;
            $_SESSION['senha'] = $usuario[0]->senha;
            $this->isLogged = true;
            return true;
        }
        else{
            return false;
        }
    }

    private function logout(){
        session_start();
        $_SESSION = array();
        if (ini_get("session.use_cookies")) {
            $params = session_get_cookie_params();
            setcookie(
                session_name(), '', time() - 42000,
                $params["path"], $params["domain"],
                $params["secure"], $params["httponly"]
            );
        }
        session_destroy();
    }

     private function validarCampo($campo) {
        if (isset($campo) && !empty($campo)) {
            return true;
        }
        return false;
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
}

?>