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

class PesquisaController extends mainController {

    private $listaPerguntas;
    private $listaOpcoes;

    public function __construct(){
        $this->listaPerguntas = array();
        $this->listaOpcoes = array();
    }

    public function configuraAmbienteParaTeste($tituloPesquisa, $estaAtiva, $tituloPergunta, $isOpcional, $tipo) {
        $_POST["tituloPesquisa"] = $tituloPesquisa;
        $_POST["estaAtiva"] = $estaAtiva;
        $_POST["tituloPergunta"] = $tituloPergunta;
        $_POST["opcional"] = $isOpcional;
        $_POST["tipo"] = $tipo;
        //$_POST["descricao"] = $estaAtiva;
    }

    /**
    * Realiza o cadastro de uma pesquisa.
    */
    public function cadastrarPesquisa(){
        $pesquisa = $this->criarPesquisa();
        $listaPerguntas = $this->criarPergunta();
        $listaOpcoes = $this->criarOpcao();

        $pesquisaDAO = new PesquisaDAO();
        $perguntaDAO = new PerguntaDAO();
        $opcaoDAO = new OpcaoDAO();

        $pesquisaDAO->inserir($pesquisa);
        $perguntaDAO->inserir($listaPerguntas);
        $opcaoDAO->inserir($listaOpcoes);
    }

    public function criarPesquisa(){
        if (ValidacaoDados::validarForm($_POST, array("tituloPesquisa","estaAtiva"))) {
            if (!ValidacaoDados::validarNome($_POST["tituloPesquisa"])) {
                    throw new NomeInvalidoException();
            }
            if(!isset($_POST["estaAtiva"])){
                throw new CampoInvalidoException();
            }

            $tituloPesquisa = addslashes($_POST['tituloPesquisa']);
            $estaAtiva = $_POST['estaAtiva'];

            $pesquisa = new Pesquisa(null, $tituloPesquisa, $estaAtiva);

            return $pesquisa;
        }
        else{
            throw new DadosCorrompidosException();
        }
    }

    public function criarPergunta(){
        if (ValidacaoDados::validarForm($_POST, array("tituloPergunta", "tipo", "opcional"))) {
            if (!ValidacaoDados::validarNome($_POST["tituloPergunta"])) {
                throw new NomeInvalidoException();
            }
            if(!isset($_POST["opcional"])){
                throw new CampoInvalidoException();
            }
            if (!isset($_POST["tipo"])) {
                throw new CampoInvalidoException();
            }

            $tituloPergunta = addslashes($_POST['tituloPergunta']);
            $opcional = $_POST['opcional'];

            if($_POST['tipo'] == "1"){
                $tipo = "MULTIPLA ESCOLHA";
            }
            if($_POST['tipo'] == "2"){
                $tipo = "ABERTA";
            }
            if($_POST['tipo'] == "3"){
                $tipo = "UNICA ESCOLHA";
            }

            $i = 0;
            $listaPerguntas[$i++] = new Pergunta(null, $tituloPergunta, $tipo, $opcional);

            return $listaPerguntas;
        }
        else{
            throw new DadosCorrompidosException();
        }
    }

    public function criarOpcao(){
        if (ValidacaoDados::validarForm($_POST, array("descricao"))) {
            $descricao = addslashes($_POST['descricao']);

            $i = 0;
            $listaOpcoes[$i++] = new Opcao(null, $descricao);

            return $listaOpcoes;
        }
        else{
            throw new DadosCorrompidosException();
        }
    }
}

?>