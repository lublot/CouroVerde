<?php

class cadastroController{
	
	private $POST = array("nome" => "Fulano",
			"sobrenome" => "De Tal",
			"email" => "ebssoueu@gmail.com",
			"senha" => "12345678");//Como a gnt não tem view ainda, vamos testando as informações nesse array
	
	
	public function index(){
		echo "Ola ".$this->POST['nome'];
	}
	
	public function confirmar($dados = array()){
		$dados = $this->POST;
		if($this->validarForm($dados)){
			if($this->validarCampo($dados['nome']) && $this->validarCampo($dados['sobrenome'])
					&& $this->validarCampo($dados['senha']) && $this->validarCampo($dados['email'])
					&& $this->validarCampo($dados['id'])){
						
						
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
										
										
										if(!$mail->send()) {
											echo 'Message could not be sent.';
											echo 'Mailer Error: ' . $mail->ErrorInfo;
										} else {
											
										}
			}
		}
	}
	
	public function verificar(){
		$id = $_GET['i'];
		$nome = $_GET['n'];
		$email = $_GET['e'];
		$sobrenome = $_GET['s'];
		
		$usuarioDao = new UsuarioDAO();
		$usuario = $usuarioDao->buscar(null,array("idUsuario"=>$id));
		
		if(count($usuario)>0){
			$usuario = array_shift($usuario);
			$id = $usuario->getId();
			$nomeMd5 = md5($usuario->getNome());
			$emailMd5 = md5($usuario->getEmail());
			$sobrenomeMd5 = md5($usuario->getSobrenome());
			
			if(strcmp($nome,$nomeMd5)==0 && strcmp($email,$emailMd5)==0 && strcmp($sobrenome,$sobrenomeMd5)==0){
				$usuario->setconfirmouCadastro(true);
				$usuarioDao->alterar(array('confirmouCadastro'=>$usuario->confirmouCadastro()),array('idUsuario'=>$usuario->getId()));
			}
		}
		
		
	}
	private function validarForm($dados){//Verifica a integridade do array de informações recebidas
		if(array_key_exists("nome",$dados) && array_key_exists("sobrenome",$dados) && array_key_exists("email",$dados) && array_key_exists("senha",$dados)){
			return true;
		}
		return false;
	}
	
	
	private function validarCampo($campo){//Verifica se determinado campo está vazio
		if(isset($campo) && !empty($campo)){
			return true;
		}
		return false;
	}

	/**
	* Verifica se o email informado é válido.
	* @return <code>true</code>, se o email informado for válido; <code>false</code>, caso contrário.
	*/
	private function validarEmail($email) {
		if(!$this->validarCampo($email)) {
			return false;
		}
		
		$dividido = explode("@", $email); //tenta dividir o email a partir da @
		
		if (count($dividido) == 2) { //verifica se o email informado possui @
			$segundaparte = explode(".com", $dividido[1]); //tenta encontrar .com na segunda parte do email
			
			if(count($segundaparte) == 2) { //verifica se tem apenas um .com no email
				return true;
			}
		} 

		return false;
	}

	/**
	* Cadastra novo usuário.
	*/
	public function cadastrar() {
		$usuarioDAO = new UsuarioDAO();
		$nome = $_POST["nome"];
		$sobrenome = $_POST["sobrenome"];
		$senha = $_POST["senha"];
		$email = $_POST["email"];

		if($this->validarCampo($nome) && $this->validarCampo($sobrenome) && $this->validarCampo($senha) && $this->validarEmail($email)) {
			$usuarioDAO->inserir(new Usuario($nome, $sobrenome, $senha, $email));
		} else {
			//VOU OLHAR COMO FAZ EXCEÇÃO EM PHP PRA INSERIR UMA NO CASO DOS CAMPOS NÃO SEREM VÁLIDOS
		}

		$this->confirmar(array("nome" => $nome, "sobrenome" => $sobrenome, "senha" => $senha, "email" => $email));
		
	}
}
?>