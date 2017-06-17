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
    * Realiza a autenticação via Google+
    **/
    public function acessarGoogle(){
        session_start();
        require_once (ABSPATH.'/vendor/credentialsConfig.php');

        // $service implements the client interface, has to be set before auth call
        $service = new Google_Service_Plus($client);

        if (isset($_GET['code'])) { // we received the positive auth callback, get the token and store it in session
            $client->authenticate($_GET['code']);
            $_SESSION['token'] = $client->getAccessToken();
        }

        if (isset($_SESSION['token'])) { // extract token from session and configure client
            $token = $_SESSION['token'];
            $client->setAccessToken($token);
        }

        if (!$client->getAccessToken()) { // auth call to google
            $authUrl = $client->createAuthUrl();
            header("Location: ".$authUrl);
            die;
        }
        $me = $service->people->get('me');
        $filtros = array("idUsuarioGoogle"=>$me['id']);

        $usuarioDao = new UsuarioDAO();
        $usuario = $usuarioDao->buscarUsuarioContaExterna(array("idUsuarioGoogle"),array("idUsuario","nome","sobrenome","email","cadastroConfirmado"),$filtros,"google");
        
        if(count($usuario)>0){//Se o usuário estiver cadastrado...
            $_SESSION = array();//Limpa os dados de token
            $_SESSION['nome'] = $usuario[0]->getNome();
            $_SESSION['sobrenome'] = $usuario[0]->getSobrenome();
            $_SESSION['email'] = $usuario[0]->getEmail();

            //Redireciona para a home configurada como de usuário
        }else{
            $cadastro = new cadastroController();
            $cadastro->cadastrarUsuarioGoogle($me);
            //Redireciona para página confirmando cadastro
        }
    }

    /**
    * Realiza a autenticação do login via Facebook.
    **/
    public function acessoFacebook() {
        require_once __DIR__ . '/php-graph-sdk-5.4/src/Facebook/autoload.php';

        $fb = new Facebook\Facebook([
        'app_id' => '1435160229855766',
        'app_secret' => 'fa696e39b476a2c926ff6f2fa080532d',
        'default_graph_version' => 'v2.9',
        ]);

        $helper = $fb->getRedirectLoginHelper();
        if (isset($_GET['state'])) {
            var_dump($_GET);
            $helper->getPersistentDataHandler()->set('state', $_GET['state']);
        }

        try {
            $accessToken = $helper->getAccessToken();
        } catch (Facebook\Exceptions\FacebookResponseException $e) {
            throw new AcessoExternoErroException($e->getSubErrorCode());
            exit;
        } catch (Facebook\Exceptions\FacebookSDKException $e) {
            throw new AcessoExternoErroException('SDK');
            exit;
        }

        if (! isset($accessToken)) {
            throw new AcessoExternoNegadoException();
            exit;
        }

        // Logged in
        // The OAuth 2.0 client handler helps us manage access tokens
        $oAuth2Client = $fb->getOAuth2Client();

        // Get the access token metadata from /debug_token
        $tokenMetadata = $oAuth2Client->debugToken($accessToken);

        // Validation (these will throw FacebookSDKException's when they fail)
        $tokenMetadata->validateAppId($tokenMetadata->getAppId());
        // If you know the user ID this access token belongs to, you can validate it here
        //$tokenMetadata->validateUserId('123');
        $tokenMetadata->validateExpiration();


        if (! $accessToken->isLongLived()) {
        
            try {
                $accessToken = $oAuth2Client->getLongLivedAccessToken($accessToken);
            } catch (Facebook\Exceptions\FacebookSDKException $e) {
                throw new AcessoExternoErroException('SDK_LONG_LIVED_ACESS_TOKEN');
                exit;
            }
        }

        $_SESSION['fb_access_token'] = (string) $accessToken;

        $response = $fb->get('/me?fields=first_name,last_name,email', $accessToken);
        $graph = $response->getGraphUser();

        $usuarioDao = new UsuarioDAO();
        $usuario = $usuarioDao->buscarUsuarioContaExterna(array($graph->getId()),array("idUsuario","nome","sobrenome","email","cadastroConfirmado"),$filtros,"facebook");
        
        if(count($usuario)>0){//Se o usuário estiver cadastrado...
            $usuario = $usuario[0];
            $_SESSION = array();//Limpa os dados de token
            $_SESSION['nome'] = $usuario->getNome();
            $_SESSION['sobrenome'] = $usuario->getSobrenome();
            $_SESSION['email'] = $usuario->getEmail();
            //Falta redirecionar usuário
        }else{
            $cadastro = new cadastroController();
            $cadastro->cadastrarUsuarioFacebook([
                'fb_id' => $graph->getId(),
                'nome' => $graph->getFirstName(),
                'sobrenome' => $graph->getLastName(),
                'email' => $graph->getEmail()
            ]);
            //Falta redirecionar usuário
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
        if ($tamanho < 8 || $tamanho >= 32) { //verifica se o tamanho da senha é adequado
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

    /**
    *Verifica a integridade do array do e-mail recebido
    *@return <code>true</code>, se o array estiver íntegro; <code>false</code>, caso contrário
    */
    private function validarFormEmail($dados) {
        if(array_key_exists("email", $dados)) {
            return true;
        }
        return false;
    }

    /**
    *Verifica a integridade do array de informações para a redefinicão de senha
    *@return <code>true</code>, se o array estiver íntegro; <code>false</code>, caso contrário
    */
    private function validarFormRedefinir($dados) {
        if(array_key_exists("senha", $dados) && array_key_exists("confirmarSenha", $dados)) {
            return true;
        }
        return false;
    }

    /**
    *Envia o email para a redefinição de senha.
    */
    public function emailRedefinicao() {

        if ($this->validarFormEmail($_POST)) {
            $email = addslashes($_POST["email"]); //Recebe o endereço de e-mail digitado pelo usuário.

            $usuarioDao = new UsuarioDAO();
            $usuario = $usuarioDao->buscar(array(), array("email"=>$email))[0]; //Busca o usuário desejado.
            $nome = $usuario->getNome();

            if ($usuario == null) { //Verifica se o usuário existe.
                throw new UsuarioInexistenteException(); //Caso não exista, lança uma exceção.
            }

            require(ABSPATH.'/plugins/PHPMailer/PHPMailerAutoload.php');

            $id = $usuario->getId(); //Recebe o ID do usuário encontrado.
            
            $linkRedefinir = URI_BASE."/login/redefinir/?e=".md5($email)."&i=".$id; //Gera um link composto pelas informações do usuário.

            $mail = new PHPMailer();

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

            $mail->Subject = 'Sertour - Redefinição de Senha';
            $mail->Body    = "Olá, ".$nome.". Você solicitou uma redefinição de senha.<br/><br/>"
                            ."Por favor, clique no link abaixo e insira sua nova senha: <br/><br/>".
                            "Link de Redefinição: ".$linkRedefinir;

            if (!$mail->send()) {
                throw new EmailNaoEnviadoException();
            }
        } else {
            throw new DadosCorrompidosException();
        }
    }

    /**
    *Redefine a senha.
    */
    public function redefinir() {
        require_once(ABSPATH.'/util/GerenciarSenha.php');

        if($this->validarFormRedefinir($_POST)) {
            $novaSenha = GerenciarSenha::criptografarSenha($_POST["senha"]); //Recebe a nova senha do usuário.
            $confirmarSenha = GerenciarSenha::criptografarSenha($_POST["confirmarSenha"]); //Recebe a confirmação de senha.

            if (!$this->validarSenha($novaSenha) || !$this->validarSenha($confirmarSenha) ) { //Verifica se a nova senha digitada é válida.
                throw new SenhaInvalidaException(); //Caso não seja, lança uma exceção.
            } else if($novaSenha != $confirmarSenha) { //Verifica se a senha e a confirmação são iguais.
                throw new SenhaInconsistenteException(); //Caso não seja, lança uma exceção.
            }
        
            $id = $_GET['i']; //Obtém o ID a partir da URL.
            $email = $_GET['e']; //Obtém o e-mail a partir da URL.

            $usuarioDao = new UsuarioDAO();
            $usuarioDao->alterar(array("senha"=>$novaSenha), array("idUsuario"=>$id)); //Altera a senha do usuário desejado.
        } else {
            throw new DadosCorrompidosException();
        }
    }
}
?>