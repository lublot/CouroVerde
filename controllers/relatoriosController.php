<?php
namespace controllers;

require_once dirname(__DIR__).'/vendor/autoload.php';

use \DAO\RelatorioSistemaDAO as RelatorioSistemaDAO;
use util\VerificarPermissao as VerificarPermissao;
class relatoriosController extends mainController{

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

    public function acesso(){

    }

    public function sistema(){
        if(VerificarPermissao::isAdministrador()){
            $this->carregarConteudo('relatorioSistema',array());
        }else{
            $this->permissaoNegada();
        }
    }
}
?>