<?php
namespace controllers;

require_once dirname(__DIR__).'/vendor/autoload.php';
use \DAO\obraDAO as ObraDAO;
use \models\Obra as Obra;
use util\ValidacaoDados as ValidacaoDados;


     function buscarObraPorTitulo($titulo) {
        if(isset($titulo)) {
            $obraDAO = new ObraDAO();
            $resultados = $obraDAO->buscarTituloLike(array(), $titulo);

            var_dump($resultados);

            var_dump(json_encode($resultados));

        }
    }