<?php
namespace controllers;

require_once dirname(__DIR__).'/vendor/autoload.php';

use DAO\FuncionarioDAO as FuncionarioDAO;
use DAO\RelatorioSistemaDAO as RelatorioSistemaDAO;
use models\RelatorioSistema as RelatorioSistema;

class LogController extends mainController {

    public function configuraAmbienteParaTeste($email){
        $_SESSION['email'] = $email;
    }

    public function registrarEvento($idItem, $tipoItem, $acao){
        var_dump($_SESSION);
        $emailUsuario = $_SESSION['email'];

        $funcionarioDAO = new FuncionarioDAO();
        $encontrado = $funcionarioDAO->buscar(array('matricula'), array('email' => $emailUsuario));
        $matriculaFuncionario = $encontrado[0]->getMatricula();

        $relatorioSistema = new RelatorioSistema(null, $matriculaFuncionario, $idItem, $tipoItem, $acao, null);

        $relatorioSistemaDAO = new RelatorioSistemaDAO();
        $relatorioSistemaDAO->inserir($relatorioSistema);
    }
}

?>