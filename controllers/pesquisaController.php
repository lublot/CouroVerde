<?php
namespace controllers;

require_once dirname(__DIR__).'/vendor/autoload.php';
use DAO\PesquisaDAO as PesquisaDAO;
use \util\ValidacaoDados as ValidacaoDados;
use \models\Pesquisa as Pesquisa;
use \models\Pergunta as Pergunta;
use \models\OpcaoPergunta as OpcaoPergunta;
use \exceptions\DadosCorrompidosException as DadosCorrompidosException;
use \exceptions\NomeInvalidoException as NomeInvalidoException;
use \exceptions\CampoInvalidoException as CampoInvalidoException;

class PesquisaController extends mainController{

}

?>
