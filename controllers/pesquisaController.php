<?php
namespace controllers;

require_once dirname(__DIR__).'/vendor/autoload.php';
use DAO\PesquisaDAO as PesquisaDAO;
use DAO\PerguntaDAO as PerguntaDAO;
use DAO\OpcaoDAO as OpcaoDAO;
use \util\ValidacaoDados as ValidacaoDados;
use \models\Pesquisa as Pesquisa;
use \models\Pergunta as Pergunta;
use \models\Opcao as Opcao;
use \models\OpcaoPergunta as OpcaoPergunta;
use \exceptions\DadosCorrompidosException as DadosCorrompidosException;
use \exceptions\NomeInvalidoException as NomeInvalidoException;
use \exceptions\CampoInvalidoException as CampoInvalidoException;
use \exceptions\PerguntaInconsistenteException as PerguntaInconsistenteException;

class PesquisaController extends mainController{

  public function index(){
  
  }
  
  public function criar(){
    
  	$json = $_POST['json'];
    $dadosRecebidos = json_decode($json,true);
  
    if(ValidacaoDados::validarForm($dadosRecebidos,array("tituloPesquisa","descricaoPesquisa"))){
        $tituloPesquisa = array_shift($dadosRecebidos);
        $descricaoPesquisa = array_shift($dadosRecebidos);
        
        
        $perguntas = array(); //Este array vai conter todas as perguntas a serem adicionadas;

        while(count($dadosRecebidos)> 0){ // Itera o array dos dados recebidos para organizar as informações
            $pergunta = array_shift($dadosRecebidos)[0];
            $perguntaFinal = array();

            if(strlen($tituloPesquisa)==0){
              $tituloPesquisa = "Sem título";
            }

            if(strlen($descricaoPesquisa)==0){
              $descricaoPesquisa = "Sem descrição";
            }

            if(empty($pergunta['tipoPergunta'])){
                throw new DadosCorrompidosException();  
            }

            if(strlen($pergunta['tituloPergunta'])==0 || strlen($pergunta['tipoPergunta'])==0){
              throw new PerguntaInconsistenteException();
            }else{
              $tituloPergunta = $pergunta['tituloPergunta'];
              $tipoPergunta = $pergunta['tipoPergunta'];
              $isObrigatorio = $pergunta['obrigatorio'];
            }

            $opcoes;
            
            $perguntaFinal['pergunta']  = new Pergunta(null,$tituloPergunta,$tipoPergunta,$isObrigatorio);

            if(strcmp($tipoPergunta,"Aberta")!=0){// Guarda as opções no array, caso existam
              if(ValidacaoDados::validarForm($pergunta,array("opcoes"))){
                $opcoes = $pergunta['opcoes'];
                $perguntaFinal['opcoes'] = !empty($opcoes)?$opcoes:null;
              }
            }
            
            array_push($perguntas,$perguntaFinal);
        }//Fim do while

        
        //Cria a pesquisa e guarda no banco
        $pesquisa = new Pesquisa(null,$tituloPesquisa,$descricaoPesquisa,false); // Inicializa a pesquisa, ao ser criada a pesquisa ainda não é ativada
        
        $pesquisaDAO = new PesquisaDAO();
        $pesquisaDAO->inserir($pesquisa);

        $pesquisaDAO = new PesquisaDAO(); //Recupera o ID da Pesquisa
        $idPesquisa = $pesquisaDAO->buscar(array("idPesquisa"),array("titulo"=>$tituloPesquisa));
        $idPesquisa = $idPesquisa[0]->getIdPesquisa();

        $perguntaDAO = new PerguntaDAO();
        $opcaoDAO = new OpcaoDAO();
        foreach($perguntas as $pergunta){
          $perguntaDAO->inserir($pergunta['pergunta'],$idPesquisa);
          $idPergunta = $perguntaDAO->getIdUltimaPergunta();
          
          if(isset($pergunta['opcoes'])){// Se a pergunta tiver opções
            $opcoes = $pergunta['opcoes'];
            foreach($opcoes as $opcao){
              $opcaoDAO->inserir(new Opcao(null,$opcao),$idPergunta);
            }
          }
        }
      }else{
        throw new DadosCorrompidosException();
      }
      
  }
  
}

?>