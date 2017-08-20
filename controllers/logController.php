<?php
namespace controllers;

require_once dirname(__DIR__).'/vendor/autoload.php';

use DAO\FuncionarioDAO as FuncionarioDAO;
use DAO\RelatorioSistemaDAO as RelatorioSistemaDAO;
use models\RelatorioSistema as RelatorioSistema;

if(!isset($_SESSION)){session_start();}
class LogController extends mainController {

    public function registrarEvento($idItem, $tipoItem, $acao){
        $idUsuario = $_SESSION['id'];

        $funcionarioDAO = new FuncionarioDAO();
        $encontrado = $funcionarioDAO->buscar(array('matricula'), array('idUsuario' => $idUsuario));
        $matriculaFuncionario = $encontrado[0]->getMatricula();

        $relatorioSistema = new RelatorioSistema(null, $matriculaFuncionario, $idItem, $tipoItem, $acao, null);

        $relatorioSistemaDAO = new RelatorioSistemaDAO();
        $relatorioSistemaDAO->inserir($relatorioSistema);
    }
}

?>