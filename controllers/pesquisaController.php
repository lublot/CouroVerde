<?php
namespace controllers;

require_once dirname(__DIR__).'/vendor/autoload.php';
use DAO\PesquisaDAO as PesquisaDAO;
use \util\ValidacaoDados as ValidacaoDados;
use \models\Pesquisa as Pesquisa;
use \models\Pergunta as Pergunta;
use \models\OpcaoPergunta as OpcaoPergunta;

class Pesquisas extends mainController {

    public function criarPesquisa(){

        $titulo = addslashes($_POST['titulo']);
        $opcional = $_POST['opcional'];
        $pergunta = new Pergunta(null, $titulo, $tipo, $opcional);
    }
}

?>