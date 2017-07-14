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

class Pesquisas extends mainController {

    public function criarPesquisa(){
        if (ValidacaoDados::validarForm($_POST, array("tituloPesquisa","estaAtiva", "tituloPergunta", "tipo", "opcional"))) {
            
            if (!ValidacaoDados::validarNome($_POST["tituloPesquisa"])) {
                    throw new NomeInvalidoException();
            }
            if (!ValidacaoDados::validarNome($_POST["titulopergunta"])) {
                    throw new NomeInvalidoException();
            }

            $tituloPesquisa = addslashes($_POST['tituloPesquisa']);
            $estaAtiva = $_POST['estaAtiva'];

            $tituloPergunta = addslashes($_POST['tituloPergunta']);
            $tipo = addslashes($_POST['tipo']);
            $opcional = $_POST['opcional'];

            $pesquisa = new Pesquisa(null, $tituloPesquisa, $estaAtiva);
            $pergunta = new Pergunta(null, $tituloPergunta, $tipo, $opcional);
            $opcaoPergunta = new OpcaoPergunta(null, $descricao);

            $pesquisaDAO = new PesquisaDAO();
            $perguntaDAO = new PerguntaDAO();
            $opcaoPerguntaDAO = new OpcaoPerguntaDAO();

            $pesquisaDAO->inserir($pesquisa);
            $perguntaDAO->inserir($pergunta);
            $opcaoPerguntaDAO->inserir($opcaoPergunta);
        }
        else{
            throw new DadosCorrompidosException();
        }
    }
}

?>