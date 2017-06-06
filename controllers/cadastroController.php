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
            if($this->validarCampo($dados['nome']) && $this->validarCampo($dados['sobrenome']) && $this->validarCampo($dados['senha']) && $this->validarCampo($dados['email'])){
                require(ABSPATH.'/plugins/PHPMailer/PHPMailerAutoload.php');
                
                $nome = addslashes($dados['nome']);
                $sobrenome = addslashes($dados['sobrenome']);
                $email = addslashes($dados['email']);
            
                $linkConfirmacao = URI_BASE."/cadastro/verificar/?n=".md5($nome)."&e=".md5($email)."&s=".md5($sobrenome);
                
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
        $nome = $_GET['n'];
        $email = $_GET['e'];
        $sobrenome = $_GET['s'];
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

 
}
?>