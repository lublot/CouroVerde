<?php

class cadastroController
{
    
    private $POST = array("nome" => "Fulano",
            "sobrenome" => "De Tal",
            "email" => "ebssoueu@gmail.com",
            "senha" => "12345678");//Como a gnt não tem view ainda, vamos testando as informações nesse array
    
    
    /**
    * Cadastra novo usuário.
    */
    public function index() {
        require_once(ABSPATH.'/util/GerenciarSenha.php');
        
        if ($this->validarForm($_POST)) {
            $usuarioDAO = new UsuarioDAO();
            $nome = addslashes($_POST["nome"]);
            $sobrenome = addslashes($_POST["sobrenome"]);
            $senha = GerenciarSenha::criptografarSenha($_POST["senha"]);
            $email = addslashes($_POST["email"]);

            if (!$this->validarNome($sobrenome)) {
                throw new NomeInvalidoException();
            }

            if (!$this->validarNome($sobrenome)) {
                throw new SobrenomeInvalidoException();
            }
                
            if (!$this->validarSenha($senha)) {
                throw new SenhaInvalidaException();
            }
                
            if (!$this->validarEmail($email)) {
                throw new EmailInvalidoException();
            }

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
        if ($this->validarForm($dados)) { //essa validação já foi feita anteriormente, precisa fazer de novo?
            //Acho que as validações abaixo são desnecessárias pq já foram feitas no método anterior.
            //Se os campos abaixo forem inválidos retornam exceções
            if (!$this->validarNome($dados['nome'])) {
                throw new NomeInvalidoException();
            }

            if (!$this->validarNome($dados['sobrenome'])) {
                throw new SobrenomeInvalidoException();
            }

            if (!$this->validarCampo($dados['senha'])) {
                throw new SenhaInvalidaException();
            }

            if (!$this->validarCampo($dados['email'])) {
                throw new EmailInvalidoException();
            }

            if (!$this->validarCampo($dados['id'])) {
                throw new DadosCorrompidosException();
            }

            require(ABSPATH.'/plugins/PHPMailer/PHPMailerAutoload.php');
            
            $id = addslashes($dados['id']);
            $nome = addslashes($dados['nome']);
            $sobrenome = addslashes($dados['sobrenome']);
            $email = addslashes($dados['email']);
            
            $linkConfirmacao = URI_BASE."/cadastro/verificar/?n=".md5($nome)."&e=".md5($email)."&i=".$id."&s=".md5($sobrenome);
            
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
	

    public function cadastrarUsuarioGoogle($usuarioGoogle){
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

    /**
    *Verifica a integridade do array de informações recebidas
    *@return <code>true</code>, se o array estiver íntegro; <code>false</code>, caso contrário
    */
    private function validarForm($dados) {
        if (array_key_exists("nome", $dados) && array_key_exists("sobrenome", $dados) && array_key_exists("email", $dados) && array_key_exists("senha", $dados)) {
            return true;
        }
        return false;
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
    * Verifica se o nome informado é válido.
    * @return <code>true</code>, se o nome informado for válido; <code>false</code>, caso contrário
    */
    private function validarNome($nome) {
        if (!$this->validarCampo($nome)) {
            return false;
        }
        if (preg_match("([^ A-Za-zà-ú'])", $nome) > 0) { //O nome só pode conter letras e caracteres acentuados,espaços e aspas simples
            return false;
        }
        return true;
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

}
