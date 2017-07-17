<?php
namespace controllers;

use DAO\UsuarioDAO as UsuarioDAO;
use util\GerenciarSenha as GerenciarSenha;
use util\ValidacaoDados as ValidacaoDados;
use util\VerificarPermissao as VerificarPermissao;
use exceptions\SenhaIncorretaException as SenhaIncorretaException;

class perfilController extends mainController{
    
    protected $dados = array();

    public function index(){
        if(!isset($_SESSION)){
            session_start();
        }
        if(isset($_SESSION['nome'])){

                try{
                    $this->alterar($_POST);
                    
                }catch(SenhaIncorretaException $e){
                    $this->dados['exception'] = $e->getMessage();
                }
                $this->carregarConteudo('perfil',$this->dados);
        }
        
        
    }

    /**
    * Este método alterar de fato as informações
    * @param dados
    */
    private function alterar($novaInfo){
 
        if(ValidacaoDados::validarForm($novaInfo,array('nome','sobrenome','filtro'))){ // Verifica se o array foi recebido corretamente
            
            $campos = array("nome"=>$novaInfo['nome'],
                            "sobrenome"=>$novaInfo['sobrenome']);

            $filtro = $novaInfo['filtro'];
            $valorFiltro = $novaInfo['valor'];

            if(strcmp($filtro,'tipoUsuario')==0){
                $campos['email'] = $novaInfor['email'];
            }
            
            if(isset($novaInfo['senhaNova']) && !empty($novaInfo['senhaNova'])){ //Verifica se a senha nova foi escolhida            
                if($this->checarUsuarioPorFiltro($novaInfo['filtro'],$novaInfo['valor'],GerenciarSenha::criptografarSenha($novaInfo['senhaAtual']))){
                    
                    $senhaNova = GerenciarSenha::criptografarSenha($novaInfo['senhaNova']); //Adiciona a senha nova aos dados a serem atualizados
                    array_push($campos,$senhaNova);

                    $usuarioDAO = new UsuarioDAO();
                    $usuarioDAO->alterar($campos,array($filtro=>$valorFiltro)); //Atualiza os dados   
                }else{
                    throw new SenhaIncorretaException();
                }
            }else{
                $usuarioDAO = new UsuarioDAO();
                $usuarioDAO->alterar($campos,array($filtro=>$valorFiltro)); //Atualiza os dados
                
            }


            $_SESSION['nome'] = $novaInfo['nome'];
            $_SESSION['sobrenome'] = $novaInfo['sobrenome'];
            $_SESSION['email'] = $novaInfo['email'];

            $this->redirecionarPagina('home');
        }
    }

    /**
    * Este método auxilia o front-end a saber se a senha inserida pelo usuário corresponde à senha atual
    * Caso a senha esteja correta o método envia um JSON informando o sucesso, caso contrário o JSON informa erro
    */
    public function verificarSenhaAtual(){

        if(isset($_POST['filtro']) && isset($_POST['valor']) && ValidacaoDados::validarForm($_POST,array("senhaAtual"))){
            if($this->checarSenhaPorFiltro($_POST['filtro'],$_POST['valor'],GerenciarSenha::criptografarSenha($_POST['senhaAtual']))){
                echo json_encode(array("success"=>true)); 
            }else{
                echo json_encode(array("success"=>false));
            }
        }
               
    }


    /**
    * Este método verifica se os filtros estão setados corretamente, e se as senhas são consistentes
    * @param $filtro - o tipo do filtro usado na busca do usuário
    * @param $valorFiltro - o valor do filtro usado na busca
    * @param $senhaRecebida - a senha recebida (deve estar criptografada)
    */
    private function checarSenhaPorFiltro($filtro,$valorFiltro,$senhaRecebida){
        if(strcmp($filtro,'email') == 0){ // Verifica se o filtro é "Email"
                $usuarioDAO = new UsuarioDAO();
                $usuarioDAO = $usuarioDAO->buscar(array("senha"),array("email"=>$valorFiltro));

                $senhaArmazenada = $usuarioDAO[0]->getSenha();
            
                if(GerenciarSenha::checarSenha($senhaRecebida,$senhaArmazenada)){
                    return true; 
                }

        }else if(strcmp($filtro,'tipoUsuario') == 0){//Verifica se o filtro é "tipoUsuario"
                $usuarioDAO = new UsuarioDAO();
                $usuarioDAO = $usuarioDAO->buscar(array("senha"),array("tipoUsuario"=>$valorFiltro));

                $senhaArmazenada = $usuarioDAO[0]->getSenha();
            
                if(GerenciarSenha::checarSenha($senhaRecebida,$senhaArmazenada)){
                    return true;
                }
        }else{
            return false;
        }
    }

}
?>