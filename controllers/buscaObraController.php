<?php
namespace controllers;

require_once dirname(__DIR__).'/vendor/autoload.php';
use \DAO\obraDAO as ObraDAO;
use \models\Obra as Obra;
use util\ValidacaoDados as ValidacaoDados;

class BuscaObraController extends mainController {

    /**
    * Realiza a busca de obras a partir dos títulos
    */
    public function buscarObraPorTitulo() {
        if(isset($_POST['titulo'])) {
            $obraDAO = new ObraDAO();
            $resultados = $obraDAO->buscarTituloLike(array(), $_POST['titulo']);

            return json_encode($resultados);

        }
    }

    /**
    * Realiza a busca de obras a partir de tags
    */
    public function buscarObraPorTag() {
        if(isset($_POST['tags'])) {
            $obraDAO = new ObraDAO();
            $resultados = $obraDAO->buscarTituloLike(array(), $_POST['tags']);

            return json_encode($resultados);

        }
    }

}