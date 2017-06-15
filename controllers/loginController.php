<?php

class loginController {

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

            $usuario = $this->login($email, $senha);
            if($usuario){//verifica a existencia do usuário que tentou logar
                header("Location: home.php"); //caso exista, é redirecinado para a página principal do sistema
            }
            else{
                header("Location: index.php");//caso não existe usuario com esse login, ele continua na pagina
            }
        }
  
    }

    /**
    * Realiza o login do usuário
    * @param String $email, $senha
    */
    private function login($email, $senha){
        //Crio dois arrays para usar na busca do usuario. 
        $campos = array("nome","email", "senha");
        $filtro = array(
            "email" => $email,
            "senha" => $senha,
        );
        $usuarioDAO = new UsuarioDAO();
        $usuario = $usuarioDAO->buscar($campos, $filtro);//Recebe o objeto do usuario que vai logar
        if(count($usuario) > 0){ //Verifica se existe usuario
        //Inicia uma sessão e guarda os dados para persistirem ao longo da execução do sistema
            session_start();
            $_SESSION['nome'] = $usuario[0]->getNome();
            $_SESSION['sobrenome'] = $usuario[0]->getSobrenome();
            $_SESSION['email'] = $usuario[0]->getEmail();
            return true;
        }
        else{
            return false;
        }
    }

    /**
    * Realiza o logout do usuário
    */
    public function logout(){
        // Inicializa a sessão.
        session_start();
        // Apaga todas as variáveis da sessão
        $_SESSION = array();
        // Se é preciso matar a sessão, então os cookies de sessão também devem ser apagados.
        // Isto destruirá a sessão, e não apenas os dados!
        if (ini_get("session.use_cookies")) {
            $params = session_get_cookie_params();
            setcookie(
                session_name(), '', time() - 42000,
                $params["path"], $params["domain"],
                $params["secure"], $params["httponly"]
            );
        }
        // Por último, destrói a sessão
        session_destroy();
    }

     /**
    * Verifica se determinado campo tem informação.
    * @return <code>true</code>, se houver informação; <code>false</code>, caso contrário
    */
    private function validarCampo($campo) {
        if (isset($campo) && !empty($campo)) {
            return true;
        }
        return false;
    }

    /**
    * Verifica se a senha informada é válida, isto é, se possui ao menos 8 e no máximo 32 caracteres.
    * @return <code>true</code>, se a senha informada for válida; <code>false</code>, caso contrário.
    */
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

    /**
    * Verifica se o email informado é válido.
    * @return <code>true</code>, se o email informado for válido; <code>false</code>, caso contrário.
    */
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

    /**
    *Verifica a integridade do array de informações recebidas
    *@return <code>true</code>, se o array estiver íntegro; <code>false</code>, caso contrário
    */
    private function validarForm($dados) {
        if (array_key_exists("email", $dados) && array_key_exists("senha", $dados)) {
            return true;
        }
        return false;
    }

}

?>