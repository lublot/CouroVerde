<?php
namespace controllers;
use util\VerificarPermissao as VerificarPermissao;
use exceptions\NivelDeAcessoInsuficienteException as NivelDeAcessoInsuficienteException;

if(!isset($_SESSION)){session_start();}
class adminController extends mainController{

    public function index(){
        if(VerificarPermissao::isAdministrador() || VerificarPermissao::isFuncionario()){
            $this->carregarConteudo('homeAdmin',array());
        }else{
            $this->permissaoNegada();
        } 
    }

}


?>