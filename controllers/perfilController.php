<?php
namespace controllers;

use DAO\UsuarioDAO as UsuarioDAO;
use util\GerenciarSenha as GerenciarSenha;
use util\ValidacaoDados as ValidacaoDados;

class perfilController{
    
    public function index(){
        if(isset($_SESSION)){
            $id = $_SESSION['id'];
            $nome = $_SESSION['nome'];
            $sobrenome = $_SESSION['sobrenome'];

            if(isset($_POST) && !empty($_POST)){
                $this->alterar($_POST);
            }     
        }
        
        
    }

    private function alterar($dados){
        if($this->validarForm($dados)){
            $usuarioDao = new UsuarioDAO();
            $usuarioDao->alterar(array("nome"=>$dados['nome'],"sobrenome"=>$dados['sobrenome']),array("idUsuario"=>$_SESSION['id']));
        }else{
            throw new DadosCorrompidosException();
        }
    }


    public function verificarSenhaAtual(){
        if(ValidacaoDados::validarForm($_POST,array("senhaAtual","email"))){
            $usuarioDAO = new UsuarioDAO();
            $usuarioDAO = $usuarioDAO->buscar(array("senha"),array("email"=>$_POST['email']));

            $senhaRecebida = GerenciarSenha::criptografarSenha($_POST['senhaAtual']);
            $senhaArmazenada = $usuarioDAO[0]->getSenha();
            
            if(GerenciarSenha::checarSenha($senhaRecebida,$senhaArmazenada)){
                echo json_encode(array("success"=>true)); 
            }
        }
        echo json_encode(array("success"=>false));
    }

}
?>