<?php
namespace controllers;

require_once dirname(__DIR__).'/vendor/autoload.php';


use util\VerificarPermissao as VerificarPermissao;
use \DAO\ObraDAO as ObraDAO;
use \DAO\FuncionarioDAO as FuncionarioDAO;
use \DAO\BackupDAO as BackupDAO;
use \DAO\NoticiaDAO as NoticiaDAO;
use \DAO\UsuarioDAO as UsuarioDAO;
use \DAO\RelatorioSistemaDAO as RelatorioSistemaDAO;
class relatorioSistemaController extends mainController{

    public function configuraAmbienteParaTeste($filtro, $valor) {
        $_POST['filtro'] = $filtro;
        $_POST['valor'] = $valor;
    }

    public function index(){
        if(VerificarPermissao::isAdministrador()){
            $this->carregarConteudo('relatorioSistema',array());
        }else{
            $this->permissaoNegada();
        }
    }
    /**
    * Este método oferece todos os relatorios do sistema;
    */
    public function listarTodosRelatorios(){
        $relatorioDAO = new RelatorioSistemaDAO();
        $resultados = $relatorioDAO->buscar(array(),array());
        $processando = array();

        foreach($resultados as $resultado){
            if(strcmp($resultado->getTipoAlvo(),"OBRA")==0){
                $frase = array();
                $obraDAO = new ObraDAO();
                $obra = $obraDAO->buscar(array('titulo'),array('numeroInventario'=>$resultado->getIdAlvo()));

                if(count($obra) > 0){
                    $frase['tipoAlvo'] = 'a Obra';
                    $frase['nomeAlvo'] = $obra[0]->getTitulo();
                }else{
                    $frase['tipoAlvo'] = 'uma obra';
                    $frase['nomeAlvo'] = "";
                }

                $frase['autor'] = $resultado->getAutor();
                $frase['acao'] = ucfirst(strtolower($resultado->getAcao()));
                
                
                $frase['horario'] = $resultado->getHorario();
                array_push($processando,$frase);
            }else if(strcmp($resultado->getTipoAlvo(),"FUNCIONARIO")==0){
                $frase = array();
                $funcionarioDAO = new FuncionarioDAO();
                $funcionario = $funcionarioDAO->buscar(array('idUsuario'),array('matricula'=>$resultado->getIdAlvo()));
                $usuarioDAO = new UsuarioDAO();
                $usuarioDAO = $usuarioDAO->buscar(array('nome','sobrenome'),array('idUsuario'=>$funcionario[0]->getId()));
                if(count($funcionario) > 0){
                    $frase['tipoAlvo'] = 'o Funcionário';
                    $frase['nomeAlvo'] = $usuarioDAO[0]->getNome().' '.$usuarioDAO[0]->getSobrenome();
                }else{
                    $frase['tipoAlvo'] = 'um funcionário';
                    $frase['nomeAlvo'] = "";
                }
                $frase['autor'] = $resultado->getAutor();
                $frase['acao'] = ucfirst(strtolower($resultado->getAcao()));
                $frase['horario'] = $resultado->getHorario();
                array_push($processando,$frase);
            }else if(strcmp($resultado->getTipoAlvo(),"NOTICIA")==0){
                $frase = array();
                $noticiaDAO = new NoticiaDAO();
                $noticia = $noticiaDAO->buscar(array('titulo'),array('idNoticia'=>$resultado->getIdAlvo()));

                if(count($noticia) > 0){
                    $frase['tipoAlvo'] = 'a Notícia';
                    $frase['nomeAlvo'] = '"'.$noticia[0]->getTitulo().'"';
                }else{
                    $frase['tipoAlvo'] = 'uma notícia';
                    $frase['nomeAlvo'] = "";
                }
                
                $frase['autor'] = $resultado->getAutor();
                $frase['acao'] = ucfirst(strtolower($resultado->getAcao()));
                
                $frase['horario'] = $resultado->getHorario();
                array_push($processando,$frase);
            }else if(strcmp($resultado->getTipoAlvo(),"BACKUP")==0){
                $frase = array();
                $backupDAO = new BackupDAO();
                $backup = $backupDAO->buscar(array(),array('idBackup'=>$resultado->getIdAlvo()));

                if(count($backup) > 0){
                    $frase['autor'] = $resultado->getAutor();
                    $frase['acao'] = ucfirst(strtolower($resultado->getAcao()));
                    $frase['tipoAlvo'] = 'o Backup';
                    $frase['nomeAlvo'] = 'backup_'.$backup[0]->getHora();
                    $frase['horario'] = $resultado->getHorario();
                }else{
                    $frase['autor'] = "";
                    $frase['acao'] = "";
                    $frase['tipoAlvo'] = "";
                    $frase['nomeAlvo'] = "";
                    $frase['horario'] = "";
                }

                
                array_push($processando,$frase);
            }
        }

        echo json_encode($processando);
    }

    /**
    * Este método oferece um ou vários relatórios com base em um critério de busca
    */
    public function listarRelatoriosEspecificos(){
        try{
            if(isset($_POST['filtro']) && isset($_POST['valor'])){
                $relatorioDAO = new RelatorioSistemaDAO();
                $resultado = $relatorioDAO->buscar(array(),array($_POST['filtro'] => $_POST['valor']));

                echo json_encode($resultado);
            }
        }catch(RelatorioNaoEspecificadoException $e){
            throw $e;
        }
    }

}
?>