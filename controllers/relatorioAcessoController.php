<?php
namespace controllers;

require_once dirname(__DIR__).'/vendor/autoload.php';
use \models\RegistroVisitasObra as registroVisitasObra;
use \DAO\usuarioAcessoDAO as usuarioAcessoDAO;
use \models\Obra as Obra;
use \DAO\obraDAO as obraDAO;


class relatorioAcessoController extends mainController {

    private $obraMaisVisitada;
    private $obraMenosVisitada;
    private $registrosVisitasObras;

    public function gerarRelatorioAcesso() {

    }

    private function montarRegistros() {
        $obraDAO = new obraDAO();
        $todasObras = $obraDAO()->buscar(array("numeroInventario"), array()); //obtém o número de inventário de todas as obras

        $usuarioAcessoDAO = new usuarioAcessoDAO();     

        foreach($todasObras as $obra) {
           $visitasObras[] = $usuarioAcessoDAO->buscar(array(), $obra->getNumInventario());
        }

        foreach($visitasObras as $visitasObra) {
            $registrosVisitasObras[] = new RegistroVisitasObra($visitasObra[0]->getNumeroInventario(), count($visitasObra));
        }

        return $registrosVisitasObras;
    }



}