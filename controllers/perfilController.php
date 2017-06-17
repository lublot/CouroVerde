<?php

class perfilController{
    
    public function index(){
        session_start();
        $id = $_SESSION['id'];
        $nome = $_SESSION['nome'];
        $sobrenome = $_SESSION['sobrenome'];

        if(isset($_POST) && !empty($_POST)){
            $this->alterar($_POST);
        } 
    }

    private function alterar($dados){
        session_start();
        if($this->validarForm($dados)){
            $usuarioDao = new UsuarioDAO();
            $usuarioDao->alterar(array("nome"=>$dados['nome'],"sobrenome"=>$dados['sobrenome']),array("idUsuario"=>$_SESSION['id']));
        }else{
            throw new DadosCorrompidosException();
        }
    }


    private function validarForm($dados){
        if(array_key_exists("nome",$dados) || array_key_exists("sobrenome",$dados)){
            return true;
        }
        return false;
    }

}
?>