<?php
namespace controllers;
use util\ValidacaoDados as ValidacaoDados;
use exceptions\NivelDeAcessoInsuficienteException as NivelDeAcessoInsuficienteException;
use DAO\FuncionarioDAO as FuncionarioDAO;
class adminController extends mainController{

    private $POST = array('senhaAdmin'=>'abs','matriculaFuncionario'=>'15111157');

    public function gerenciarFuncionario(){
       if(isset($_SESSION['tipoUsuario']) && !empty($_SESSION['tipoUsuario'])){
           if($_SESSION['tipoUsuario'] == 'Administrador'){
                if(ValidacaoDados::validarForm($this->POST,array('matricula','funcao'))){
                    
                    $matricula = $this->POST['matricula'];
                    $funcao = $this->POST['funcao'];
                    $podeCadastrarObra = false; $podeEditarObra = false;
                    $podeRemoverObra = false; $podeCadastrarNoticia = false;
                    $podeRemoverNoticia = false; $podeEditarNoticia = false;
                    $podeRealizarBackup = false;

                    if(isset($this->POST['cadastrar-obra'])){
                        $podeCadastrarObra = true;
                    }
                    if(isset($this->POST['editar-obra'])){
                        $podeEditarObra = true;
                    }
                    if(isset($this->POST['remover-obra'])){
                        $podeRemoverObra = true;
                    }
                    if(isset($this->POST['cadastrar-noticia'])){
                        $podeCadastrarNoticia = true;
                    }
                    if(isset($this->POST['editar-noticia'])){
                        $podeEditarNoticia = true;
                    }
                    if(isset($this->POST['remover-noticia'])){
                        $podeRemoverNoticia = true;
                    }
                    if(isset($this->POST['realizar-backup'])){
                        $podeRealizarBackup = true;
                    }
                
                $campos = array('funcao'=>$funcao,
                                'cadastraObra'=> $podeCadastrarObra ? 1:0,
                                'gerenciaObra'=> $podeEditarObra ? 1:0,
                                'remocaoObra'=>$podeRemoverObra ? 1:0,
                                'cadastraNoticia'=>$podeCadastrarNoticia ? 1:0,
                                'gerenciaNoticia'=>$podeEditarNoticia ? 1:0,
                                'remocaoNoticia'=>$podeRemoverNoticia ? 1:0,
                                'backup'=>$podeRealizarBackup ? 1:0);

                $funcionarioDAO = new FuncionarioDAO();
                $funcionarioDAO->alterar($campos,array('matricula'=>$matricula)); 
                }else{
                    throw new NivelDeAcessoInsuficienteException();
                }
           }
        }
    }

    protected function removerFuncionario(){
        if(isset($_SESSION['tipoUsuario']) && !empty($_SESSION['tipoUsuario'])){
          if($_SESSION['tipoUsuario'] == 'Administrador'){
                if(ValidacaoDados::validarForm($this->POST,array('senhaAdmin','matriculaFuncionario'))){
                    
                    $matricula = $this->POST['matriculaFuncionario'];
                    $senha = md5($this->POST['senhaAdmin']);

                    $adminDAO = new AdministradorDAO();
                    $adminDAO = $adminDAO->buscar(array('senhaAdmin',array()));
                    $senhaArmazenada = $adminDAO[0]->getSenhaAdmin();


                    if(strcmp($senhaArmazenada,$senha)==0){// Se a senha do administrador estiver correta, IMPLEMENTAR....
                        $funcionarioDao = new FuncionarioDAO();
                        $funcionarioDao->remover(array('matricula'=>$matricula));
                    }else{
                        throw new SenhaIncorretaException();
                    }
                }
           }else{
                throw new NivelDeAcessoInsuficienteException();
           }
        }
    }


    public function listarTodosFuncionarios(){
        if(isset($_SESSION['tipoUsuario']) && !empty($_SESSION['tipoUsuario'])){
            if($_SESSION['tipoUsuario'] == 'Administrador'){
                $funcionarioDAO = new FuncionarioDAO();
                $funcionarios = $funcionarioDAO->buscar();

                echo json_encode($funcionarios);
            }
        }
    }

}


?>