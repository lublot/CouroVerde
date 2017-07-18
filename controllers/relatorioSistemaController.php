<?php
namespace controllers;

require_once dirname(__DIR__).'/vendor/autoload.php';

use \DAO\RelatorioSistemaDAO as RelatorioSistemaDAO;

class relatorioSistemaController extends mainController{

    public function configuraAmbienteParaTeste($filtro, $valor) {
        $_POST['filtro'] = $filtro;
        $_POST['valor'] = $valor;
    }

    /**
    * Este método oferece todos os relatorios do sistema;
    */
    public function listarTodosRelatorios(){
        $relatorioDAO = new RelatorioSistemaDAO();
        $resultado = $relatorioDAO->buscar(array(),array());

        return $resultado;
        //echo json_encode($relatorioDAO);
    }

    /**
    * Este método oferece um ou vários relatórios com base em um critério de busca
    */
    public function listarRelatoriosEspecificos(){
        try{
            if(isset($_POST['filtro']) && isset($_POST['valor'])){
                $relatorioDAO = new RelatorioSistemaDAO();
                $resultado = $relatorioDAO->buscar(array(),array($_POST['filtro'] => $_POST['valor']));

                return $resultado;
                //echo json_encode($resultado);
            }
        }catch(RelatorioNaoEspecificadoException $e){
            throw $e;
        }
    }
}
?>