<?php
namespace controllers;
use util\ValidacaoDados as ValidacaoDados;
use exceptions\NivelDeAcessoInsuficienteException as NivelDeAcessoInsuficienteException;
use DAO\FuncionarioDAO as FuncionarioDAO;
class adminController extends mainController{

    private $POST = array('senhaAdmin'=>'abs','matriculaFuncionario'=>'15111157');




    public function listarTodosFuncionarios(){
        if(isset($_SESSION['tipoUsuario']) && !empty($_SESSION['tipoUsuario'])){
            if($_SESSION['tipoUsuario'] == 'Administrador'){
                $funcionarioDAO = new FuncionarioDAO(); // não seria "funcionarioDAO"?
                $funcionarios = $funcionarioDAO->buscar();

                echo json_encode($funcionarios);
            }
        }
    }

}


?>